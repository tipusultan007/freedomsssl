<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Models\DpsInstallment;
use App\Models\DpsLoan;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\FdrPackage;
use App\Models\FdrProfit;
use App\Models\Notification;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Notifications\FdrProfitNotification;
use App\Notifications\LoanInterestNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateNotification extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'notifications:create';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  /*public function handle()
  {
    Notification::truncate();
    $loans = DpsLoan::with('user')->where('remain_loan', '>', 0)->get();
    foreach ($loans as $loan) {
      $interestData = self::getInterest($loan->account_no, date('Y-m-d'));
      $last_trx_date = DpsInstallment::where('account_no', $loan->account_no)->whereNotNull('dps_loan_id')->orderBy('date','desc')->first();
      if ($interestData['total_interest'] > 0) {
        $loan->notify(new LoanInterestNotification($interestData,$loan, $last_trx_date));
      }
    }

    $allFdr = Fdr::where('balance', '>', 0)->get();
    foreach ($allFdr as $fdr) {
      $profit = self::getProfit($fdr->id, date('Y-m-d'));
      $last_trx_date = FdrProfit::where('account_no', $loan->account_no)->orderBy('date','desc')->first();
      if ($profit['total_profit'] > 0) {
        $fdr->notify(new FdrProfitNotification($profit,$fdr,$last_trx_date));
      }
    }
    $this->info('Notifications created successfully.');
  }*/
  public function handle()
  {
    Notification::truncate();

    // Process DpsLoan records
    DpsLoan::with('user')->where('remain_loan', '>', 0)->chunk(200, function ($loans) {
      foreach ($loans as $loan) {
        $interestData = self::getInterest($loan->account_no, date('Y-m-d'));
        $last_trx_date = DpsInstallment::where('account_no', $loan->account_no)->whereNotNull('dps_loan_id')->orderBy('date', 'desc')->first();

        if ($interestData['total_interest'] > 0) {
          $loan->notify(new LoanInterestNotification($interestData, $loan, $last_trx_date));
        }
      }
    });

    SpecialDpsLoan::with('user')->where('remain_loan', '>', 0)->chunk(100, function ($loans) {
      foreach ($loans as $loan) {
        $interestData = self::getSpecialInterest($loan->account_no, date('Y-m-d'));
        $last_trx_date = SpecialInstallment::where('account_no', $loan->account_no)->whereNotNull('special_dps_loan_id')->orderBy('date', 'desc')->first();

        if ($interestData['total_interest'] > 0) {
          $loan->notify(new LoanInterestNotification($interestData, $loan, $last_trx_date));
        }
      }
    });

    // Process Fdr records
    Fdr::where('balance', '>', 0)->chunk(200, function ($allFdr) {
      foreach ($allFdr as $fdr) {
        $profit = self::getProfit($fdr->id, date('Y-m-d'));
        $last_trx_date = FdrProfit::where('account_no', $fdr->account_no)->orderBy('date', 'desc')->first();

        if ($profit['total_profit'] > 0) {
          $fdr->notify(new FdrProfitNotification($profit, $fdr, $last_trx_date));
        }
      }
    });

    $this->info('Notifications created successfully.');
  }

  public static function getInterest($account, $date)
  {
    $takenLoans = TakenLoan::where('account_no', $account)->where('remain', '>', '0')->orderBy('date', 'asc')->get();
    $interest = [];
    $interestData = [];
    $totalInterest = 0;
    foreach ($takenLoans as $key => $takenLoan) {
      if ($takenLoan->interest2 > 0) {
        if ($takenLoan->upto_amount <= $takenLoan->remain) {
          $amount1 = $takenLoan->upto_amount;
          $amount2 = $takenLoan->remain - $amount1;
          $amountOneInterest = ($amount1 * $takenLoan->interest2 * 1) / 100;
          $amountTwoInterest = ($amount2 * $takenLoan->interest1 * 1) / 100;
          $monthlyInterest = $amountOneInterest + $amountTwoInterest;
        } elseif ($takenLoan->remain < $takenLoan->upto_amount) {
          $monthlyInterest = ($takenLoan->remain * $takenLoan->interest2 * 1) / 100;
        }
      } else {
        $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1) / 100;
      }
      $commencement = new Carbon($takenLoan->commencement);
      $interest[$key]['interest'] = ceil($monthlyInterest);
      $interest[$key]['dueInstallment'] = Helpers::getDueInterest($takenLoan->id, $date);
      $interest[$key]['loanAmount'] = $takenLoan->loan_amount;
      $interest[$key]['loanRemain'] = $takenLoan->remain;
      $interest[$key]['commencement'] = $commencement->format('d/m/Y');
      $interest[$key]['taken_loan_id'] = $takenLoan->id;
      $totalInterest += ($interest[$key]['interest'] * $interest[$key]['dueInstallment']);
    }
    $interestData['account_no'] = $account;
    $interestData['total_interest'] = $totalInterest;
    $interestData['interest_details'] = $interest;

    return $interestData;
  }

  public static function getSpecialInterest($account, $date)
  {
    $takenLoans = SpecialLoanTaken::where('account_no',$account)->where('remain','>','0')->orderBy('date','asc')->get();
    $interest = [];
    $totalInterest = 0;
    $interestData = [];
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
    $interestData['account_no'] = $account;
    $interestData['total_interest'] = $totalInterest;
    $interestData['interest_details'] = $interest;

    return $interestData;
  }
  public static function getProfit($fdrId, $date)
  {
    $fdrDeposits = FdrDeposit::where('fdr_id', $fdrId)->where('balance', '>', '0')->orderBy('date', 'asc')->get();
    $fdr = Fdr::find($fdrId);
    $profit = [];
    $totalProfit = 0;
    $profitRate = 0;
    $profitData = [];
    foreach ($fdrDeposits as $key => $deposit) {
      $due = Helpers::getDueProfit($deposit->id, $date);
      $package = FdrPackage::find($deposit->fdr_package_id);
      if ($due < 12) {
        $profitRate = ($package->amount * $deposit->balance) / 100000;
      } elseif ($due >= 12 && $due < 24) {
        $profitRate = ($package->one * $deposit->balance) / 100000;

      } elseif ($due >= 24 && $due < 36) {
        $profitRate = ($package->two * $deposit->balance) / 100000;

      } elseif ($due >= 36 && $due < 48) {
        $profitRate = ($package->three * $deposit->balance) / 100000;

      } elseif ($due >= 48 && $due < 60) {
        $profitRate = ($package->four * $deposit->balance) / 100000;

      } elseif ($due >= 60 && $due < 66) {
        $profitRate = ($package->five * $deposit->balance) / 100000;
      } elseif ($due >= 66 && $due < 72) {
        $profitRate = ($package->five_half * $deposit->balance) / 100000;
      } elseif ($due >= 72) {
        $profitRate = ($package->six * $deposit->balance) / 100000;
      }

      $commencement = new Carbon($deposit->commencement);
      $profit[$key]['profit'] = ceil($profitRate);
      $profit[$key]['dueInstallment'] = $due;
      $profit[$key]['fdr_deposit'] = $deposit->balance;
      $profit[$key]['commencement'] = $commencement->format('d-m-Y');
      $profit[$key]['fdr_deposit_id'] = $deposit->id;
      $totalProfit += ceil($profitRate) * $due;

    }
    $profitData['account_no'] = $fdr->account_no;
    $profitData['total_profit'] = $totalProfit;
    $profitData['profit_details'] = $profit;

    return $profitData;
  }
}
