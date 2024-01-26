<?php

namespace App\Http\Controllers;

use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
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
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ResetController extends Controller
{
  public function dailySavings($id)
  {
    $dailySavings = DailySavings::with('savingsCollections')->find($id);

    if ($dailySavings) {
      $savingsCollectionIds = $dailySavings->savingsCollections->pluck('id');
      Transaction::where('transactionable_type', SavingsCollection::class)
        ->whereIn('transactionable_id', $savingsCollectionIds)
        ->delete();
      SavingsCollection::whereIn('id', $savingsCollectionIds)->delete();
    }
    $dailySavings->total = 0;
    $dailySavings->profit = 0;
    $dailySavings->deposit = 0;
    $dailySavings->withdraw = 0;
    $dailySavings->save();

    return response()->json(['message' => 'success']);
  }

  public function monthly($id)
  {
    $dailySavings = Dps::with('dpsInstallments', 'dpsCollections')->find($id);
    //DpsCollection::where('dps_id',3)->delete();
    if ($dailySavings) {
      $savingsCollections = $dailySavings->dpsInstallments;
      foreach ($savingsCollections as $collection) {
        if ($collection->dps_loan_id != "") {
          $total = 0;
          if ($collection->dps_amount != 0) {
            $total += intval($collection->dps_amount);
          }
          if ($collection->late_fee != "") {
            $total += intval($collection->late_fee);
          }
          if ($collection->other_fee != "") {
            $total += intval($collection->other_fee);
          }

          if ($collection->advance != "") {
            $total += intval($collection->advance);
          }
          if ($collection->advance_return != "") {
            $total -= intval($collection->advance_return);
          }
          if ($collection->grace != "") {
            $total -= intval($collection->grace);
          }
          $collection->total -= $total;
          $collection->save();

          $collection->dps_id = NULL;
          $collection->dps_installments = NULL;
          $collection->dps_amount = NULL;
          $collection->late_fee = NULL;
          $collection->other_fee = NULL;
          $collection->dps_balance = NULL;
          $collection->advance = NULL;
          $collection->advance_return = NULL;
          $collection->grace = NULL;
          $collection->save();
        } else {
          $collection->delete();
        }
      }
    }

    DpsCollection::where('dps_id', $dailySavings->id)->delete();
    $completes = DpsComplete::where('dps_id',$dailySavings->id)->get();
    foreach ($completes as $complete)
    {
      $complete->delete();
    }
    $dailySavings->balance = 0;
    $dailySavings->profit = 0;
    $dailySavings->total = 0;
    $dailySavings->withdraw = 0;
    $dailySavings->remain_profit = 0;
    $dailySavings->status = 'active';
    $dailySavings->save();

    return 'success';
  }

  public function special($id)
  {
    $dailySavings = SpecialDps::with('installments', 'dpsCollections')->find($id);
    //DpsCollection::where('dps_id',3)->delete();
    if ($dailySavings) {
      $savingsCollections = $dailySavings->installments;
      foreach ($savingsCollections as $collection) {
        if ($collection->special_dps_loan_id != "") {
          $total = 0;
          if ($collection->dps_amount != 0) {
            $total += intval($collection->dps_amount);
          }
          if ($collection->late_fee != "") {
            $total += intval($collection->late_fee);
          }
          if ($collection->other_fee != "") {
            $total += intval($collection->other_fee);
          }

          if ($collection->advance != "") {
            $total += intval($collection->advance);
          }
          if ($collection->advance_return != "") {
            $total -= intval($collection->advance_return);
          }
          if ($collection->grace != "") {
            $total -= intval($collection->grace);
          }
          $collection->total -= $total;
          $collection->save();

          $collection->special_dps_id = NULL;
          $collection->dps_installments = NULL;
          $collection->dps_amount = NULL;
          $collection->late_fee = NULL;
          $collection->other_fee = NULL;
          $collection->dps_balance = NULL;
          $collection->advance = NULL;
          $collection->advance_return = NULL;
          $collection->grace = NULL;
          $collection->save();
        } else {
          $collection->delete();
        }
      }
    }

    SpecialDpsCollection::where('special_dps_id', $dailySavings->id)->delete();
    $completes = SpecialDpsComplete::where('special_dps_id',$dailySavings->id)->get();
    foreach ($completes as $complete)
    {
      $complete->delete();
    }
    $dailySavings->balance = 0;
    $dailySavings->profit = 0;
    $dailySavings->total = 0;
    $dailySavings->withdraw = 0;
    $dailySavings->remain_profit = 0;
    $dailySavings->status = 'active';
    $dailySavings->save();

    return 'success';
  }

  public function dailyLoan($id)
  {
    $dailyLoan = DailyLoan::with('dailyLoanCollections')->find($id);
    if ($dailyLoan) {
      $savingsCollectionIds = $dailyLoan->dailyLoanCollections->pluck('id');
      Transaction::where('transactionable_type', DailyLoanCollection::class)
        ->whereIn('transactionable_id', $savingsCollectionIds)
        ->delete();
      DailyLoanCollection::whereIn('id', $savingsCollectionIds)->delete();
    }

    $dailyLoan->balance = $dailyLoan->total;
    $dailyLoan->paid_interest = 0;
    $dailyLoan->save();
  }

  public function dpsLoan($id)
  {
    $loan = DpsLoan::with('takenLoans', 'dpsInstallments')->find($id);
    if ($loan) {
      $takenloans = $loan->takenLoans;
      $installments = $loan->dpsInstallments;
      foreach ($takenloans as $takenloan) {
        $takenloan->remain = $takenloan->loan_amount;
        $takenloan->save();
        DpsLoanInterest::where('taken_loan_id', $takenloan->id)->delete();
        LoanPayment::where('taken_loan_id', $takenloan->id)->delete();
      }

      foreach ($installments as $installment) {
        if ($installment->dps_id != "") {
          $total = 0;
          if ($installment->loan_installment > 0) {
            $total += $installment->loan_installment;
            $installment->loan_installment = null;
          }
          if ($installment->interest > 0) {
            $total += $installment->interest;
            $installment->interest = null;
          }
          if ($installment->due_interest > 0) {
            $total += $installment->due_interest;
            $installment->due_interest = null;
          }
          $installment->total -= $total;
          $installment->dps_loan_id = null;
          $installment->loan_installments = null;
          $installment->save();

        } else {
          $installment->delete();
        }
      }
      DpsLoanCollection::where('dps_loan_id', $loan->id)->delete();
    }

    $loan->remain_loan = $loan->loan_amount;
    $loan->total_paid = 0;
    $loan->paid_interest = 0;
    $loan->dueInterest = 0;
    $loan->grace = 0;
    $loan->dueInstallment = 0;
    $loan->status = 'active';
    $loan->save();
  }

  public function specialLoan($id)
  {
    $loan = SpecialDpsLoan::with('specialLoanTakens', 'specialDpsInstallments')->find($id);
    if ($loan) {
      $takenloans = $loan->specialLoanTakens;
      $installments = $loan->specialDpsInstallments;
      foreach ($takenloans as $takenloan) {
        $takenloan->remain = $takenloan->loan_amount;
        $takenloan->save();
        SpecialLoanInterest::where('special_loan_taken_id', $takenloan->id)->delete();
        SpecialLoanPayment::where('special_loan_taken_id', $takenloan->id)->delete();
      }

      foreach ($installments as $installment) {
        if ($installment->special_dps_id != "") {
          $total = 0;
          if ($installment->loan_installment > 0) {
            $total += $installment->loan_installment;
            $installment->loan_installment = null;
          }
          if ($installment->interest > 0) {
            $total += $installment->interest;
            $installment->interest = null;
          }
          if ($installment->due_interest > 0) {
            $total += $installment->due_interest;
            $installment->due_interest = null;
          }
          $installment->total -= $total;
          $installment->special_dps_loan_id = null;
          $installment->loan_installments = null;
          $installment->save();

        } else {
          $installment->delete();
        }
      }
      SpecialLoanCollection::where('special_dps_loan_id', $loan->id)->delete();
    }

    $loan->remain_loan = $loan->loan_amount;
    $loan->total_paid = 0;
    $loan->paid_interest = 0;
    $loan->dueInterest = 0;
    $loan->grace = 0;
    $loan->status = 'active';
    $loan->save();

    return response()->json(['status' => true]);
  }


  public function fdr($id)
  {
    $fdr = Fdr::with('fdrWithdraws', 'fdrDeposits', 'fdrProfits')->find($id);
    $fdrProfitsId = $fdr->fdrProfits->pluck('id');
    Transaction::where('transactionable_type', FdrProfit::class)
      ->whereIn('transactionable_id', $fdrProfitsId)
      ->delete();
    ProfitCollection::whereIn('fdr_profit_id', $fdrProfitsId)->delete();
    FdrProfit::whereIn('id', $fdrProfitsId)->delete();
    FdrWithdraw::where('fdr_id', $id)->delete();
    foreach ($fdr->fdrDeposits as $deposit) {
      $deposit->balance = $deposit->amount;
      $deposit->profit = 0;
      $deposit->save();
    }
    $fdr->balance = $fdr->amount;
    $fdr->profit = 0;
    $fdr->status = 'active';
    $fdr->save();
    return response()->json(['status' => true]);
  }
}
