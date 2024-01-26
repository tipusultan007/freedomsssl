<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Jobs\ProcessDailyLoanCollections;
use App\Jobs\ProcessDpsInstallments;
use App\Jobs\ProcessSavingsCollections;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DailyLoanPackage;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsCollection;
use App\Models\DpsComplete;
use App\Models\DpsInstallment;
use App\Models\DpsLoan;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\LoanPayment;
use App\Models\ProfitCollection;
use App\Models\SavingsCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialDpsComplete;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function test()
    {
     /* $completes = DpsComplete::with('dps')->get();
      foreach ($completes as $complete)
      {
        if ($complete->dps)
        {
          $dailySavings = Dps::find($complete->dps_id);
          $dailySavings->withdraw += $complete->withdraw;
          $dailySavings->remain_profit -= $complete->profit;
          $dailySavings->total -= $complete->withdraw + $complete->profit;
          $dailySavings->save();
          $complete->remain = $dailySavings->total;
          $complete->save();

        }
      }*/
     /*$completes = SpecialDpsComplete::with('specialDps')->get();
     $data = [];
     foreach ($completes as $dpsComplete)
     {
       if ($dpsComplete->specialDps) {
         $dpsComplete->user_id = $dpsComplete->specialDps->user_id;
         $dpsComplete->account_no = $dpsComplete->specialDps->account_no;
         $dpsComplete->save();

         $cashout = $dpsComplete->withdraw + $dpsComplete->profit;
         $cashIn = $dpsComplete->loan_payment + $dpsComplete->interest - $dpsComplete->grace;
         $total = 0;
         $type = '';
         if ($cashout > $cashIn) {
           $total = $cashout - $cashIn;
           $type = 'cashout';
         } else {
           $total = $cashIn - $cashout;
           $type = 'cashin';
         }
         // Create a new Transaction record
         Transaction::create([
           'account_no' => $dpsComplete->account_no,
           'user_id' => $dpsComplete->user_id,
           'amount' => $total,
           'type' => $type,
           'transactionable_id' => $dpsComplete->id,
           'transactionable_type' => SpecialDpsComplete::class,
           'date' => $dpsComplete->date,
           'manager_id' => $dpsComplete->manager_id
         ]);
       }
     }*/
      /*$installments = SpecialInstallment::where('id','>',1986)->orderBy('date','asc')->get();
      foreach ($installments as $installment)
      {
        $saving = SpecialDps::where('account_no',$installment->account_no)->first();
        $saving->balance += $installment->dps_amount;
        $saving->save();
        $dpsCollection = SpecialDpsCollection::create([
          'account_no' => $installment->account_no,
          'user_id' => $installment->user_id,
          'special_dps_id' => $installment->special_dps_id,
          'dps_amount' => $installment->dps_amount,
          'balance' => $saving->balance,
          'month' => 'January',
          'year' => 2024,
          'date' => $installment->date,
          'manager_id' => $installment->manager_id,
          'special_installment_id' => $installment->id,
        ]);

        Transaction::create([
          'account_no' => $installment->account_no,
          'user_id' => $installment->user_id,
          'amount' => $installment->total,
          'type' => 'cashin',
          'transactionable_id' => $installment->id,
          'transactionable_type' => SpecialInstallment::class,
          'date' => $installment->date,
          'manager_id' => $installment->manager_id
        ]);
      }*/

/*$installments = DpsLoanCollection::all();
$data = [];
foreach ($installments as $installment)
{

}
echo '<pre>';
print_r(array_unique($data));
echo '</pre>';*/
//      $fdrProfits = DailyLoan::all();
//      $data = [];
//      foreach ($fdrProfits as $loan)
//      {
//        $saving = DailySavings::where('account_no',$loan->account_no)->first();
//        $loan->daily_savings_id = $saving->id;
//          $loan->save();
        /*$data[] = $fdrDeposit->fdr_id;
        $profit->fdr_id = $fdrDeposit->fdr_id;
        $profit->save();*/
        /*Transaction::create([
          'account_no' => $profit->account_no,
          'user_id' => $profit->user_id,
          'amount' => $profit->profit,
          'type' => 'cashout',
          'transactionable_id' => $profit->id,
          'transactionable_type' => FdrProfit::class,
          'date' => $profit->date,
          'manager_id' => $profit->manager_id
        ]);*/
     // }

      /*$collections = DpsInstallment::where('id','>',97049)->whereNotNull('dps_loan_id')->orderBy('id','asc')->get();
      foreach ($collections as $collection)
      {
        $dpsLoanCollection = DpsLoanCollection::create([
          'account_no' => $collection->account_no,
          'user_id' => $collection->user_id,
          'dps_loan_id' => $collection->dps_loan_id,
          'manager_id' => $collection->manager_id,
          'dps_installment_id' => $collection->id,
          'loan_installment' => $collection->loan_installment,
          'balance' => 0,
          'interest' => $collection->interest,
          'date' => $collection->date,
          'receipt_no' => $collection->receipt_no,
          'due_interest' => $collection->due_interest,
          'unpaid_interest' => 0
        ]);
      }*/
/*      $startDate = Carbon::createFromFormat('Y-m-d', '2021-12-01');
      $endDate = Carbon::createFromFormat('Y-m-d', '2022-03-20');

      $numberOfMonths = $startDate->diffInMonths($endDate);

      echo "Number of months between the dates: {$numberOfMonths}";*/
//      $installments = DpsLoanCollection::orderBy('date','asc')->get();
//      $data = [];
//      foreach ($installments as $installment)
//      {
//        $interests = self::getInterest($installment->account_no,$installment->date,'');
//        $nested['interest'] = $installment->interest;
//        $nested['installment'] = $installment->loan_installment;
//        $nested['interests'] = $interests;
//        $data[] = $nested;
        /*$dpsLoanCollection = SpecialLoanCollection::create([
          'account_no' => $installment->account_no,
          'user_id' => $installment->user_id,
          'special_dps_loan_id' => $installment->special_dps_loan_id,
          'manager_id' => $installment->manager_id,
          'special_installment_id' => $installment->id,
          'loan_installment' => $installment->loan_installment,
          'balance' => 0,
          'interest' => $installment->interest,
          'due_interest' => $installment->due_interest,
          'unpaid_interest' => 0,
          'date' => $installment->date,
          'receipt_no' => $installment->receipt_no,
        ]);*/
       /* $interests = self::getSpecialInterest($installment->account_no,$installment->date,'');
        if ($installment->loan_installment > 0 || $installment->interest > 0) {
          $loan = SpecialDpsLoan::find($installment->special_dps_loan_id);
            foreach ($interests as $t) {
              if ($t['dueInstallment']>0)
              {
                $taken_loan = SpecialLoanTaken::find($t['taken_loan_id']);
                $dpsLoanInterests = SpecialLoanInterest::where('special_loan_taken_id', $t['taken_loan_id'])->get();
                $totalInstallments = $dpsLoanInterests->sum('installments');
                if ($dpsLoanInterests->count() == 0) {
                  $l_date = new Carbon($taken_loan->commencement);
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
                  $l_date = new Carbon($taken_loan->commencement);
                  $date_diff = $totalInstallments;
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
          }

          $installment->balance = $loan->remain_loan;
          $installment->unpaid_interest = $unpaid_interest;
          $installment->save();
        }*/

    //  }

     /* $installments = DpsLoanCollection::orderBy('date','asc')->get();
     // dd($collections);
      $data = [];
      foreach ($installments as $installment)
      {
        if ($installment->loan_installment > 0 || $installment->interest > 0) {
          $loan = DpsLoan::find($installment->dps_loan_id);

          if ($installment->interest > 0) {
            $t = TakenLoan::where('dps_loan_id',$loan->id)->first();
              $taken_loan = TakenLoan::find($t->id);
              $dpsLoanInterests = DpsLoanInterest::where('taken_loan_id', $t->id)->get();
              $totalInstallments = $dpsLoanInterests->sum('installments');
              if ($dpsLoanInterests->count() == 0) {
                $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);

                $dpsLoanInterest = DpsLoanInterest::create([
                  'taken_loan_id' => $t,
                  'account_no' => $taken_loan->account_no,
                  'installments' => 1,
                  'dps_installment_id' => $installment->id,
                  'interest' => $installment->interest,
                  'total' => $installment->interest,
                  'month' => $l_date->format('F'),
                  'year' => $l_date->format('Y'),
                  'date' => $installment->date
                ]);
              } else {
                $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                $date_diff = $totalInstallments;
                $l_date->addMonthsNoOverflow($date_diff);
                $dpsLoanInterest = DpsLoanInterest::create([
                  'taken_loan_id' => $t,
                  'account_no' => $taken_loan->account_no,
                  'installments' => 1,
                  'dps_installment_id' => $installment->id,
                  'interest' => $installment->interest,
                  'total' => $installment->interest,
                  'month' => $l_date->format('F'),
                  'year' => $l_date->format('Y'),
                  'date' => $installment->date
                ]);
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


            $loanTakens = TakenLoan::where('dps_loan_id', $loan->id)->where('remain', '>', 0)->orderBy('date', 'desc')->get();
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

          $installment->loan_balance = $loan->remain_loan;
          $installment->unpaid_interest = $unpaid_interest;
          $installment->save();

        }
      }

      echo 'success';*/
      /*$chunkSize = 1000;
      $page = 1;
      do {
        $collections = SpecialInstallment::whereNotNull('special_dps_loan_id')->orderBy('date','asc')->skip(($page - 1) * $chunkSize)
          ->take($chunkSize)
          ->get();

        if ($collections->isNotEmpty()) {
          ProcessDpsInstallments::dispatch($collections);
        }

        $page++;
      } while ($collections->count() === $chunkSize);*/

      /*$installments = SpecialDpsLoan::with('specialLoanTakens')->get();
      foreach ($installments as $installment)
      {
        $total = $installment->specialLoanTakens->count();
        if ($total==1)
        {
          SpecialLoanCollection::where('special_dps_loan_id',$installment->id)->delete();
        }
      }*/
//      $fdrs = DailyLoan::all();
//      $data=[];
//      foreach ($fdrs as $loan)
//      {
//       /* Transaction::create([
//          'account_no' => $loan->account_no,
//          'user_id' => $loan->user_id,
//          'amount' => $loan->loan_amount,
//          'type' => 'cashout',
//          'transactionable_id' => $loan->id,
//          'transactionable_type' => DailyLoan::class,
//          'date' => $loan->opening_date,
//          'manager_id' => $loan->manager_id
//        ]);*/
//        /*$expNum = explode('-', $fdr->account_no);
//        if (count($expNum) > 0) {
//          $fdr->account_no = 'FDR' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
//          $fdr->save();
//        }*/
//      }
//      echo '<pre>';
//      print_r($data);
//      echo '</pre>';
      //$loans = Dps::all();
//      $data = [];
//      foreach ($loans as $collection)
//      {
        /*$expNum = explode('-', $collection->account_no);
        if (count($expNum) > 0) {
          $collection->account_no = 'DPS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
          $collection->save();
        }*/

        /*Transaction::create([
          'account_no' => $loan->account_no,
          'user_id' => $loan->user_id,
          'amount' => $loan->loan_amount,
          'type' => 'cashout',
          'transactionable_id' => $loan->id,
          'transactionable_type' => TakenLoan::class,
          'date' => $loan->date,
          'manager_id' => $loan->manager_id
        ]);*/
        /*$collection->specialDpsLoan->loan_amount += $collection->loan_amount;
        $collection->specialDpsLoan->remain_loan += $collection->loan_amount;
        $collection->specialDpsLoan->save();*/
        /*$total = $account->takenLoans->sum('loan_amount');
        if ($account->loan_amount > $total){
          $loanData['account_no'] = $account->account_no;
          $loanData['loan_amount1'] = $account->loan_amount;
          $loanData['loan_amount2'] = $total;
          $data[] = $loanData;
        }*/
        /*$accountNo = preg_replace('/\s+/', '', $account->account_no);
        $expNum = explode('-', $accountNo);
        $account->account_no = 'DPS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
        $account->save();*/
        /*$loan = DpsLoan::where('account_no',$account->account_no)->first();
        if (!$loan)
        {
          $data[] = $account->account_no;
        }*/
     // }
      echo 'success';
//      echo '<pre>';
//      print_r($data);
//      echo '</pre>';
    }

  public static function getInterest($account, $date, $type)
  {
    $takenLoans = TakenLoan::where('account_no',$account)->where('remain','>','0')->orderBy('date','asc')->get();
    $interest = [];
    $totalInterest = 0;
    foreach ($takenLoans as $key => $takenLoan)
    {
      $due = Helpers::getDueInterest($takenLoan->id,$date);
      if ($due == 0){
        continue;
      }
      if ( $takenLoan->interest2> 0)
      {
        if($takenLoan->upto_amount <= $takenLoan->remain)
        {
          $amount1 = $takenLoan->upto_amount;
          $amount2 = $takenLoan->remain - $amount1;
          $amountOneInterest = ($amount1 * $takenLoan->interest2 * 1)/100;
          $amountTwoInterest = ($amount2 * $takenLoan->interest1 * 1)/100;
          $monthlyInterest = $amountOneInterest + $amountTwoInterest;
        }elseif( $takenLoan->remain < $takenLoan->upto_amount)
        {
          $monthlyInterest = ($takenLoan->remain * $takenLoan->interest2 * 1)/100;
        }
      }else{
        $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
      }
      $commencement = new Carbon($takenLoan->commencement);
      $interest[$key]['interest'] = ceil($monthlyInterest);
      $interest[$key]['dueInstallment'] = Helpers::getDueInterest($takenLoan->id,$date);
      $interest[$key]['commencement'] = $commencement->format('d/m/Y');
      $interest[$key]['taken_loan_id'] = $takenLoan->id;
      $totalInterest += ($interest[$key]['interest'] * $interest[$key]['dueInstallment']);
    }
    if ($type=='interest')
    {
      return  $totalInterest;
    }else{
      return $interest;
    }

  }
  public static function getSpecialInterest($account, $date, $type)
  {
    $takenLoans = SpecialLoanTaken::where('account_no',$account)->where('remain','>','0')->orderBy('date','asc')->get();
    $interest = [];
    $totalInterest = 0;
    foreach ($takenLoans as $key => $takenLoan)
    {
      if ( $takenLoan->interest2> 0)
      {
        if($takenLoan->upto_amount <= $takenLoan->remain)
        {
          $amount1 = $takenLoan->upto_amount;
          $amount2 = $takenLoan->remain - $amount1;
          $amountOneInterest = ($amount1 * $takenLoan->interest2 * 1)/100;
          $amountTwoInterest = ($amount2 * $takenLoan->interest1 * 1)/100;
          $monthlyInterest = $amountOneInterest + $amountTwoInterest;
        }elseif( $takenLoan->remain < $takenLoan->upto_amount)
        {
          $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
        }
      }else{
        $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
      }
      $commencement = new Carbon($takenLoan->commencement);
      $interest[$key]['interest'] = ceil($monthlyInterest);
      $interest[$key]['dueInstallment'] = Helpers::getSpecialDueInterest($takenLoan->id,$date);
      $interest[$key]['loanAmount'] = $takenLoan->loan_amount;
      $interest[$key]['loanRemain'] = $takenLoan->remain;
      $interest[$key]['commencement'] = $commencement->format('d/m/Y');
      $interest[$key]['taken_loan_id'] = $takenLoan->id;
      $totalInterest += ($interest[$key]['interest'] * $interest[$key]['dueInstallment']);
    }
    if ($type=='interest')
    {
      return  $totalInterest;
    }else{
      return $interest;
    }

  }
}
