<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Dps;
use App\Models\DpsComplete;
use App\Models\DpsLoan;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\LoanPayment;
use App\Models\TakenLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpsCompleteController extends Controller
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
      $savingsComplete = DpsComplete::create($data);

      $dailySavings = Dps::find($data['dps_id']);
      $dailySavings->withdraw += $savingsComplete->withdraw;
      $dailySavings->remain_profit -= $savingsComplete->profit;
      $dailySavings->balance -= $savingsComplete->withdraw + $savingsComplete->profit;
      $dailySavings->save();
      $savingsComplete->remain = $dailySavings->balance;
      $savingsComplete->save();
      if ($savingsComplete->loan_payment>0)
      {
        $loan = DpsLoan::find($savingsComplete->dps_loan_id);
        $loan->remain_loan -= $savingsComplete->loan_payment;
        $loan->paid_interest += $savingsComplete->interest;
        $loan->grace += $savingsComplete->grace;
        $loan->status= 'complete';
        $loan->save();
        $data['loan_installment'] = $savingsComplete->loan_payment;
        $data['interest'] = $savingsComplete->interest;

        $completeLoanInterest = $this->payLoanInterest($data);
      }
      if ($dailySavings->balance<= 0)
      {
        $dailySavings->status = 'complete';
        $dailySavings->save();
      }else{
        $dailySavings->status = 'active';
        $dailySavings->save();
      }

      return redirect()->back()->with('success','সঞ্চয় হিসাব প্রত্যাহার সফল হয়েছে!');
    }
    public function payLoanInterest($data)
    {
      //$all_takenLoans = TakenLoan::where('dps_loan_id',$data['dps_loan_id'])->where('remain','>',0)->get();
      $loan_taken_id = TakenLoan::where('dps_loan_id', $data['dps_loan_id'])
        ->where('remain', '>', 0)
        ->pluck('id')
        ->toArray();
      $all_interest_installments = Helpers::getInterest($data['account_no'],$data['date'],'');
      $interest_installments = [];
      $taken_interest = [];
      foreach ($all_interest_installments as $item)
      {
        $interest_installments[] = $item['dueInstallment'];
        $taken_interest[] = $item['interest'];
      }
      //$interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
      //$taken_interest = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';

      if ($data['loan_installment'] > 0 || $data['interest'] > 0) {
        $loan = DpsLoan::find($data['dps_loan_id']);

        if ($data['interest'] > 0) {
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
                'interest' => $taken_interest[$key],
                'total' => $taken_interest[$key] * $interest_installments[$key],
                'month' => $l_date->format('F'),
                'year' => $l_date->format('Y'),
                'date' => $data['date'],
                'is_completed' => 'yes'
              ]);
            } else {
              $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
              $date_diff = $totalInstallments + $interest_installments[$key] - 1;
              $l_date->addMonthsNoOverflow($date_diff);
              $dpsLoanInterest = DpsLoanInterest::create([
                'taken_loan_id' => $t,
                'account_no' => $taken_loan->account_no,
                'installments' => $interest_installments[$key],
                'interest' => $taken_interest[$key],
                'total' => $taken_interest[$key] * $interest_installments[$key],
                'month' => $l_date->format('F'),
                'year' => $l_date->format('Y'),
                'date' => $data['date'],
                'is_completed' => 'yes'
              ]);
            }
          }
          $loan->paid_interest += $data['interest'];
          $loan->save();

          $data['interest_type'] = 'dps';
          //PaidInterestAccount::create($data);
        }
        $unpaid_interest = 0;
        if ($data['loan_installment'] > 0) {
          $interestOld = 0;
          $interestNew = 0;
          //$loan->remain_loan -= $data['loan_installment'];
          //$loan->save();
          $interestOld = Helpers::getInterest($data['account_no'], $data['date'], 'interest');


          $loanTakens = TakenLoan::where('dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'desc')->get();
          $loanTakenRemain = $data['loan_installment'];
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
                'amount' => $tempRemain,
                'balance' => $loanTaken->remain,
                'date' => $data['date'],
                'is_completed' => 'yes'
              ]);
            } elseif ($loanTaken->remain >= $loanTakenRemain) {
              $loanTaken->remain -= $loanTakenRemain;
              $loanTaken->save();
              $loanPayment = LoanPayment::create([
                'account_no' => $data['account_no'],
                'taken_loan_id' => $loanTaken->id,
                'amount' => $loanTakenRemain,
                'balance' => $loanTaken->remain,
                'date' => $data['date'],
                'is_completed' => 'yes'
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

          //DpsLoanPaymentAccount::create($data);
        }


      }
    }
    /**
     * Display the specified resource.
     */
    public function show(DpsComplete $dpsComplete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DpsComplete $dpsComplete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DpsComplete $dpsComplete)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DpsComplete $dpsComplete)
    {

    }
}
