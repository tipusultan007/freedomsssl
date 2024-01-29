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

//      $chunkSize = 5000;
//      $page = 1;
//      do {
//        $collections = DailyLoanCollection::skip(($page - 1) * $chunkSize)
//          ->take($chunkSize)
//          ->get();
//
//        if ($collections->isNotEmpty()) {
//          ProcessDailyLoanCollections::dispatch($collections);
//        }
//
//        $page++;
//      } while ($collections->count() === $chunkSize);
    }
}
