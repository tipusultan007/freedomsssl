<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Accounts\AdvanceAccount;
use App\Http\Controllers\Accounts\AdvanceAdjustAccount;
use App\Http\Controllers\Accounts\DpsAccount;
use App\Http\Controllers\Accounts\DpsLoanPaymentAccount;
use App\Http\Controllers\Accounts\DueAccount;
use App\Http\Controllers\Accounts\DueReturnAccount;
use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Imports\DpsInstallmentImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\DepositInstallment;
use App\Models\DpsCollection;
use App\Models\DpsLoanCollection;
use App\Models\Dps;
use App\Models\DpsLoanInterest;
use App\Models\Due;
use App\Models\LoanPayment;
use App\Models\TakenLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DpsLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use App\Http\Requests\DpsInstallmentStoreRequest;
use App\Http\Requests\DpsInstallmentUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class DpsInstallmentController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //$this->authorize('view-any', DpsInstallment::class);
    $breadcrumbs = [
      ['name' => 'DPS Installment']
    ];
    return view('app.dps_installments.index', compact('breadcrumbs'));
  }

  public function dataDpsInstallment(Request $request)
  {
    $totalData = DpsInstallment::query();

    if (!empty($request->account)) {
      $totalData->where('account_no', $request->account);
    }

    if (!empty($request->collector)) {
      $totalData->where('manager_id', $request->collector);
    }

    if (!empty($request->from) && !empty($request->to)) {
      $totalData->whereBetween('date', [$request->from, $request->to]);
    }

    $totalData = $totalData->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    if (empty($request->input('search.value'))) {

      $query = DpsInstallment::with('user', 'manager');

      if (!empty($request->account)) {
        $query->where('account_no', $request->account);
      }

      if (!empty($request->collector)) {
        $query->where('manager_id', $request->collector);
      }

      if (!empty($request->from) && !empty($request->to)) {
        $query->whereBetween('date', [$request->from, $request->to]);
      }

      $posts = $query->offset($start)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = DpsInstallment::with('user', 'manager')
        ->where(function ($query) use ($search) {
          $query->where('dps_installments.account_no', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function ($query) use ($search) {
              $query->where('name', 'LIKE', "%{$search}%");
            });
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();

      $totalFiltered = DpsInstallment::where(function ($query) use ($search) {
        $query->where('account_no', 'LIKE', "%{$search}%")
          ->orWhereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
          });
      })->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('dps-installments.show', $post->id);
        $edit = route('dps-installments.edit', $post->id);


        $date = new Carbon($post->date);
        $nestedData['id'] = $post->id;
        $nestedData['sent'] = $post->is_sms_sent;
        $nestedData['dps_id'] = $post->dps_id;
        $nestedData['interest'] = $post->interest;
        $nestedData['total'] = $post->total;
        $nestedData['dps_loan_id'] = $post->dps_loan_id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['dps_amount'] = $post->dps_amount;
        $nestedData['loan_installment'] = $post->loan_installment;
        $nestedData['date'] = $date->format('d/m/Y');
        $nestedData['loan_late_fee'] = $post->loan_late_fee;
        $nestedData['loan_other_fee'] = $post->loan_other_fee;
        $nestedData['late_fee'] = $post->late_fee;
        $nestedData['due'] = $post->due;
        $nestedData['due_return'] = $post->due_return;
        $nestedData['other_fee'] = $post->other_fee;
        $nestedData['dps_balance'] = $post->dps_balance;
        $nestedData['loan_balance'] = $post->loan_balance;
        $nestedData['dps_note'] = $post->dps_note;
        $nestedData['loan_note'] = $post->loan_note;
        $nestedData['collector'] = $post->manager->name??'';
        $nestedData['collection_id'] = $post->collection_id;

        $data[] = $nestedData;


      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    //$this->authorize('create', DpsInstallment::class);

    $users = User::pluck('name', 'id');
    $allDps = Dps::pluck('account_no', 'id');
    $dpsLoans = DpsLoan::pluck('account_no', 'id');

    return view(
      'app.dps_installments.create',
      compact('users', 'allDps', 'users', 'dpsLoans')
    );
  }

  /**
   * @param \App\Http\Requests\DpsInstallmentStoreRequest $request
   * @return string
   */
  public function store(Request $request)
  {

    $data = $request->all();
    $data['manager_id'] = Auth::guard('manager')->user()->id;
    $data['trx_id'] = Str::uuid();

    $installment = DpsInstallment::create($data);

    $data['trx_type'] = $request->deposited_via;
    $data['name'] = $installment->user->name;
    $loan_taken_id = array_key_exists("loan_taken_id", $data) ? $data['loan_taken_id'] : '';
    $interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
    $taken_interest = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';

    if ($installment->dps_amount > 0) {
      $dps = Dps::find($installment->dps_id);
      if ($installment->dps_installments == 1) {
        $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
        if ($dpsCollections > 0) {
          $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
          $date->addMonthsNoOverflow($dpsCollections);
          $dps->balance += $installment->dps_amount;
          $dps->deposited += $installment->dps_amount;
          $dps->save();
          $dpsCollection = DpsCollection::create([
            'account_no' => $installment->account_no,
            'user_id' => $installment->user_id,
            'late_fee' => $installment->late_fee,
            'other_fee' => $installment->other_fee,
            'dps_id' => $installment->dps_id,
            'dps_amount' => $installment->dps_amount,
            'balance' => $dps->balance,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $installment->date,
            'manager_id' => $installment->manager_id,
            'dps_installment_id' => $installment->id,
          ]);
        } else {
          $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
          $dps->balance += $installment->dps_amount;
          $dps->deposited += $installment->dps_amount;
          $dps->save();
          $dpsCollection = DpsCollection::create([
            'account_no' => $installment->account_no,
            'user_id' => $installment->user_id,
            'dps_id' => $installment->dps_id,
            'late_fee' => $installment->late_fee,
            'other_fee' => $installment->other_fee,
            'dps_amount' => $installment->dps_amount,
            'balance' => $dps->balance,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $installment->date,
            'manager_id' => $installment->manager_id,
            'dps_installment_id' => $installment->id,
          ]);
        }
      } else {
        for ($i = 1; $i <= $installment->dps_installments; $i++) {
          $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
          $dps = Dps::find($installment->dps_id);
          $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
          if ($dpsCollections == 0) {
            $dps->balance += $dps->package_amount;
            $dps->deposited += $dps->package_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'dps_id' => $installment->dps_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'dps_amount' => $dps->package_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'manager_id' => $installment->manager_id,
              'dps_installment_id' => $installment->id,
            ]);
          } else {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $date->addMonthsNoOverflow($dpsCollections);

            $dps->balance += $dps->package_amount;
            $dps->deposited += $dps->package_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'dps_id' => $installment->dps_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'dps_amount' => $dps->package_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'manager_id' => $installment->manager_id,
              'dps_installment_id' => $installment->id,
            ]);

          }
        }
      }

      $installment->dps_balance = $dps->balance;
      $installment->save();
    }

    if ($installment->loan_installment > 0 || $installment->interest > 0) {
      $loan = DpsLoan::find($installment->dps_loan_id);

      if ($installment->interest > 0) {
        foreach ($loan_taken_id as $key => $t) {
          $taken_loan = TakenLoan::find($t);
          $dpsLoanInterests = DpsLoanInterest::where('taken_loan_id', $t)->get();
          $totalInstallments = $dpsLoanInterests->sum('installments');
          if ($dpsLoanInterests->count() == 0) {
            $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
            if ($interest_installments[$key] > 1) {
              $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
            }
            $dpsLoanInterest = DpsLoanInterest::create([
              'taken_loan_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'dps_installment_id' => $installment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $installment->date
            ]);
          } else {
            $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
            $date_diff = $totalInstallments + $interest_installments[$key] - 1;
            $l_date->addMonthsNoOverflow($date_diff);
            $dpsLoanInterest = DpsLoanInterest::create([
              'taken_loan_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'dps_installment_id' => $installment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $installment->date
            ]);
          }
        }
        $loan->paid_interest += $installment->interest;
        $loan->save();

        $data['interest_type'] = 'dps';
        //PaidInterestAccount::create($data);
      }
      $unpaid_interest = 0;
      if ($installment->loan_installment > 0) {
        $interestOld = 0;
        $interestNew = 0;
        $loan->remain_loan -= $installment->loan_installment;
        $loan->save();
        $interestOld = Helpers::getInterest($installment->account_no, $installment->date, 'interest');

        $loanTakens = TakenLoan::where('dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'asc')->get();
        $loanTakenRemain = $installment->loan_installment;
        foreach ($loanTakens as $key => $loanTaken) {
          if ($loanTakenRemain == 0) {
            break;
          } elseif ($loanTaken->remain <= $loanTakenRemain) {
            $tempRemain = $loanTaken->remain;
            $loanTakenRemain -= $loanTaken->remain;
            $loanTaken->remain -= $tempRemain;
            $loanTaken->save();

            $loanPayment = LoanPayment::create([
              'account_no' => $data['account_no'],
              'taken_loan_id' => $loanTaken->id,
              'dps_installment_id' => $installment->id,
              'amount' => $tempRemain,
              'balance' => $loanTaken->remain,
              'date' => $installment->date,
            ]);
          } elseif ($loanTaken->remain >= $loanTakenRemain) {
            $loanTaken->remain -= $loanTakenRemain;
            $loanTaken->save();
            $loanPayment = LoanPayment::create([
              'account_no' => $data['account_no'],
              'taken_loan_id' => $loanTaken->id,
              'dps_installment_id' => $installment->id,
              'amount' => $loanTakenRemain,
              'balance' => $loanTaken->remain,
              'date' => $installment->date,
            ]);
            $loanTakenRemain = 0;

            break;
          }
        }

        $interestNew = Helpers::getInterest($installment->account_no, $installment->date, 'interest');

        if ($interestOld >= $interestNew) {
          $unpaid_interest = $interestOld - $interestNew;
          $loan->dueInterest += $unpaid_interest;
          $loan->save();
        }

        //DpsLoanPaymentAccount::create($data);
      }

      if ($installment->due_interest > 0) {
        $loan->dueInterest -= $installment->due_interest;
        $loan->save();
      }

      $dpsLoanCollection = DpsLoanCollection::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'dps_loan_id' => $installment->dps_loan_id,
        'manager_id' => $installment->manager_id,
        'dps_installment_id' => $installment->id,
        'loan_installment' => $installment->loan_installment,
        'balance' => $loan->remain_loan,
        'interest' => $installment->interest,
        'date' => $installment->date,
        'receipt_no' => $installment->receipt_no,
        'due_interest' => $installment->due_interest,
        'unpaid_interest' => $unpaid_interest
      ]);
      $installment->loan_balance = $loan->remain_loan;
      $installment->unpaid_interest = $unpaid_interest;
      $installment->save();

      $cashinTotal = 0;
      if ($dpsLoanCollection->loan_installment > 0) {
        $cashinTotal += $dpsLoanCollection->loan_installment;
      }
      if ($dpsLoanCollection->interest > 0) {
        $cashinTotal += $dpsLoanCollection->interest;
      }
    }

    if ($installment->advance > 0) {
      $user = User::find($installment->user_id);
      $user->wallet += $installment->advance;
      $user->save();
      //AdvanceAccount::create($data);
    }
    if ($installment->advance_return > 0) {
      $user = User::find($installment->user_id);
      $user->wallet -= $installment->advance_return;
      $user->save();

      //AdvanceAdjustAccount::create($data);
    }

    //$total_extra = $installment->late_fee + $installment->other_fee + $installment->loan_late_fee + $installment->loan_other_fee;
    //$installment->total = $total_extra + $installment->dps_amount + $installment->loan_installment + $installment->interest + $installment->advance + $installment->due_return + $installment->due_interest - $installment->grace;
    $installment->save();

    if ($installment->due > 0) {
      $due = Due::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'due' => $installment->due,
        'return' => 0,
        'balance' => $installment->due + $installment->user->due,
        'date' => $installment->date,
        'dps_installment_id' => $installment->id
      ]);

      $installment->user->due += $installment->due;
      $installment->user->save();

    }
    if ($installment->due_return > 0) {
      $due = Due::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'due' => 0,
        'return' => $installment->due_return,
        'balance' =>  $installment->user->due - $installment->due_return,
        'date' => $installment->date,
        'dps_installment_id' => $installment->id
      ]);

      $installment->user->due -= $installment->due_return;
      $installment->user->save();
    }

    return "success";
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsInstallment $dpsInstallment
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, DpsInstallment $dpsInstallment)
  {
    //$this->authorize('view', $dpsInstallment);

    return view('app.dps_installments.show', compact('dpsInstallment'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsInstallment $dpsInstallment
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, DpsInstallment $dpsInstallment)
  {
    //$this->authorize('update', $dpsInstallment);

    $users = User::pluck('name', 'id');
    $allDps = Dps::pluck('account_no', 'id');
    $dpsLoans = DpsLoan::pluck('account_no', 'id');

    return view(
      'app.dps_installments.edit',
      compact('dpsInstallment', 'users', 'allDps', 'users', 'dpsLoans')
    );
  }

  /**
   * @param \App\Http\Requests\DpsInstallmentUpdateRequest $request
   * @param \App\Models\DpsInstallment $dpsInstallment
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, DpsInstallment $dpsInstallment)
  {
    //$this->authorize('update', $dpsInstallment);
    if ($request->update_type == 'dps') {
      $temp_dps_amount = $dpsInstallment->dps_amount;
      $temp_total = 0;
      if ($dpsInstallment->dps_amount != 0) {
        $temp_total += intval($dpsInstallment->dps_amount);
      }
      if ($dpsInstallment->late_fee != "") {
        $temp_total += intval($dpsInstallment->late_fee);
      }
      if ($dpsInstallment->other_fee != "") {
        $temp_total += intval($dpsInstallment->other_fee);
      }
      if ($dpsInstallment->due != "") {
        $temp_total -= intval($dpsInstallment->due);
      }
      if ($dpsInstallment->due_return != "") {
        $temp_total += intval($dpsInstallment->due_return);
      }
      if ($dpsInstallment->advance != "") {
        $temp_total += intval($dpsInstallment->advance);
      }
      if ($dpsInstallment->advance_return != "") {
        $temp_total -= intval($dpsInstallment->advance_return);
      }
      if ($dpsInstallment->grace != "") {
        $temp_total -= intval($dpsInstallment->grace);
      }
      $dpsInstallment->total -= $temp_total;
      $dpsInstallment->save();

      $total = 0;
      if ($request->dps_amount != 0) {
        $total += intval($request->dps_amount);
      }
      if ($request->late_fee != "") {
        $total += intval($request->late_fee);
      }
      if ($request->other_fee != "") {
        $total += intval($request->other_fee);
      }
      if ($request->due != "") {
        $total -= intval($request->due);
      }
      if ($request->due_return != "") {
        $total += intval($request->due_return);
      }
      if ($request->advance != "") {
        $total += intval($request->advance);
      }
      if ($request->advance_return != "") {
        $total -= intval($request->advance_return);
      }
      if ($request->grace != "") {
        $total -= intval($request->grace);
      }

      $dps = Dps::find($dpsInstallment->dps_id);
      $dps->balance -= $dpsInstallment->dps_amount;
      $dps->deposited -= $dpsInstallment->dps_amount;
      $dps->save();


      $dpsInstallment->total += $total;
      $dpsInstallment->save();


      $data = $request->all();
      $data['dps_balance'] = $dps->balance;

      $dpsInstallment->update($data);

      if ($dpsInstallment->dps_amount >= $temp_dps_amount || $dpsInstallment->dps_amount <= $temp_dps_amount) {
        DpsCollection::where('dps_installment_id', $dpsInstallment->id)->delete();

        if ($dpsInstallment->dps_installments == 1) {
          $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
          if ($dpsCollections > 0) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $date->addMonthsNoOverflow($dpsCollections);
            $dps->balance += $dpsInstallment->dps_amount;
            $dps->deposited += $dpsInstallment->dps_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $dpsInstallment->account_no,
              'user_id' => $dpsInstallment->user_id,
              'dps_id' => $dpsInstallment->dps_id,
              'dps_amount' => $dpsInstallment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $dpsInstallment->date,
              'collector_id' => $dpsInstallment->collector_id,
              'dps_installment_id' => $dpsInstallment->id,
            ]);
          } else {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps->balance += $dpsInstallment->dps_amount;
            $dps->deposited += $dpsInstallment->dps_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $dpsInstallment->account_no,
              'user_id' => $dpsInstallment->user_id,
              'dps_id' => $dpsInstallment->dps_id,
              'dps_amount' => $dpsInstallment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $dpsInstallment->date,
              'collector_id' => $dpsInstallment->collector_id,
              'dps_installment_id' => $dpsInstallment->id,
            ]);
          }
        } else {
          for ($i = 1; $i <= $dpsInstallment->dps_installments; $i++) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps = Dps::find($dpsInstallment->dps_id);
            $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
            if ($dpsCollections == 0) {
              $dps->balance += $dps->package_amount;
              $dps->deposited += $dps->package_amount;
              $dps->save();
              $dpsCollection = DpsCollection::create([
                'account_no' => $dpsInstallment->account_no,
                'user_id' => $dpsInstallment->user_id,
                'dps_id' => $dpsInstallment->dps_id,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $dpsInstallment->date,
                'collector_id' => $dpsInstallment->collector_id,
                'dps_installment_id' => $dpsInstallment->id,
              ]);
            } else {
              $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
              $date->addMonthsNoOverflow($dpsCollections);

              $dps->balance += $dps->package_amount;
              $dps->deposited += $dps->package_amount;
              $dps->save();
              $dpsCollection = DpsCollection::create([
                'account_no' => $dpsInstallment->account_no,
                'user_id' => $dpsInstallment->user_id,
                'dps_id' => $dpsInstallment->dps_id,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $dpsInstallment->date,
                'collector_id' => $dpsInstallment->collector_id,
                'dps_installment_id' => $dpsInstallment->id,
              ]);

            }
          }
        }

      }
    } elseif ($request->update_type == 'loan') {
      $oldTotal = $this->deleteLoanInstallment($dpsInstallment->id);
      $newTotal = $request->loan_installment + $request->interest + $request->due_interest + $request->lona_late_fee + $request->loan_other_fee - $request->loan_grace;
      $data = $request->all();
      $data['total'] = $oldTotal + $newTotal;
      $dpsInstallment->loan_installment = $data['loan_installment'];
      $dpsInstallment->interest = $data['interest'];
      $dpsInstallment->total = $data['total'];
      $dpsInstallment->dps_loan_id = $data['dps_loan_id'];
      $dpsInstallment->save();
      $loan_taken_id = array_key_exists("loan_taken_id", $data) ? $data['loan_taken_id'] : '';
      $interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
      $taken_interest = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';
      $loan = DpsLoan::find($dpsInstallment->dps_loan_id);

      if ($dpsInstallment->interest > 0) {
        foreach ($loan_taken_id as $key => $t) {
          $taken_loan = TakenLoan::find($t);
          $dpsLoanInterests = DpsLoanInterest::where('taken_loan_id', $t)->get();
          $totalInstallments = $dpsLoanInterests->sum('installments');
          if ($dpsLoanInterests->count() == 0) {
            $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
            if ($interest_installments[$key] > 1) {
              $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
            }
            $dpsLoanInterest = DpsLoanInterest::create([
              'taken_loan_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'dps_installment_id' => $dpsInstallment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $dpsInstallment->date
            ]);
          } else {
            $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
            $date_diff = $totalInstallments + $interest_installments[$key] - 1;
            $l_date->addMonthsNoOverflow($date_diff);
            $dpsLoanInterest = DpsLoanInterest::create([
              'taken_loan_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'dps_installment_id' => $dpsInstallment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $dpsInstallment->date
            ]);
          }
        }
        $loan->paid_interest += $dpsInstallment->interest;
        $loan->save();
      }
      $unpaid_interest = 0;
      if ($dpsInstallment->loan_installment > 0) {
        $interestOld = 0;
        $interestNew = 0;
        $loan->remain_loan -= $dpsInstallment->loan_installment;
        $loan->save();
        $interestOld = Helpers::getInterest($dpsInstallment->account_no, $dpsInstallment->date, 'interest');

        $loanTakens = TakenLoan::where('dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'asc')->get();
        $loanTakenRemain = $dpsInstallment->loan_installment;
        foreach ($loanTakens as $key => $loanTaken) {
          if ($loanTakenRemain == 0) {
            break;
          } elseif ($loanTaken->remain <= $loanTakenRemain) {
            $tempRemain = $loanTaken->remain;
            $loanTakenRemain -= $loanTaken->remain;
            $loanTaken->remain -= $tempRemain;
            $loanTaken->save();

            $loanPayment = LoanPayment::create([
              'taken_loan_id' => $loanTaken->id,
              'dps_installment_id' => $dpsInstallment->id,
              'amount' => $tempRemain,
              'balance' => $loanTaken->remain,
              'account_no' => $dpsInstallment->account_no,
              'date' => $dpsInstallment->date,
            ]);
          } elseif ($loanTaken->remain >= $loanTakenRemain) {
            $loanTaken->remain -= $loanTakenRemain;
            $loanTaken->save();
            $loanPayment = LoanPayment::create([
              'taken_loan_id' => $loanTaken->id,
              'account_no' => $dpsInstallment->account_no,
              'dps_installment_id' => $dpsInstallment->id,
              'amount' => $loanTakenRemain,
              'balance' => $loanTaken->remain,
              'date' => $dpsInstallment->date,
            ]);
            $loanTakenRemain = 0;

            break;
          }
        }

        $interestNew = Helpers::getInterest($dpsInstallment->account_no, $dpsInstallment->date, 'interest');

        if ($interestOld >= $interestNew) {
          $unpaid_interest = $interestOld - $interestNew;
          $loan->dueInterest += $unpaid_interest;
          $loan->save();
        }

      }


      if ($dpsInstallment->due_interest > 0) {
        $loan->dueInterest -= $dpsInstallment->due_interest;
        $loan->save();
      }

      $dpsLoanCollection = DpsLoanCollection::create([
        'account_no' => $dpsInstallment->account_no,
        'user_id' => $dpsInstallment->user_id,
        'dps_loan_id' => $dpsInstallment->dps_loan_id,
        'collector_id' => $dpsInstallment->collector_id,
        'dps_installment_id' => $dpsInstallment->id,
        'loan_installment' => $dpsInstallment->loan_installment,
        'balance' => $loan->remain_loan,
        'interest' => $dpsInstallment->interest,
        'date' => $dpsInstallment->date,
        'receipt_no' => $dpsInstallment->receipt_no,
        'due_interest' => $dpsInstallment->due_interest,
        'unpaid_interest' => $unpaid_interest
      ]);
      $dpsInstallment->loan_balance = $loan->remain_loan;
      $dpsInstallment->unpaid_interest = $unpaid_interest;
      $dpsInstallment->save();
    }

    echo "success";
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsInstallment $dpsInstallment
   * @return \Illuminate\Http\Response
   */
  public function deleteLoanInstallment($id)
  {
    $dps_installments = DpsInstallment::find($id);
    $dpsLoanCollection = DpsLoanCollection::where('dps_installment_id', $id)->latest()->first();
    if ($dpsLoanCollection) {
      if ($dpsLoanCollection->loan_installment > 0) {
        $dps_installments->total -= $dpsLoanCollection->loan_installment;
        $loan = DpsLoan::find($dps_installments->dps_loan_id);
        if ($loan->remain_loan >= $dps_installments->loan_installment) {
          $loan->remain_loan += $dps_installments->loan_installment;
          $loan->save();
        }

        $loanPayments = LoanPayment::where('dps_installment_id', $dpsLoanCollection->dps_installment_id)->get();
        foreach ($loanPayments as $loanPayment) {
          $loanTaken = TakenLoan::find($loanPayment->taken_loan_id);
          if ($loanTaken->remain >= $loanPayment->amount) {
            $loanTaken->remain += $loanPayment->amount;
            $loanTaken->save();
          }
          // DpsLoanPaymentAccount::delete()
          $loanPayment->delete();
        }


        $dps_installments->save();
      }
      if ($dps_installments->interest > 0) {
        $dps_installments->total -= $dpsLoanCollection->interest;
        $loan = DpsLoan::find($dps_installments->dps_loan_id);
        if ($loan->paid_interest >= $dps_installments->interest) {
          $loan->paid_interest -= $dps_installments->interest;
          $loan->save();
        }

        DpsLoanInterest::where('dps_installment_id', $dpsLoanCollection->dps_installment_id)->delete();
        $dps_installments->save();
      }

      if ($dpsLoanCollection->unpaid_interest > 0) {
        $loan = DpsLoan::find($dps_installments->dps_loan_id);
        $loan->dueInterest -= $dpsLoanCollection->unpaid_interest;
        $loan->save();
      }

      if ($dpsLoanCollection->loan_late_fee > 0) {
        $dps_installments->total -= $dpsLoanCollection->loan_late_fee;
        $dps_installments->save();
      }
      if ($dpsLoanCollection->loan_other_fee > 0) {
        $dps_installments->total -= $dpsLoanCollection->loan_other_fee;
        $dps_installments->save();
      }

      $dpsLoanCollection->delete();
    }

    return $dps_installments->total;
  }

  public function destroy($id)
  {
    $dpsInstallment = DpsInstallment::find($id);
    //$this->authorize('delete', $dpsInstallment);
    $dps = Dps::find($dpsInstallment->dps_id);
    $dps->balance -= $dpsInstallment->dps_amount;
    $dps->deposited -= $dpsInstallment->dps_amount;
    $dps->save();
    DpsCollection::where('dps_installment_id', $dpsInstallment->id)->delete();
    if ($dpsInstallment->loan_installment > 0 || $dpsInstallment->interest > 0) {
      $loan = DpsLoan::find($dpsInstallment->dps_loan_id);
      if ($dpsInstallment->unpaid_interest > 0) {
        $loan->dueInterest -= $dpsInstallment->unpaid_interest;
        //$loan->remain_loan += $dpsInstallment->loan_installment;
        $loan->save();
      }
      if ($dpsInstallment->loan_installment > 0) {
        $loanPayments = LoanPayment::where('dps_installment_id', $id)->get();
        foreach ($loanPayments as $loanPayment) {
          $loanTaken = TakenLoan::find($loanPayment->taken_loan_id);
          $loanTaken->remain += $loanPayment->amount;
          $loanTaken->save();
          $loanPayment->delete();
        }
        $loan->remain_loan += $dpsInstallment->loan_installment;
        $loan->save();
      }
      if ($dpsInstallment->interest > 0) {
        DpsLoanInterest::where('dps_installment_id', $id)->delete();
        $loan->paid_interest -= $dpsInstallment->interest;
        $loan->save();
      }
      DpsLoanCollection::where('dps_installment_id', $id)->delete();
    }
    if ($dpsInstallment->due>0){
      $dpsInstallment->user->due -= $dpsInstallment->due;
      $dpsInstallment->user->save();
    }

    if ($dpsInstallment->due_return>0){
      $dpsInstallment->user->due += $dpsInstallment->due_return;
      $dpsInstallment->user->save();
    }

    $dpsInstallment->delete();
    echo "success";
  }

  public function dataByAccount(Request $request)
  {
    $dps = Helpers::getDueDps($request->account, $request->date);
    $due = Due::where('account_no', $request->account)->first();
    $loan = DpsLoan::with(['dpsLoanCollections' => function ($query) {
      $query->latest()->limit(1);
    }])->where('account_no', $request->account)->first();


    $data['user'] = $dps['user'];
    $data['due'] = $due ? $due->remain : "0";
    $data['dpsInfo'] = $dps['dpsInfo'];
    $data['dpsDue'] = $dps['dpsDue'];
    $data['loanInfo'] = $loan ? Helpers::getInterest($request->account, $request->date, '') : "";
    $data['loan'] = $loan ? $loan : "";
    $data['lastLoanPayment'] = $loan ? $loan->dpsLoanCollections->whereNotNull('loan_installment')->first() : "null";
    $data['lastInterestPayment'] = $loan ? $loan->dpsLoanCollections->whereNotNull('interest')->first() : "null";

    return json_encode($data);

  }

  public function trxId($date)
  {
    $record = Transaction::latest('id')->first();
    $dateTime = new Carbon($date);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $uid = substr(str_shuffle($permitted_chars), 0, 6);
    if ($record) {
      $expNum = explode('-', $record->trx_id);
      if ($dateTime->format('jny') == $expNum[1]) {
        $s = str_pad($expNum[3] + 1, 4, "0", STR_PAD_LEFT);
        $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $uid . '-' . $s;
      } else {
        //increase 1 with last invoice number
        $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';
      }
    } else {
      $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';
    }

    return $nextTxNumber;
  }

  public function getDpsCollectionData($id)
  {
    $dpsInstallment = DpsInstallment::with('user')->find($id);
    $dpsCollection = DpsCollection::where('dps_installment_id', $id)->latest()->first();
    $data = array();
    $data['dpsInstallment'] = $dpsInstallment;
    $data['dpsCollection'] = $dpsCollection;
    return json_encode($data);
  }

  public function getLoanCollectionData($id)
  {
    $dpsInstallment = DpsInstallment::find($id);
    $loanCollection = DpsLoanCollection::where('dps_installment_id', $id)->latest()->first();
    $loanInterests = DpsLoanInterest::where('dps_installment_id', $id)->get();
    $data = array();
    $data['dpsInstallment'] = $dpsInstallment;
    $data['loanCollection'] = $loanCollection;
    $data['loanInterests'] = $loanInterests;
    return json_encode($data);
  }

  public function accountTransaction(DpsInstallment $installment)
  {
    $data = $installment;
    $data['name'] = $installment->user->name;
    $data['trx_type'] = $installment->deposited_via;
    if ($installment->dps_amount > 0) {

      DpsAccount::create($data);
    }
    if ($installment->loan_installment > 0) {
      DpsLoanPaymentAccount::create($data);

    }
    if ($installment->interest > 0) {

      $data['interest_type'] = 'dps';
      PaidInterestAccount::create($data);

    }
    if ($installment->advance > 0) {
      AdvanceAccount::create($data);
    }
    if ($installment->advance_return > 0) {
      AdvanceAdjustAccount::create($data);

    }

    if ($installment->due > 0) {
      DueAccount::create($data);


    }

    if ($installment->due_return > 0) {
      DueReturnAccount::create($data);

      if ($installment->late_fee > 0) {
        LateFeeAccount::create($data);
      }
      if ($installment->loan_late_fee > 0) {
        $data['late_fee'] = $installment->loan_late_fee;
        LateFeeAccount::create($data);
      }
      if ($installment->other_fee > 0) {
        OtherFeeAccount::create($data);
      }
      if ($installment->loan_other_fee > 0) {
        $data['other_fee'] = $installment->loan_other_fee;
        OtherFeeAccount::create($data);
      }

      if ($installment->grace > 0) {
        GraceAccount::create($data);
      }
      if ($installment->loan_grace > 0) {
        GraceAccount::create($data);
      }
    }
  }

  public function import(Request $request)
  {
    Excel::import(new DpsInstallmentImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }

  public function fetchInstallment($id)
  {
    $installment = DpsInstallment::with('user')->find($id);
    return response()->json($installment);
  }

}
