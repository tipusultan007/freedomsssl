<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\SpecialLoanAccount;
use App\Http\Controllers\Accounts\SpecialLoanPaymentAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DpsLoanInterest;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialLoanTaken;
use App\Http\Requests\SpecialLoanTakenStoreRequest;
use App\Http\Requests\SpecialLoanTakenUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecialLoanTakenController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $search = $request->get('search', '');

    $specialLoanTakens = SpecialLoanTaken::search($search)
      ->latest()
      ->paginate(5)
      ->withQueryString();

    return view(
      'app.special_loan_takens.index',
      compact('specialLoanTakens', 'search')
    );
  }

  public function dataSpecialTakenLoans(Request $request)
  {
    if (!empty($request->dps_loan_id)) {
      $totalData = SpecialLoanTaken::where('special_dps_loan_id', $request->dps_loan_id)->count();
    } elseif (!empty($request->account_no)) {
      $totalData = SpecialLoanTaken::where('special_dps_loan_id', $request->account_no)->count();
    } else {
      $totalData = SpecialLoanTaken::count();
    }


    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');

    if (empty($request->input('search.value'))) {
      if (!empty($request->dps_loan_id)) {
        $posts = SpecialLoanTaken::leftJoin('users', 'users.id', '=', 'special_loan_takens.user_id')
          ->leftJoin('users as c', 'c.id', '=', 'special_loan_takens.created_by')
          ->select('special_loan_takens.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
          ->offset($start)
          ->limit($limit)
          ->orderBy('special_loan_takens.account_no', 'asc')
          ->where('special_loan_takens.special_dps_loan_id', $request->dps_loan_id)
          ->get();
      } elseif (!empty($request->account_no)) {
        $posts = SpecialLoanTaken::leftJoin('users', 'users.id', '=', 'special_loan_takens.user_id')
          ->leftJoin('users as c', 'c.id', '=', 'special_loan_takens.created_by')
          ->select('special_loan_takens.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
          ->offset($start)
          ->limit($limit)
          ->orderBy('special_loan_takens.id', 'asc')
          ->where('special_loan_takens.account_no', $request->account_no)
          ->get();
      } else {
        $posts = SpecialLoanTaken::leftJoin('users', 'users.id', '=', 'special_loan_takens.user_id')
          ->leftJoin('users as c', 'c.id', '=', 'special_loan_takens.created_by')
          ->select('special_loan_takens.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
          ->offset($start)
          ->limit($limit)
          ->orderBy('special_loan_takens.account_no', 'asc')
          ->get();
      }
    } else {
      $search = $request->input('search.value');

      $posts = SpecialLoanTaken::leftJoin('users', 'users.id', '=', 'special_loan_takens.user_id')
        ->leftJoin('users as c', 'c.id', '=', 'special_loan_takens.created_by')
        ->select('special_loan_takens.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
        ->where('special_loan_takens.account_no', 'LIKE', "%{$search}%")
        ->where('users.name', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy('special_loan_takens.account_no', 'asc')
        ->get();

      $totalFiltered = SpecialLoanTaken::leftJoin('users', 'users.id', '=', 'special_loan_takens.user_id')
        ->leftJoin('users as c', 'c.id', '=', 'special_loan_takens.created_by')
        ->where('special_loan_takens.account_no', 'LIKE', "%{$search}%")
        ->where('users.name', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('taken-loans.show', $post->id);
        $edit = route('taken-loans.edit', $post->id);

        $date                     = new Carbon($post->date);
        $commencement             = new Carbon($post->commencement);
        $nestedData['id']         = $post->id;
        $nestedData['name']       = $post->name;
        $nestedData['history']    = $post->before_loan;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['date']       = $date->format('d/m/Y');
        //$nestedData['commencement'] = $post->commencement;
        $nestedData['loan_amount'] = $post->loan_amount;
        //$nestedData['interest'] = $post->interest1.'%';
        if ($post->interest2 > 0) {
          $nestedData['interest'] = $post->interest1 . '%' . ' | ' . $post->interest2 . '%';
        } else {
          $nestedData['interest'] = $post->interest1 . '%';
        }
        $nestedData['upto_amount'] = $post->upto_amount ?? 'N/A';
        $nestedData['remain']      = $post->remain;
        $nestedData['phone']       = $post->phone1;
        $nestedData['createdBy']   = $post->createdBy;
        $nestedData['photo']       = $post->profile_photo_path;
        $data[]                    = $nestedData;

      }
    }

    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );

    echo json_encode($json_data);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $this->authorize('create', SpecialLoanTaken::class);

    $users           = User::pluck('name', 'id');
    $specialDpsLoans = SpecialDpsLoan::pluck('account_no', 'id');

    return view(
      'app.special_loan_takens.create',
      compact('users', 'specialDpsLoans', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\SpecialLoanTakenStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(SpecialLoanTakenStoreRequest $request)
  {

    $validated = $request->validated();

    $specialLoanTaken = SpecialLoanTaken::create($validated);

    return redirect()
      ->route('special-loan-takens.edit', $specialLoanTaken)
      ->withSuccess(__('crud.common.created'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialLoanTaken $specialLoanTaken
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, SpecialLoanTaken $specialLoanTaken)
  {

    return view('app.special_loan_takens.show', compact('specialLoanTaken'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialLoanTaken $specialLoanTaken
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, SpecialLoanTaken $specialLoanTaken)
  {

    $users           = User::select('father_name','name', 'id')->get();
    $specialDpsLoans = SpecialDpsLoan::pluck('account_no', 'id');

    return view(
      'app.special_loan_takens.edit',
      compact('specialLoanTaken', 'users', 'specialDpsLoans')
    );
  }

  /**
   * @param \App\Http\Requests\SpecialLoanTakenUpdateRequest $request
   * @param \App\Models\SpecialLoanTaken $specialLoanTaken
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, SpecialLoanTaken $specialLoanTaken)
  {

    $validated = $request->validated();

    $specialLoanTaken->update($validated);


    return redirect()
      ->route('special-loan-takens.edit', $specialLoanTaken)
      ->with('success','বিশেষ ঋণ আপডেট সফল হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialLoanTaken $specialLoanTaken
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    $specialLoanTaken = SpecialLoanTaken::with('interests','specialDpsLoan','payments')->find($id);
    $specialDpsLoan = SpecialDpsLoan::find($specialLoanTaken->special_dps_loan_id);
    $specialDpsLoan->loan_amount -= $specialLoanTaken->loan_amount;
    $specialDpsLoan->remain_loan -= $specialLoanTaken->remain;
    $specialDpsLoan->paid_interest -= $specialLoanTaken->interests->sum('total');
    $specialDpsLoan->save();

    $loanPayments = $specialLoanTaken->payments;
    foreach ($loanPayments as $payment)
    {
      $installment = SpecialInstallment::find($payment->special_installment_id);
      $installment->loan_installment -= $payment->amount;
      $installment->loan_balance -= $payment->amount;
      $installment->total -= $payment->amount;
      $installment->save();

      $loanCollection = SpecialLoanCollection::where('special_installment_id',$payment->special_installment_id)->first();
      $loanCollection->loan_installment -= $payment->amount;
      $loanCollection->balance -= $payment->amount;
      $loanCollection->save();

      $payment->delete();
    }

    $loanInterests = $specialLoanTaken->interests;
    foreach ($loanInterests as $interest)
    {
      $installment = SpecialInstallment::find($interest->special_installment_id);
      $installment->interest -= $interest->amount;
      $installment->total -= $interest->amount;
      $installment->save();

      $loanCollection = SpecialLoanCollection::where('special_installment_id',$installment->id)->first();
      $loanCollection->interest -= $interest->total;
      $loanCollection->save();
      if ($loanCollection->loan_installment<1 && $loanCollection->interest <1)
      {
        $loanCollection->delete();
      }
      $interest->delete();
    }
    $specialLoanTaken->delete();

    return response()->json('ঋণ ডিলেট করা হয়েছে!');
  }

  public function dataTakenLoanTransaction(Request $request)
  {
    $q_date         = 'special_installments.date';
    $q_loan         = 'special_loan_payments.amount';
    $q_remain       = 'special_loan_payments.balance';
    $q_interest     = 'special_loan_interests.total as totalInterest';
    $q_installments = 'special_loan_interests.installments';
    $q_rate         = 'special_loan_interests.interest';
    $totalData      = SpecialInstallment::leftJoin('special_loan_interests', 'special_loan_interests.special_installment_id', '=', 'special_installments.id')
      ->leftJoin('special_loan_payments', 'special_loan_payments.special_installment_id', '=', 'special_installments.id')
      ->select($q_date, $q_loan, $q_remain, $q_interest, $q_installments, $q_rate)
      ->where('special_loan_interests.special_loan_taken_id', $request->loanId)
      ->orWhere('special_loan_payments.special_loan_taken_id', $request->loanId)
      ->count();

    $totalFiltered = $totalData;
    $limit         = $request->input('length');
    $start         = $request->input('start');
    if (empty($request->input('search.value'))) {

      $posts = DB::table('special_installments')
        ->leftJoin('special_loan_interests', 'special_loan_interests.special_installment_id', '=', 'special_installments.id')
        ->leftJoin('special_loan_payments', 'special_loan_payments.special_installment_id', '=', 'special_installments.id')
        ->select($q_date, $q_loan, $q_remain, $q_interest, $q_installments, $q_rate, 'special_loan_interests.id as interestId', 'special_loan_payments.id as paymentId')
        ->where('special_loan_interests.special_loan_taken_id', $request->loanId)
        ->orWhere('special_loan_payments.special_loan_taken_id', $request->loanId)
        ->offset($start)
        ->limit($limit)
        ->orderBy('special_installments.id', 'desc')
        ->get();

    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        //$show = route('dps-collections.show', $post->id);
        //$edit = route('dps-collections.edit', $post->id);

        $date                           = new Carbon($post->date);
        $nestedData['paymentId']        = $post->paymentId;
        $nestedData['interestId']       = $post->interestId;
        $nestedData['date']             = $date->format('d/m/Y');
        $nestedData['loan_installment'] = $post->amount;
        $nestedData['remain']           = $post->balance;
        $nestedData['interest']         = $post->totalInterest;
        $nestedData['installments']     = $post->installments;
        $nestedData['rate']             = $post->interest;
        $data[]                         = $nestedData;

      }
    }

    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );

    echo json_encode($json_data);
  }

  public function deleteInterestByLoanId($id)
  {
    $loanInterest    = SpecialLoanInterest::find($id);
    $dps_installment = SpecialInstallment::find($loanInterest->special_installment_id);
    $loanCollection  = SpecialLoanCollection::where('special_installment_id', $loanInterest->special_installment_id)->first();
    $loan            = SpecialDpsLoan::find($dps_installment->special_dps_loan_id);
    if ($loan->paid_interest > 0) {
      $loan->paid_interest -= $loanInterest->total;
    }
    $loan->save();

    $dps_installment->interest -= $loanInterest->total;
    $dps_installment->total    -= $loanInterest->total;
    $loanCollection->interest  -= $loanInterest->total;
    $cashin                    = CashIn::where('cashin_category_id', 8)->where('special_installment_id', $dps_installment->id)->latest()->first();
    $cashin->amount            -= $loanInterest->total;
    $cashin->save();
    $loanCollection->save();
    $dps_installment->save();
    $loanInterest->delete();
    PaidInterestAccount::delete($dps_installment->trx_id,'special');
    echo "success";

  }

  public function deleteLoanPaymentByLoanId($id)
  {
    $loanPayment                         = SpecialLoanPayment::find($id);
    $loanTaken                           = SpecialLoanTaken::find($loanPayment->special_loan_taken_id);
    $loan                                = SpecialDpsLoan::find($loanTaken->special_dps_loan_id);
    $dpsInstallment                      = SpecialInstallment::find($loanPayment->special_installment_id);
    $dpsLoanCollection                   = SpecialLoanCollection::where('special_installment_id', $loanPayment->special_installment_id)->first();
    $dpsLoanCollection->loan_installment -= $loanPayment->amount;
    $dpsInstallment->loan_installment    -= $loanPayment->amount;
    $loan->remain_loan                   += $loanPayment->amount;
    $loanTaken->remain                   += $loanPayment->amount;
    $loan->save();
    $loanTaken->save();
    $dpsInstallment->save();
    SpecialLoanPaymentAccount::delete($dpsInstallment);
    $dpsLoanCollection->save();
    $cashin         = CashIn::where('cashin_category_id', 8)->where('special_installment_id', $dpsInstallment->id)->latest()->first();
    $cashin->amount -= $loanPayment->amount;
    $cashin->save();
    $loanPayment->delete();

    echo "success";
  }

}
