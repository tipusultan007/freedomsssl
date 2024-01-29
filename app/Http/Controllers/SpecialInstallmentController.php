<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Accounts\AdvanceAccount;
use App\Http\Controllers\Accounts\AdvanceAdjustAccount;
use App\Http\Controllers\Accounts\DueAccount;
use App\Http\Controllers\Accounts\DueReturnAccount;
use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\SpecialDpsAccount;
use App\Http\Controllers\Accounts\SpecialLoanPaymentAccount;
use App\Imports\SpecialInstallmentImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\DpsInstallment;
use App\Models\Due;
use App\Models\SpecialDps;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialDpsInstallment;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SpecialInstallmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('app.special.installments');
  }

  public function dataSpecialDpsInstallment(Request $request)
  {
    $query = SpecialInstallment::query();

    if (!empty($request->account)) {
      $query->where('account_no', $request->account);
    }

    if (!empty($request->collector)) {
      $query->where('manager_id', $request->collector);
    }

    if (!empty($request->from) && !empty($request->to)) {
      $query->whereBetween('date', [$request->from, $request->to]);
    }

    $totalData = $query->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    if (empty($request->input('search.value'))) {
      $query = SpecialInstallment::with('user', 'collector');

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

      $posts = SpecialInstallment::with('user', 'manager')
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

      $totalFiltered = SpecialInstallment::where(function ($query) use ($search) {
        $query->where('account_no', 'LIKE', "%{$search}%")
          ->orWhereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
          });
      })->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {

        $show = route('special-installments.show', $post->id);
        $edit = route('special-installments.edit', $post->id);

        $date = new Carbon($post->date);
        $nestedData['id'] = $post->id;
        $nestedData['sent'] = $post->is_sms_sent;
        $nestedData['dps_id'] = $post->special_dps_id;
        $nestedData['interest'] = $post->interest;
        $nestedData['total'] = $post->total;
        $nestedData['dps_loan_id'] = $post->special_dps_loan_id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['dps_amount'] = $post->dps_amount;
        $nestedData['loan_installment'] = $post->loan_installment;
        $nestedData['date'] = $date->format('d/m/Y');
        $nestedData['loan_late_fee'] = $post->loan_late_fee;
        $nestedData['loan_other_fee'] = $post->loan_other_fee;
        $nestedData['late_fee'] = $post->late_fee;
        $nestedData['other_fee'] = $post->other_fee;
        $nestedData['dps_balance'] = $post->dps_balance;
        $nestedData['loan_balance'] = $post->loan_balance;
        $nestedData['dps_note'] = $post->dps_note;
        $nestedData['loan_note'] = $post->loan_note;
        $nestedData['collector'] = $post->manager->name;
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $data['manager_id'] = Auth::id();
    $data['trx_id'] = Str::uuid();
    $installment = SpecialInstallment::create($data);
    $data['trx_type'] = $request->deposited_via;
    $data['name'] = $installment->user->name;
    $loan_taken_id = array_key_exists("special_loan_taken_id", $data) ? $data['special_loan_taken_id'] : '';
    $interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
    $taken_interest = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';

    if ($installment->dps_amount > 0) {
      $dps = SpecialDps::find($installment->special_dps_id);
      if ($installment->dps_installments == 1) {
        $dpsCollections = SpecialDpsCollection::where('special_dps_id', $dps->id)->count();
        if ($dpsCollections > 0) {
          $date = new Carbon($dps->commencement);
          $date->addMonths($dpsCollections);
          $dps->balance += $installment->dps_amount;
          $dps->deposited += $installment->dps_amount;
          $dps->save();
          $dpsCollection = SpecialDpsCollection::create([
            'account_no' => $installment->account_no,
            'user_id' => $installment->user_id,
            'special_dps_id' => $installment->special_dps_id,
            'dps_amount' => $installment->dps_amount,
            'balance' => $dps->balance,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $installment->date,
            'manager_id' => $installment->manager_id,
            'special_installment_id' => $installment->id,
          ]);
        } else {
          $date = new Carbon($dps->commencement);
          $dps->balance += $installment->dps_amount;
          $dps->deposited += $installment->dps_amount;
          $dps->save();
          $dpsCollection = SpecialDpsCollection::create([
            'account_no' => $installment->account_no,
            'user_id' => $installment->user_id,
            'special_dps_id' => $installment->special_dps_id,
            'dps_amount' => $installment->dps_amount,
            'balance' => $dps->balance,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $installment->date,
            'manager_id' => $installment->manager_id,
            'special_installment_id' => $installment->id,
          ]);
        }
      } else {
        for ($i = 1; $i <= $installment->dps_installments; $i++) {
          $date = new Carbon($dps->commencement);
          $dps = SpecialDps::find($installment->special_dps_id);
          $dpsCollections = SpecialDpsCollection::where('special_dps_id', $dps->id)->count();
          if ($dpsCollections == 0) {
            $dps->balance += $dps->package_amount;
            $dps->deposited += $dps->package_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'special_dps_id' => $installment->special_dps_id,
              'dps_amount' => $dps->package_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'manager_id' => $installment->manager_id,
              'special_installment_id' => $installment->id,
            ]);
          } else {
            $date = new Carbon($dps->commencement);
            $date->addMonths($dpsCollections);

            $dps->balance += $dps->package_amount;
            $dps->deposited += $dps->package_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'special_dps_id' => $installment->special_dps_id,
              'dps_amount' => $dps->package_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'collector_id' => $installment->collector_id,
              'special_installment_id' => $installment->id,
            ]);

          }
        }
      }

      $installment->dps_balance = $dps->balance;
      $installment->save();
      //SpecialDpsAccount::create($data);
    }

    if ($installment->loan_installment > 0 || $installment->interest > 0) {
      $loan = SpecialDpsLoan::find($installment->special_dps_loan_id);
      if ($installment->interest > 0) {
        foreach ($loan_taken_id as $key => $t) {
          $taken_loan = SpecialLoanTaken::find($t);
          $dpsLoanInterests = SpecialLoanInterest::where('special_installment_id', $t)->get();
          $totalInstallments = $dpsLoanInterests->sum('installments');
          if ($dpsLoanInterests->count() == 0) {
            $l_date = new Carbon($taken_loan->commencement);
            if ($interest_installments[$key] > 1) {
              $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
            }
            $dpsLoanInterest = SpecialLoanInterest::create([
              'special_loan_taken_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'special_installment_id' => $installment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $installment->date
            ]);
          } else {
            $l_date = new Carbon($taken_loan->commencement);
            $date_diff = $totalInstallments + $interest_installments[$key] - 1;
            $l_date->addMonthsNoOverflow($date_diff);
            $dpsLoanInterest = SpecialLoanInterest::create([
              'special_loan_taken_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'special_installment_id' => $installment->id,
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
        $data['interest_type'] = 'special';
        //PaidInterestAccount::create($data);
      }
      $unpaid_interest = 0;
      if ($installment->loan_installment > 0) {
        $interestOld = 0;
        $interestNew = 0;
        $loan->remain_loan -= $installment->loan_installment;
        $loan->total_paid += $installment->loan_installment;
        $loan->save();
        $interestOld = Helpers::getSpecialInterest($installment->account_no, $installment->date, 'interest');

        $loanTakens = SpecialLoanTaken::where('special_dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'asc')->get();
        $loanTakenRemain = $installment->loan_installment;
        foreach ($loanTakens as $key => $loanTaken) {
          if ($loanTakenRemain == 0) {
            break;
          } elseif ($loanTaken->remain <= $loanTakenRemain) {
            $tempRemain = $loanTaken->remain;
            $loanTakenRemain -= $loanTaken->remain;
            $loanTaken->remain -= $tempRemain;
            $loanTaken->save();

            $loanPayment = SpecialLoanPayment::create([
              'special_loan_taken_id' => $loanTaken->id,
              'special_installment_id' => $installment->id,
              'account_no' => $installment->account_no,
              'amount' => $tempRemain,
              'balance' => $loanTaken->remain,
              'date' => $installment->date,
            ]);

          } elseif ($loanTaken->remain >= $loanTakenRemain) {
            $loanTaken->remain -= $loanTakenRemain;
            $loanTaken->save();
            $loanPayment = SpecialLoanPayment::create([
              'special_loan_taken_id' => $loanTaken->id,
              'special_installment_id' => $installment->id,
              'account_no' => $installment->account_no,
              'amount' => $loanTakenRemain,
              'balance' => $loanTaken->remain,
              'date' => $installment->date,
            ]);
            $loanTakenRemain = 0;

            break;
          }
        }
        $interestNew = Helpers::getSpecialInterest($installment->account_no, $installment->date, 'interest');
        if ($interestOld >= $interestNew) {
          $unpaid_interest = $interestOld - $interestNew;
          $loan->dueInterest += $unpaid_interest;
          $loan->save();
        }

        //SpecialLoanPaymentAccount::create($data);
      }


      if ($installment->due_interest > 0) {
        $loan->dueInterest -= $installment->due_interest;
        $loan->save();
      }

      $dpsLoanCollection = SpecialLoanCollection::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'special_dps_loan_id' => $installment->special_dps_loan_id,
        'manager_id' => $installment->manager_id,
        'special_installment_id' => $installment->id,
        'loan_installment' => $installment->loan_installment,
        'balance' => $loan->remain_loan,
        'interest' => $installment->interest,
        'due_interest' => $installment->due_interest,
        'unpaid_interest' => $unpaid_interest,
        'date' => $installment->date,
        'receipt_no' => $installment->receipt_no,
      ]);
      $installment->loan_balance = $loan->remain_loan;
      $installment->unpaid_interest = $unpaid_interest;
      $installment->save();

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

    if ($installment->due > 0) {
      $due = Due::firstOrCreate(
        ['account_no' => $installment->account_no],
        ['user_id' => $installment->user_id],
      );
      $due->remain += $installment->due;
      $due->status = 'unpaid';
      $due->save();
      //DueAccount::create($data);
    }
    if ($installment->due_return > 0) {
      $due = Due::where('account_no', $installment->account_no)->first();
      $due->remain -= $installment->due_return;
      if ($due->remain == 0) {
        $due->status = 'paid';
      } else {
        $due->status = 'unpaid';
      }
      $due->save();

      //DueReturnAccount::create($data);
    }

    //$total_extra = $installment->late_fee + $installment->other_fee + $installment->loan_late_fee + $installment->loan_other_fee;
    //$installment->total = $total_extra + $installment->dps_amount + $installment->loan_installment + $installment->interest + $installment->advance + $installment->due_return + $installment->due_interest - $installment->grace;
    $installment->save();

    //$transactions = $this->accountTransaction($installment);

    //return redirect()->back();
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $installment = SpecialInstallment::find($id);
    //dd($installment);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $dpsInstallment = SpecialInstallment::find($id);
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

      $dps = SpecialDps::find($dpsInstallment->special_dps_id);
      $dps->balance -= $dpsInstallment->dps_amount;
      $dps->deposited -= $dpsInstallment->dps_amount;
      $dps->save();

      $dpsInstallment->total += $total;
      $dpsInstallment->save();


      $data = $request->all();
      $data['dps_balance'] = $dps->balance;

      $dpsInstallment->update($data);

      if ($dpsInstallment->dps_amount >= $temp_dps_amount || $dpsInstallment->dps_amount <= $temp_dps_amount) {
        SpecialDpsCollection::where('special_installment_id', $dpsInstallment->id)->delete();
        if ($dpsInstallment->dps_installments == 1) {
          $dpsCollections = SpecialDpsCollection::where('special_dps_id', $dps->id)->count();
          if ($dpsCollections > 0) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $date->addMonthsNoOverflow($dpsCollections);
            $dps->balance += $dpsInstallment->dps_amount;
            $dps->deposited += $dpsInstallment->dps_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $dpsInstallment->account_no,
              'user_id' => $dpsInstallment->user_id,
              'special_dps_id' => $dpsInstallment->dps_id,
              'dps_amount' => $dpsInstallment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $dpsInstallment->date,
              'manager_id' => $dpsInstallment->manager_id,
              'special_installment_id' => $dpsInstallment->id,
            ]);
          } else {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps->balance += $dpsInstallment->dps_amount;
            $dps->deposited += $dpsInstallment->dps_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $dpsInstallment->account_no,
              'user_id' => $dpsInstallment->user_id,
              'special_dps_id' => $dpsInstallment->special_dps_id,
              'dps_amount' => $dpsInstallment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $dpsInstallment->date,
              'manager_id' => $dpsInstallment->manager_id,
              'special_installment_id' => $dpsInstallment->id,
            ]);
          }
        } else {
          for ($i = 1; $i <= $dpsInstallment->dps_installments; $i++) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps = SpecialDps::find($dpsInstallment->special_dps_id);
            $dpsCollections = SpecialDpsCollection::where('special_dps_id', $dps->id)->count();
            if ($dpsCollections == 0) {
              $dps->balance += $dps->package_amount;
              $dps->deposited += $dps->package_amount;
              $dps->save();
              $dpsCollection = SpecialDpsCollection::create([
                'account_no' => $dpsInstallment->account_no,
                'user_id' => $dpsInstallment->user_id,
                'special_dps_id' => $dpsInstallment->special_dps_id,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $dpsInstallment->date,
                'manager_id' => $dpsInstallment->manager_id,
                'special_installment_id' => $dpsInstallment->id,
              ]);
            } else {
              $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
              $date->addMonthsNoOverflow($dpsCollections);

              $dps->balance += $dps->package_amount;
              $dps->deposited += $dps->package_amount;
              $dps->save();
              $dpsCollection = SpecialDpsCollection::create([
                'account_no' => $dpsInstallment->account_no,
                'user_id' => $dpsInstallment->user_id,
                'special_dps_id' => $dpsInstallment->special_dps_id,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $dpsInstallment->date,
                'manager_id' => $dpsInstallment->manager_id,
                'special_installment_id' => $dpsInstallment->id,
              ]);

            }
          }
        }

      }
    } elseif ($request->update_type == 'loan') {
      //return $dpsInstallment;
      $oldTotal = $this->deleteLoanInstallment($dpsInstallment->id);
      $newTotal = $request->loan_installment + $request->interest + $request->due_interest + $request->lona_late_fee + $request->loan_other_fee - $request->loan_grace;
      $data = $request->all();
      $data['total'] = $oldTotal + $newTotal;
      $dpsInstallment->loan_installment = $data['loan_installment'];
      $dpsInstallment->interest = $data['interest'];
      $dpsInstallment->total = $data['total'];
      $dpsInstallment->special_dps_loan_id = $data['special_dps_loan_id'];
      $dpsInstallment->save();
      $loan_taken_id = array_key_exists("special_loan_taken_id", $data) ? $data['special_loan_taken_id'] : '';
      $interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
      $taken_interest = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';
      $loan = SpecialDpsLoan::find($dpsInstallment->special_dps_loan_id);

      $loan = SpecialDpsLoan::find($dpsInstallment->special_dps_loan_id);
      if ($dpsInstallment->interest > 0) {
        foreach ($loan_taken_id as $key => $t) {
          $taken_loan = SpecialLoanTaken::find($t);
          $dpsLoanInterests = SpecialLoanInterest::where('special_installment_id', $t)->get();
          $totalInstallments = $dpsLoanInterests->sum('installments');
          if ($dpsLoanInterests->count() == 0) {
            $l_date = new Carbon($taken_loan->commencement);
            if ($interest_installments[$key] > 1) {
              $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
            }
            $dpsLoanInterest = SpecialLoanInterest::create([
              'special_loan_taken_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'special_installment_id' => $dpsInstallment->id,
              'interest' => $taken_interest[$key],
              'total' => $taken_interest[$key] * $interest_installments[$key],
              'month' => $l_date->format('F'),
              'year' => $l_date->format('Y'),
              'date' => $dpsInstallment->date
            ]);
          } else {
            $l_date = new Carbon($taken_loan->commencement);
            $date_diff = $totalInstallments + $interest_installments[$key] - 1;
            $l_date->addMonthsNoOverflow($date_diff);
            $dpsLoanInterest = SpecialLoanInterest::create([
              'special_loan_taken_id' => $t,
              'account_no' => $taken_loan->account_no,
              'installments' => $interest_installments[$key],
              'special_installment_id' => $dpsInstallment->id,
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
        $interestOld = Helpers::getSpecialInterest($dpsInstallment->account_no, $dpsInstallment->date, 'interest');

        $loanTakens = SpecialLoanTaken::where('special_dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'asc')->get();
        $loanTakenRemain = $dpsInstallment->loan_installment;
        foreach ($loanTakens as $key => $loanTaken) {
          if ($loanTakenRemain == 0) {
            break;
          } elseif ($loanTaken->remain <= $loanTakenRemain) {
            $tempRemain = $loanTaken->remain;
            $loanTakenRemain -= $loanTaken->remain;
            $loanTaken->remain -= $tempRemain;
            $loanTaken->save();

            $loanPayment = SpecialLoanPayment::create([
              'special_loan_taken_id' => $loanTaken->id,
              'special_installment_id' => $dpsInstallment->id,
              'amount' => $tempRemain,
              'balance' => $loanTaken->remain,
              'date' => $dpsInstallment->date,
            ]);
          } elseif ($loanTaken->remain >= $loanTakenRemain) {
            $loanTaken->remain -= $loanTakenRemain;
            $loanTaken->save();
            $loanPayment = SpecialLoanPayment::create([
              'special_loan_taken_id' => $loanTaken->id,
              'special_installment_id' => $dpsInstallment->id,
              'amount' => $loanTakenRemain,
              'balance' => $loanTaken->remain,
              'date' => $dpsInstallment->date,
            ]);
            $loanTakenRemain = 0;

            break;
          }
        }
        $interestNew = Helpers::getSpecialInterest($dpsInstallment->account_no, $dpsInstallment->date, 'interest');
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

      $dpsLoanCollection = SpecialLoanCollection::create([
        'account_no' => $dpsInstallment->account_no,
        'user_id' => $dpsInstallment->user_id,
        'special_dps_loan_id' => $dpsInstallment->special_dps_loan_id,
        'manager_id' => $dpsInstallment->manager_id,
        'special_installment_id' => $dpsInstallment->id,
        'loan_installment' => $dpsInstallment->loan_installment,
        'balance' => $loan->remain_loan,
        'interest' => $dpsInstallment->interest,
        'due_interest' => $dpsInstallment->due_interest,
        'unpaid_interest' => $unpaid_interest,
        'date' => $dpsInstallment->date,
        'receipt_no' => $dpsInstallment->receipt_no,
      ]);
      $dpsInstallment->loan_balance = $loan->remain_loan;
      $dpsInstallment->unpaid_interest = $unpaid_interest;
      $dpsInstallment->save();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function deleteLoanInstallment($id)
  {
    $dps_installments = SpecialInstallment::find($id);
    $dpsLoanCollection = SpecialLoanCollection::where('special_installment_id', $id)->latest()->first();
    if ($dpsLoanCollection) {
      if ($dpsLoanCollection->loan_installment > 0) {
        $dps_installments->total -= $dpsLoanCollection->loan_installment;
        $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
        if ($loan) {
          if ($loan->remain_loan >= $dps_installments->loan_installment) {
            $loan->remain_loan += $dps_installments->loan_installment;
            $loan->save();
          }
        }

        $loanPayments = SpecialLoanPayment::where('special_installment_id', $dpsLoanCollection->special_installment_id)->get();
        foreach ($loanPayments as $loanPayment) {
          $loanTaken = SpecialLoanTaken::find($loanPayment->special_loan_taken_id);
          if ($loanTaken) {
            if ($loanTaken->remain >= $loanPayment->amount) {
              $loanTaken->remain += $loanPayment->amount;
              $loanTaken->save();
            }
          }
          $loanPayment->delete();
        }

        $dps_installments->save();
      }
      if ($dps_installments->interest > 0) {
        $dps_installments->total -= $dpsLoanCollection->interest;
        $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
        if ($loan->paid_interest >= $dps_installments->interest) {
          $loan->paid_interest -= $dps_installments->interest;
          $loan->save();
        }

        SpecialLoanInterest::where('special_installment_id', $dpsLoanCollection->special_installment_id)->delete();
        $dps_installments->save();
      }

      if ($dpsLoanCollection->unpaid_interest > 0) {
        $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
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
    $dps_installments->save();

    return $dps_installments->total;
  }

  public function destroy($id)
  {
    $dpsInstallment = SpecialInstallment::find($id);
    //$this->authorize('delete', $dpsInstallment);
    $dps = SpecialDps::find($dpsInstallment->special_dps_id);
    if ($dps->balance >= $dpsInstallment->dps_amount) {
      $dps->balance -= $dpsInstallment->dps_amount;
      $dps->deposited -= $dpsInstallment->dps_amount;
      $dps->save();
    }

    SpecialDpsCollection::where('special_installment_id', $dpsInstallment->id)->delete();
    if ($dpsInstallment->loan_installment > 0 || $dpsInstallment->interest > 0) {
      $loan = SpecialDpsLoan::find($dpsInstallment->special_dps_loan_id);

      if ($dpsInstallment->unpaid_interest > 0) {
        $loan->dueInterest -= $dpsInstallment->unpaid_interest;
        $loan->save();
      }

      if ($dpsInstallment->loan_installment > 0) {
        $loanPayments = SpecialLoanPayment::where('special_installment_id', $id)->get();
        foreach ($loanPayments as $loanPayment) {
          $loanTaken = SpecialLoanTaken::find($loanPayment->special_loan_taken_id);
          $loanTaken->remain += $loanPayment->amount;
          $loanTaken->save();
          $loanPayment->delete();
        }
        $loan->remain_loan += $dpsInstallment->loan_installment;
        $loan->total_paid -= $dpsInstallment->loan_installment;
        $loan->save();
      }

      if ($dpsInstallment->interest > 0) {
        SpecialLoanInterest::where('special_installment_id', $id)->delete();
        if ($loan->paid_interest >= $dpsInstallment->interest) {
          $loan->paid_interest -= $dpsInstallment->interest;
        }
        $loan->save();
      }

      SpecialLoanCollection::where('special_installment_id', $id)->delete();
    }
    $dpsInstallment->delete();

    echo "success";
  }

  public function dataByAccount(Request $request)
  {
    $dps = Helpers::getDueSpecialDps($request->account, $request->date);
    $due = Due::where('account_no', $request->account)->first();
    $loan = SpecialDpsLoan::where('account_no', $request->account)->first();
    $loanCollection = '';
    if ($loan) {
      $loanCollection = SpecialLoanCollection::where('special_dps_loan_id', $loan->id)->orderBy('date', 'desc')->first();
    }

    $data['user'] = $dps['user'];
    $data['due'] = $due ? $due->remain : "0";
    $data['dpsInfo'] = $dps['dpsInfo'];
    $data['dpsDue'] = $dps['dpsDue'];
    $data['loanInfo'] = $loan ? Helpers::getSpecialInterest($request->account, $request->date, '') : "";
    $data['loan'] = $loan ? $loan : "";
    $data['lastLoanPayment'] = $loanCollection ? $loanCollection->whereNotNull('loan_installment') : "null";
    $data['lastInterestPayment'] = $loanCollection ? $loanCollection->whereNotNull('interest') : "null";

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
    $dpsInstallment = SpecialInstallment::with('user')->find($id);
    $dpsCollection = SpecialDpsCollection::where('special_installment_id', $id)->latest()->first();
    $data = array();
    $data['dpsInstallment'] = $dpsInstallment;
    $data['dpsCollection'] = $dpsCollection;
    return json_encode($data);
  }

  public function fetchInstallment($id)
  {
    $installment = SpecialInstallment::with('user')->find($id);
    return response()->json($installment);
  }

  public function getLoanCollectionData($id)
  {
    $dpsInstallment = SpecialInstallment::find($id);
    $loanCollection = SpecialLoanCollection::where('special_installment_id', $id)->latest()->first();
    $loanInterests = SpecialLoanInterest::where('special_installment_id', $id)->get();
    $data = array();
    $data['dpsInstallment'] = $dpsInstallment;
    $data['loanCollection'] = $loanCollection;
    $data['loanInterests'] = $loanInterests;
    return json_encode($data);
  }

  public function accountTransaction(SpecialInstallment $installment)
  {
    if ($installment->dps_amount > 0) {

      $dps_transaction = Transaction::create([
        'account_id' => 1,
        'description' => 'Special Installment',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->dps_amount,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);
      $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
      $depositAccount->balance += $dps_transaction->amount;
      $depositAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance += $dps_transaction->amount;
      $cashAccount->save();
    }
    if ($installment->loan_installment > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 13,
        'description' => 'Special Loan Payment',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->loan_installment,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $loanInstallmentAccount = Account::find(13); //LOAN PAYMENT+
      $loanInstallmentAccount->balance += $dps_transaction->amount;
      $loanInstallmentAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance += $dps_transaction->amount;
      $cashAccount->save();

      $loanProvideAccount = Account::find(2); //ASSET (LOAN PROVIDE-)
      $loanProvideAccount->balance -= $dps_transaction->amount;
      $loanProvideAccount->save();
    }
    if ($installment->interest > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 7,
        'description' => 'SPecial Loan Interest Paid',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->interest,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $interestAccount = Account::find(7); //INCOME (LOAN INTEREST PAID+)
      $interestAccount->balance += $dps_transaction->amount;
      $interestAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance += $dps_transaction->amount;
      $cashAccount->save();

      $unpaidInterestAccount = Account::find(8); //INCOME (LOAN INTEREST UNPAID-)
      $unpaidInterestAccount->balance -= $dps_transaction->amount;
      $unpaidInterestAccount->save();

      $unpaidInterestAccount1 = Account::find(5); //ASSET (LOAN INTEREST UNPAID-)
      $unpaidInterestAccount1->balance -= $dps_transaction->amount;
      $unpaidInterestAccount1->save();
    }
    if ($installment->advance > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 3,
        'description' => 'Advance',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->advance,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $advanceAccount = Account::find(3); //LIABILITY ( ADVANCE AMOUNT +)
      $advanceAccount->balance += $dps_transaction->amount;
      $advanceAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance += $dps_transaction->amount;
      $cashAccount->save();
    }
    if ($installment->advance_return > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 14,
        'description' => 'Advance Adjustment',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->advance_return,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $advanceAdjustAccount = Account::find(14); //LIABILITY ( ADVANCE AMOUNT -)
      $advanceAdjustAccount->balance += $dps_transaction->amount;
      $advanceAdjustAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH-)
      $cashAccount->balance -= $dps_transaction->amount;
      $cashAccount->save();
    }

    if ($installment->due > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 6,
        'description' => 'Due',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->due,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $dueAmountAccount = Account::find(6); //ASSET (DUE AMOUNT+)
      $dueAmountAccount->balance += $dps_transaction->amount;
      $dueAmountAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH-)
      $cashAccount->balance -= $dps_transaction->amount;
      $cashAccount->save();

    }

    if ($installment->due_return > 0) {
      $dps_transaction = Transaction::create([
        'account_id' => 15,
        'description' => 'Due Return',
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'amount' => $installment->due_return,
        'user_id' => $installment->collector_id,
        'account_no' => $installment->account_no,
        'name' => $installment->user->name,
      ]);

      $dueReturnAccount = Account::find(15); //ASSET (DUE AMOUNT-)
      $dueReturnAccount->balance += $dps_transaction->amount;
      $dueReturnAccount->save();

      $dueAmountAccount = Account::find(6); //ASSET (DUE AMOUNT-)
      $dueAmountAccount->balance -= $dps_transaction->amount;
      $dueAmountAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance += $dps_transaction->amount;
      $cashAccount->save();

    }
  }

  public function import(Request $request)
  {
    Excel::import(new SpecialInstallmentImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }
}
