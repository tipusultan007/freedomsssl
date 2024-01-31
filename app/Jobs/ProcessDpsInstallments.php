<?php

namespace App\Jobs;

use App\Helpers\Helpers;
use App\Models\DailyLoanCollection;
use App\Models\Dps;
use App\Models\DpsCollection;
use App\Models\DpsInstallment;
use App\Models\DpsLoan;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\Due;
use App\Models\LoanPayment;
use App\Models\SpecialDps;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ProcessDpsInstallments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $collections;
    /**
     * Create a new job instance.
     */
    public function __construct($collections)
    {
        $this->collections = $collections;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      foreach ($this->collections as $installment)
      {
       /* if ($installment->due > 0) {

          $due = Due::create([
            'account_no' => $installment->account_no,
            'user_id' => $installment->user_id,
            'due' => $installment->due,
            'return' => 0,
            'balance' => $installment->due + $installment->user->due,
            'date' => $installment->date,
            'dps_installment_id' => $installment->id,
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
            'dps_installment_id' => $installment->id,
          ]);

          $installment->user->due -= $installment->due_return;
          $installment->user->save();

        }*/
       /* if ($installment->dps_amount>0){
          $dps = SpecialDps::find($installment->special_dps_id);
          $dpsCollections = SpecialDpsCollection::where('special_dps_id', $dps->id)->count();
          if ($dpsCollections > 0) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $date->addMonthsNoOverflow($dpsCollections);
            $dps->balance += $installment->dps_amount;
            $dps->total += $installment->dps_amount;
            $dps->deposited += $installment->dps_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'special_dps_id' => $installment->special_dps_id,
              'dps_amount' => $installment->dps_amount,
              'balance' =>  $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'manager_id' => $installment->manager_id,
              'special_installment_id' => $installment->id,
            ]);
          } else {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps->balance += $installment->dps_amount;
            $dps->total += $installment->dps_amount;
            $dps->deposited += $installment->dps_amount;
            $dps->save();
            $dpsCollection = SpecialDpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'special_dps_id' => $installment->special_dps_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'dps_amount' => $installment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'manager_id' => $installment->manager_id,
              'special_installment_id' => $installment->id,
            ]);
          }
          $installment->dps_balance = $dps->balance;
          $installment->save();
        }*/

        /*$interests = Helpers::getInterest($installment->account_no,$installment->date,'');
        if ($installment->loan_installment > 0 || $installment->interest > 0) {
          $loan = DpsLoan::find($installment->dps_loan_id);

          if ($installment->interest > 0) {
            foreach ($interests as $t) {
              if ($t['dueInstallment']>0)
              {
                $taken_loan = TakenLoan::find($t['taken_loan_id']);
                $dpsLoanInterests = DpsLoanInterest::where('taken_loan_id', $t['taken_loan_id'])->get();
                $totalInstallments = $dpsLoanInterests->sum('installments');
                if ($dpsLoanInterests->count() == 0) {
                  $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                  $dpsLoanInterest = DpsLoanInterest::create([
                    'taken_loan_id' => $t['taken_loan_id'],
                    'account_no' => $taken_loan->account_no,
                    'installments' => 1,
                    'dps_installment_id' => $installment->id,
                    'interest' => $t['interest'],
                    'total' => $t['interest'],
                    'month' => $l_date->format('F'),
                    'year' => $l_date->format('Y'),
                    'date' => $installment->date
                  ]);
                } else {
                  $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                  $date_diff = $totalInstallments ;
                  $l_date->addMonthsNoOverflow($date_diff);
                  $dpsLoanInterest = DpsLoanInterest::create([
                    'taken_loan_id' => $t['taken_loan_id'],
                    'account_no' => $taken_loan->account_no,
                    'installments' => 1,
                    'dps_installment_id' => $installment->id,
                    'interest' => $t['interest'],
                    'total' => $t['interest'],
                    'month' => $l_date->format('F'),
                    'year' => $l_date->format('Y'),
                    'date' => $installment->date
                  ]);
                }
              }
            }
            $loan->paid_interest += $installment->interest;
            $loan->save();

          }
          $unpaid_interest = 0;
          if ($installment->loan_installment > 0) {
            $interestOld = 0;
            $interestNew = 0;
            $loan->remain_loan -= $installment->loan_installment;
            $loan->total_paid += $installment->loan_installment;
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
                  'account_no' => $installment->account_no,
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
                  'account_no' => $installment->account_no,
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
//          $dpsLoanCollection = SpecialLoanCollection::create([
//            'account_no' => $installment->account_no,
//            'user_id' => $installment->user_id,
//            'special_dps_loan_id' => $installment->special_dps_loan_id,
//            'manager_id' => $installment->manager_id,
//            'special_installment_id' => $installment->id,
//            'loan_installment' => $installment->loan_installment,
//            'balance' => $loan->remain_loan,
//            'interest' => $installment->interest,
//            'due_interest' => $installment->due_interest,
//            'unpaid_interest' => $unpaid_interest,
//            'date' => $installment->date,
//            'receipt_no' => $installment->receipt_no,
//          ]);
          $installment->loan_balance = $loan->remain_loan;
          $installment->unpaid_interest = $unpaid_interest;
          $installment->save();

        }*/


        /*if ($installment->loan_installment > 0 || $installment->interest > 0) {
          $interests = Helpers::getSpecialInterest($installment->account_no,$installment->date,'');
          $loan = SpecialDpsLoan::find($installment->special_dps_loan_id);

          if ($installment->interest > 0) {
            foreach ($interests as $t) {
              if ($t['dueInstallment']>0)
              {
                $taken_loan = SpecialLoanTaken::find($t['taken_loan_id']);
                $dpsLoanInterests = SpecialLoanInterest::where('special_loan_taken_id', $t['taken_loan_id'])->get();
                $totalInstallments = $dpsLoanInterests->sum('installments');
                if ($dpsLoanInterests->count() == 0) {
                  $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                  $dpsLoanInterest = SpecialLoanInterest::create([
                    'special_loan_taken_id' => $t['taken_loan_id'],
                    'account_no' => $taken_loan->account_no,
                    'installments' => 1,
                    'special_installment_id' => $installment->id,
                    'interest' => $t['interest'],
                    'total' => $t['interest'],
                    'month' => $l_date->format('F'),
                    'year' => $l_date->format('Y'),
                    'date' => $installment->date
                  ]);
                } else {
                  $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                  $date_diff = $totalInstallments ;
                  $l_date->addMonthsNoOverflow($date_diff);
                  $dpsLoanInterest = SpecialLoanInterest::create([
                    'special_loan_taken_id' => $t['taken_loan_id'],
                    'account_no' => $taken_loan->account_no,
                    'installments' => 1,
                    'special_installment_id' => $installment->id,
                    'interest' => $t['interest'],
                    'total' => $t['interest'],
                    'month' => $l_date->format('F'),
                    'year' => $l_date->format('Y'),
                    'date' => $installment->date
                  ]);
                }
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
                  'account_no' => $installment->account_no,
                  'special_loan_taken_id' => $loanTaken->id,
                  'special_installment_id' => $installment->id,
                  'amount' => $tempRemain,
                  'balance' => $loanTaken->remain,
                  'date' => $installment->date,
                ]);
              } elseif ($loanTaken->remain >= $loanTakenRemain) {
                $loanTaken->remain -= $loanTakenRemain;
                $loanTaken->save();
                $loanPayment = SpecialLoanPayment::create([
                  'account_no' => $installment->account_no,
                  'special_loan_taken_id' => $loanTaken->id,
                  'special_installment_id' => $installment->id,
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

            //DpsLoanPaymentAccount::create($data);
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

        }*/

        /*Transaction::create([
          'account_no' => $installment->account_no,
          'user_id' => $installment->user_id,
          'amount' => $installment->total,
          'type' => 'cashin',
          'transactionable_id' => $installment->id,
          'transactionable_type' => SpecialInstallment::class,
          'date' => $installment->date,
          'manager_id' => $installment->manager_id
        ]);*/
      }
    }
}
