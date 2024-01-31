<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDailyLoanCollections;
use App\Jobs\ProcessDpsInstallments;
use App\Jobs\ProcessSavingsCollections;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\Dps;
use App\Models\DpsComplete;
use App\Models\DpsInstallment;
use App\Models\DpsLoan;
use App\Models\DpsLoanCollection;
use App\Models\FdrComplete;
use App\Models\FdrDeposit;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\ProfitCollection;
use App\Models\SavingsCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsComplete;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function dpsInstallment()
    {
      $data = [];
      /*$uniqueInstallments = DpsInstallment::groupBy(['account_no','date'])
        ->select('trx_id', \DB::raw('MAX(id) as max_id'),\DB::raw('COUNT(id) as installments'))
        ->get();*/
      $installments = DpsInstallment::groupBy('account_no', 'date')
        ->select('account_no', 'date', \DB::raw('MAX(id) as max_id'), \DB::raw('COUNT(id) as installments'))
        ->get();
      foreach ($installments as $installment) {
        $ins = DpsInstallment::find($installment->max_id);
        if ($ins->dps_amount>0) {
          $ins->dps_installments = $installment->installments;
        }else{
          $ins->loan_installments = $installment->installments;
        }
        $ins->save();
      }


      /*$uniqueInstallments = DpsInstallment::where('due','>',0)->groupBy('trx_id')
        ->select('trx_id', \DB::raw('MIN(id) as id'))
        ->get();

      foreach ($uniqueInstallments as $installment) {
        DpsInstallment::where('trx_id', $installment->trx_id)
          ->where('id', '!=', $installment->id)
          ->update(['due' => null]);
      }*/

      /*$chunkSize = 100;
      $page = 1;
      do {
        $collections = DpsInstallment::skip(($page - 1) * $chunkSize)
          ->take($chunkSize)
          ->get();

        if ($collections->isNotEmpty()) {
          ProcessDpsInstallments::dispatch($collections);
        }

        $page++;
      } while ($collections->count() === $chunkSize);*/
    }
}
