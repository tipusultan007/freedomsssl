<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\SpecialLoanAccount;
use App\Http\Controllers\Accounts\SpecialLoanPaymentAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DpsLoanInterest;
use App\Models\Fdr;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\SpecialDps;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SpecialDpsLoan;
use App\Http\Requests\SpecialDpsLoanStoreRequest;
use App\Http\Requests\SpecialDpsLoanUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecialDpsLoanController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //$this->authorize('view-any', SpecialDpsLoan::class);

    $search = $request->get('search', '');
    $users = User::all();
    $specialDpsLoans = SpecialDpsLoan::search($search)
      ->latest()
      ->paginate(5)
      ->withQueryString();

    return view(
      'app.special_dps_loans.index',
      compact('specialDpsLoans', 'search', 'users')
    );
  }

  public function dataSpecialDpsLoans(Request $request)
  {
    $totalData = SpecialDpsLoan::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');

    if (empty($request->input('search.value'))) {
      $posts = SpecialDpsLoan::with('user')
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = SpecialDpsLoan::with('user')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->Where('name', 'LIKE', "%{$search}%");
        })->offset($start)
        ->limit($limit)
        ->orderBy('special_dps_loans.account_no', 'asc')
        ->get();

      $totalFiltered = SpecialDpsLoan::with('user')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->Where('name', 'LIKE', "%{$search}%");
        })->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('special-dps-loans.show', $post->id);
        $edit = route('special-dps-loans.edit', $post->id);

        $date = new Carbon($post->opening_date);
        $commencement = new Carbon($post->commencement);
        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['date'] = $commencement->format('d/m/Y');
        //$nestedData['commencement'] = $post->commencement;
        $nestedData['loan_amount'] = $post->loan_amount;
        $nestedData['total_paid'] = $post->total_paid;
        $nestedData['remain_loan'] = $post->remain_loan;
        $nestedData['phone'] = $post->user->phone1 ?? '';
        $nestedData['image'] = $post->user->image;
        $nestedData['status'] = $post->status;
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
    //$this->authorize('create', SpecialDpsLoan::class);

    $users = User::select('name', 'id','father_name')->get();

    return view(
      'app.special_dps_loans.create',
      compact('users')
    );
  }

  /**
   * @param \App\Http\Requests\SpecialDpsLoanStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //$this->authorize('create', SpecialDpsLoan::class);
    $data = $request->all();
    $data['trx_id'] = Str::uuid();
    $dps = SpecialDps::where('account_no', $request->account_no)->first();
    $loan = SpecialDpsLoan::where('account_no', $request->account_no)->first();
    $data['trx_type'] = "cash";
    if ($loan) {
      $data['before_loan'] = $loan->remain_loan;
      $loan->loan_amount += $request->loan_amount;
      $loan->remain_loan += $request->loan_amount;
      $loan->save();
      $data['after_loan'] = $loan->remain_loan;
      $data['manager_id'] = Auth::id();
      $data['special_dps_loan_id'] = $loan->id;
      $data['date'] = $request->opening_date;
      $data['remain'] = $request->loan_amount;
      $data['user_id'] = $dps->user_id;
      $takenLoan = SpecialLoanTaken::create($data);

      $data['special_taken_loan_id'] = $takenLoan->id;
      LoanDocuments::create($data);
      $data['user_id'] = $request->guarantor_user_id;
      Guarantor::create($data);

      $data['name'] = $loan->user->name;

      //SpecialLoanAccount::create($data);
      //$transaction = $this->accountTransaction($takenLoan);
    } else {
      $data['manager_id'] = Auth::id();
      $data['remain_loan'] = $request->loan_amount;
      $data['user_id'] = $dps->user_id;
      $dpsLoan = SpecialDpsLoan::create($data);
      $data['special_dps_loan_id'] = $dpsLoan->id;
      $data['date'] = $request->opening_date;
      $data['remain'] = $request->loan_amount;
      $data['before_loan'] = 0;
      $data['after_loan'] = $request->loan_amount;
      $takenLoan = SpecialLoanTaken::create($data);
      $data['special_taken_loan_id'] = $takenLoan->id;
      LoanDocuments::create($data);
      $data['user_id'] = $request->guarantor_user_id;
      Guarantor::create($data);
      //SpecialLoanAccount::create($data);
      //$transaction = $this->accountTransaction($takenLoan);
    }
    return redirect()->back()->with('success','বিশেষ ঋণ বিতরণ সফল হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDpsLoan $specialDpsLoan
   * @return \Illuminate\Http\Response
   */

  public function show(Request $request, SpecialDpsLoan $specialDpsLoan)
  {
    //$this->authorize('view', $specialDpsLoan);

    return view('app.special_dps_loans.show', compact('specialDpsLoan'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDpsLoan $specialDpsLoan
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, SpecialDpsLoan $specialDpsLoan)
  {
    //$this->authorize('update', $specialDpsLoan);

    $users = User::pluck('name', 'id');

    return view(
      'app.special_dps_loans.edit',
      compact('specialDpsLoan', 'users', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\SpecialDpsLoanUpdateRequest $request
   * @param \App\Models\SpecialDpsLoan $specialDpsLoan
   * @return \Illuminate\Http\Response
   */
  public function update(
    SpecialDpsLoanUpdateRequest $request,
    SpecialDpsLoan              $specialDpsLoan
  )
  {
    //$this->authorize('update', $specialDpsLoan);

    $validated = $request->validated();

    $specialDpsLoan->update($validated);

    return redirect()
      ->route('special-dps-loans.edit', $specialDpsLoan)
      ->withSuccess(__('crud.common.saved'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDpsLoan $specialDpsLoan
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dpsLoan = SpecialDpsLoan::find($id);
    //$this->authorize('delete', $dpsLoan);

    $takenLoans = SpecialLoanTaken::where('special_dps_loan_id', $id)->get();

    foreach ($takenLoans as $takenLoan) {
      SpecialLoanPayment::where('special_loan_taken_id', $takenLoan->id)->delete();
      SpecialLoanInterest::where('special_loan_taken_id', $takenLoan->id)->delete();
      $takenLoan->delete();
    }
    $dpsInstallments = SpecialInstallment::where('special_dps_loan_id', $id)->get();
    foreach ($dpsInstallments as $dpsInstallment) {
      if ($dpsInstallment->special_dps_id !=""){
        $total = 0;
        if ($dpsInstallment->loan_installment > 0) {
          $total += $dpsInstallment->loan_installment;
        }
        if ($dpsInstallment->interest > 0) {
          $total += $dpsInstallment->interest;
        }
        if ($dpsInstallment->due_interest > 0) {
          $total += $dpsInstallment->due_interest;
        }
        $dpsInstallment->total -= $total;
        $dpsInstallment->loan_grace = NULL;
        $dpsInstallment->loan_installment = NULL;
        $dpsInstallment->interest = NULL;
        $dpsInstallment->loan_balance = NULL;
        $dpsInstallment->due_interest = NULL;
        $dpsInstallment->loan_note = NULL;
        $dpsInstallment->special_dps_loan_id = NULL;
        $dpsInstallment->save();
      }else{
        $dpsInstallment->delete();
      }
    }
    SpecialLoanCollection::where('special_dps_loan_id',$dpsLoan->id)->delete();
    $dpsLoan->delete();
    return "success";

  }

  public function loanList($id)
  {
    $loans = SpecialLoanTaken::where('special_dps_loan_id', $id)
      ->select('id', 'date', 'loan_amount', 'interest1', 'interest2', 'upto_amount', 'remain', 'commencement')->get();

    echo json_encode($loans);
  }

  public function resetLoan($id)
  {
    $loan = SpecialDpsLoan::find($id);
    $loan->remain_loan = $loan->loan_amount;
    $loan->paid_interest = 0;
    $loan->total_paid = 0;
    $loan->dueInterest = 0;
    $loan->grace = 0;
    $loan->save();

    $installments = SpecialInstallment::where('account_no', $loan->account_no)
      ->where('loan_installment', '>', 0)
      ->orWhere('interest', '>', 0)
      ->get();
    $takenLoans = SpecialLoanTaken::where('account_no', $loan->account_no)->get();

    foreach ($installments as $installment) {
      SpecialLoanCollection::where('special_installment_id', $installment->id)->delete();
      SpecialLoanInterest::where('special_installment_id', $installment->id)->delete();
      SpecialLoanPayment::where('special_installment_id', $installment->id)->delete();
      CashIn::where('cashin_category_id', 8)->where('special_installment_id', $installment->id)->delete();

      if ($installment->dps_amount == 0 && $installment->dps_amount == NULL) {
        $installment->delete();
      } else {

        if ($installment->loan_installment > 0) {
          $installment->total -= $installment->loan_installment;
          $installment->loan_installment = NULL;
          $installment->save();
          SpecialLoanPaymentAccount::delete($installment->trx_id);
        }

        if ($installment->interest > 0) {
          $installment->total -= $installment->interest;
          $installment->interest = NULL;
          $installment->save();
          PaidInterestAccount::delete($installment->trx_id, 'special');
        }

        if ($installment->loan_late_fee > 0) {
          $installment->total -= $installment->loan_late_fee;
          $installment->loan_late_fee = NULL;
          $installment->save();
          LateFeeAccount::delete($installment->trx_id);
        }
        if ($installment->loan_other_fee > 0) {
          $installment->total -= $installment->loan_other_fee;
          $installment->loan_other_fee = NULL;
          $installment->save();
          OtherFeeAccount::delete($installment->trx_id);
        }

        if ($installment->loan_grace > 0) {
          GraceAccount::delete($installment->trx_id);
        }

        $installment->special_dps_loan_id = NULL;
        $installment->loan_balance = NULL;
        $installment->due_interest = NULL;
        $installment->loan_note = NULL;
        $installment->save();
      }
    }

    foreach ($takenLoans as $takenLoan) {
      $takenLoan->remain = $takenLoan->loan_amount;
      $takenLoan->save();
    }

  }

  public function accountTransaction(SpecialLoanTaken $loan)
  {
    $transaction = Transaction::create([
      'account_id' => 2,
      'description' => 'Special Loan Provide',
      'trx_id' => TransactionController::trxId(),
      'date' => $loan->date,
      'amount' => $loan->loan_amount,
      'user_id' => $loan->created_by,
      'account_no' => $loan->account_no,
      'name' => $loan->user->name,
    ]);
    $loanProvide = Account::find(2);
    $loanProvide->balance += $transaction->amount;
    $loanProvide->save();

    $cashAccount = Account::find(4);
    $cashAccount->balance -= $transaction->amount;
    $cashAccount->save();
  }
}
