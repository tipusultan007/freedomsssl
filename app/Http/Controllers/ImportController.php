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
use App\Models\Nominees;
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
      $nominees = Nominees::all();
      foreach ($nominees as $nominee) {
        $expNum = explode('-', $nominee->account_no);
        if (count($expNum) == 2) {
          switch ($expNum[0]){
            case 'DS':
              $nominee->account_no = 'DS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
              $nominee->save();
              break;
            case 'DPS':
              $nominee->account_no = 'DPS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
              $nominee->save();
              break;
            case 'FDR':
              $nominee->account_no = 'FDR' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
              $nominee->save();
              break;
            default:
          }

        }
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
