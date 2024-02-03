<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Profit;
use App\Models\SpecialDps;
use App\Models\SpecialDpsComplete;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialDpsCompleteController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $data['manager_id'] = Auth::id();
    $savingsComplete = SpecialDpsComplete::create($data);

    $dailySavings = SpecialDps::find($data['special_dps_id']);
    $dailySavings->withdraw += $savingsComplete->withdraw;
    $dailySavings->remain_profit += $savingsComplete->profit;
    $dailySavings->balance -= $savingsComplete->withdraw + $savingsComplete->profit;
    $dailySavings->save();
    $savingsComplete->remain = $dailySavings->balance;
    $savingsComplete->save();

    if ($savingsComplete->interest>0)
    {
      $data['interest'] = $savingsComplete->interest;
      $data['special_dps_complete_id'] = $savingsComplete->id;
      $this->payLoanInterest($data);
    }
    if ($savingsComplete->loan_payment>0)
    {
      $data['loan_installment'] = $savingsComplete->loan_payment;
      $data['special_dps_complete_id'] = $savingsComplete->id;
      $this->payLoanPayment($data);
    }

    if ($dailySavings->balance > 0) {
      $dailySavings->status = 'active';
    } else {
      $dailySavings->status = $dailySavings->loan ? $dailySavings->loan->remain_loan <= 0 ? 'complete' : 'active' : 'complete';
    }
    $dailySavings->save();

    return redirect()->back()->with('success', 'সঞ্চয় হিসাব প্রত্যাহার সফল হয়েছে!');
  }

  public function payLoanInterest($data)
  {
    $loan_taken_id = SpecialLoanTaken::where('special_dps_loan_id', $data['special_dps_loan_id'])
      ->where('remain', '>', 0)
      ->pluck('id')
      ->toArray();
    $all_interest_installments = Helpers::getSpecialInterest($data['account_no'], $data['date'], '');
    $interest_installments = [];
    $taken_interest = [];
    foreach ($all_interest_installments as $item) {
      $interest_installments[] = $item['dueInstallment'];
      $taken_interest[] = $item['interest'];
    }
    $loan = SpecialDpsLoan::find($data['special_dps_loan_id']);
    foreach ($loan_taken_id as $key => $t) {
      $taken_loan = SpecialLoanTaken::find($t);
      $dpsLoanInterests = SpecialLoanInterest::where('special_loan_taken_id', $t)->get();
      $totalInstallments = $dpsLoanInterests->sum('installments');
      if ($dpsLoanInterests->count() == 0) {
        $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
        if ($interest_installments[$key] > 1) {
          $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
        }
        $dpsLoanInterest = SpecialLoanInterest::create([
          'special_loan_taken_id' => $t,
          'account_no' => $taken_loan->account_no,
          'installments' => $interest_installments[$key],
          'interest' => $taken_interest[$key],
          'total' => $taken_interest[$key] * $interest_installments[$key],
          'month' => $l_date->format('F'),
          'year' => $l_date->format('Y'),
          'date' => $data['date'],
          'is_completed' => 'yes',
          'special_dps_complete_id' => $data['special_dps_complete_id'],
        ]);
      } else {
        $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
        $date_diff = $totalInstallments + $interest_installments[$key] - 1;
        $l_date->addMonthsNoOverflow($date_diff);
        $dpsLoanInterest = SpecialLoanInterest::create([
          'special_loan_taken_id' => $t,
          'account_no' => $taken_loan->account_no,
          'installments' => $interest_installments[$key],
          'interest' => $taken_interest[$key],
          'total' => $taken_interest[$key] * $interest_installments[$key],
          'month' => $l_date->format('F'),
          'year' => $l_date->format('Y'),
          'date' => $data['date'],
          'is_completed' => 'yes',
          'special_dps_complete_id' => $data['special_dps_complete_id'],
        ]);
      }
    }
    $loan->paid_interest += $data['interest'];
    $loan->save();
  }

  public function payLoanPayment($data)
  {
    $loan = SpecialDpsLoan::find($data['special_dps_loan_id']);
    $unpaid_interest = 0;
    $interestOld = 0;
    $interestNew = 0;
    $loan->remain_loan -= $data['loan_installment'];
    $loan->save();
    $interestOld = Helpers::getSpecialInterest($data['account_no'], $data['date'], 'interest');

    $loanTakens = SpecialLoanTaken::where('special_dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'desc')->get();
    $loanTakenRemain = $data['loan_installment'];
    foreach ($loanTakens as $key => $loanTaken) {
      if ($loanTakenRemain == 0) {
        break;
      } elseif ($loanTaken->remain <= $loanTakenRemain) {
        $tempRemain = $loanTaken->remain;
        $loanTakenRemain -= $loanTaken->remain;
        $loanTaken->remain -= $tempRemain;
        $loanTaken->save();

        $loanPayment = SpecialLoanPayment::create([
          'account_no' => $data['account_no'],
          'special_loan_taken_id' => $loanTaken->id,
          'amount' => $tempRemain,
          'balance' => $loanTaken->remain,
          'date' => $data['date'],
          'is_completed' => 'yes',
          'special_dps_complete_id' => $data['special_dps_complete_id'],
        ]);
      } elseif ($loanTaken->remain >= $loanTakenRemain) {
        $loanTaken->remain -= $loanTakenRemain;
        $loanTaken->save();
        $loanPayment = SpecialLoanPayment::create([
          'account_no' => $data['account_no'],
          'special_loan_taken_id' => $loanTaken->id,
          'amount' => $loanTakenRemain,
          'balance' => $loanTaken->remain,
          'date' => $data['date'],
          'is_completed' => 'yes',
          'special_dps_complete_id' => $data['special_dps_complete_id'],
        ]);
        $loanTakenRemain = 0;

        break;
      }
    }

    $interestNew = Helpers::getInterest($data['account_no'], $data['date'], 'interest');

    if ($interestOld >= $interestNew) {
      $unpaid_interest = $interestOld - $interestNew;
      $loan->dueInterest += $unpaid_interest;
      $loan->save();
    }
  }
  /**
   * Display the specified resource.
   */
  public function show(SpecialDpsComplete $specialDpsComplete)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(SpecialDpsComplete $specialDpsComplete)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, SpecialDpsComplete $specialDpsComplete)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, $id)
  {
    $dpsComplete = SpecialDpsComplete::with('specialDps')->find($id);
    $dpsComplete->specialDps->update([
      'balance' => $dpsComplete->specialDps->balance + ($dpsComplete->withdraw + $dpsComplete->profit),
      'withdraw' => $dpsComplete->specialDps->withdraw - $dpsComplete->withdraw ,
      'status' => 'active'
    ]);

    $profit = Profit::where('account_no',$dpsComplete->specialDps->account_no)->first();
    if ($profit){
      $profit->remain_profit -= $dpsComplete->profit;
      $profit->save();
    }

    $loan = SpecialDpsLoan::find($dpsComplete->special_dps_loan_id);

    if ($dpsComplete->loan_payment > 0) {
      $loanPayments = SpecialLoanPayment::where('special_dps_complete_id', $id)->get();
      foreach ($loanPayments as $loanPayment) {
        $loanTaken = SpecialLoanTaken::find($loanPayment->special_loan_taken_id);
        $loanTaken->remain += $loanPayment->amount;
        $loanTaken->save();
        $loanPayment->delete();
      }
      $loan->remain_loan += $dpsComplete->loan_payment;
      $loan->save();
    }
    if ($dpsComplete->interest > 0) {
      SpecialLoanInterest::where('special_dps_complete_id', $id)->delete();
      $loan->paid_interest -= $dpsComplete->interest;
      $loan->save();
    }

    $dpsComplete->delete();

  }
}
