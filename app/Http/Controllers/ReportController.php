<?php

namespace App\Http\Controllers;

use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DailySavingsComplete;
use App\Models\DpsComplete;
use App\Models\DpsInstallment;
use App\Models\FdrDeposit;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\SavingsCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsComplete;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cashbook()
    {
        return view('app.reports.cashbook');
    }
    public function dataCashbook(Request $request)
    {
        if (!empty($request->from) || !empty($request->to)) {
            $from = $request->from;
            $to = $request->to;
        }else{
            $from = date('y-m-d');
            $to = date('y-m-d');
        }
        $cashins = CashIn::with('cashinCategory')->whereBetween('date',[$from,$to]);
        $cashouts = Cashout::with('cashoutCategory')->whereBetween('date',[$from,$to]);

        $totalCashin = $cashins->sum('amount');
        $totalCashout = $cashouts->sum('amount');

        $groupedCashin = $cashins->whereNotNull('cashin_category_id')->get()->groupBy('cashin_category_id');
        $groupedCashout = $cashouts->whereNotNull('cashout_category_id')->get()->groupBy('cashout_category_id');

        $cashinSummary = [];
        foreach ($groupedCashin as $row) {
            foreach ($row as $line) {
                if (!isset($cashinSummary[$line->cashinCategory->name])) {
                    $cashinSummary[$line->cashinCategory->name] = [
                        'name'   => $line->cashinCategory->name,
                        'id'   => $line->cashinCategory->id,
                        'amount' => 0,
                    ];
                }
                $cashinSummary[$line->cashinCategory->name]['amount'] += $line->amount;
            }
        }

        $cashoutSummary = [];
        foreach ($groupedCashout as $row) {
            foreach ($row as $line) {
                if (!isset($cashoutSummary[$line->cashoutCategory->name])) {
                    $cashoutSummary[$line->cashoutCategory->name] = [
                        'name'   => $line->cashoutCategory->name,
                        'id'   => $line->cashoutCategory->id,
                        'amount' => 0,
                    ];
                }
                $cashoutSummary[$line->cashoutCategory->name]['amount'] += $line->amount;
            }
        }
        $data = array();
        $data['totalCashin'] = $totalCashin;
        $data['totalCashout'] = $totalCashout;
        $data['cashinSummary'] = $cashinSummary;
        $data['cashoutSummary'] = $cashoutSummary;
        return json_encode($data);
        //return view('app.reports.cashbook',compact('totalCashin','totalCashout','cashinSummary','cashoutSummary'));
    }

    public function reportAccountsDownload(Request $request)
    {

    }
  public function summaryReport(Request $request)
  {
    // Extract start and end dates from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // If not provided, use default behavior
    if (!$startDate || !$endDate) {
      $startDate = Carbon::now()->startOfYear();
      $endDate = Carbon::now()->endOfDay();
    }

    $dpsLoans = TakenLoan::whereBetween('date', [$startDate, $endDate])->get();
    $installments = DpsInstallment::whereBetween('date', [$startDate, $endDate])->get();
    $dpsCompletes = DpsComplete::whereBetween('date', [$startDate, $endDate])->get();

    $specialDpsLoans = SpecialLoanTaken::whereBetween('date', [$startDate, $endDate])->get();
    $specialDps = SpecialDps::whereBetween('opening_date', [$startDate, $endDate])->get();
    $specialInstallments = SpecialInstallment::whereBetween('date', [$startDate, $endDate])->get();
    $specialDpsCompletes = SpecialDpsComplete::whereBetween('date', [$startDate, $endDate])->get();

    $dailyLoans = DailyLoan::whereBetween('opening_date', [$startDate, $endDate])->get();
    $savingsCollections = SavingsCollection::whereBetween('date', [$startDate, $endDate])->get();
    $dailyLoanCollections = DailyLoanCollection::whereBetween('date', [$startDate, $endDate])->get();
    $dailySavingsCompletes = DailySavingsComplete::whereBetween('date', [$startDate, $endDate])->get();

    $fdrDeposits = FdrDeposit::whereBetween('date', [$startDate, $endDate])->get();
    $fdrWithdraws = FdrWithdraw::whereBetween('date', [$startDate, $endDate])->get();
    $fdrProfits = FdrProfit::whereBetween('date', [$startDate, $endDate])->get();

    if ($request->ajax()) {
      return view('app.reports.summary_ajax', compact(
        'dpsLoans',
        'dpsCompletes',
        'specialDpsCompletes',
        'dailySavingsCompletes',
        'installments',
        'dailyLoans',
        'dailyLoanCollections',
        'savingsCollections',
        'specialDpsLoans',
        'specialInstallments',
        'specialDps',
        'fdrDeposits',
        'fdrWithdraws',
        'fdrProfits',
        'startDate',
        'endDate'
        ))->render();
    }

    return view('app.reports.summary', compact(
      'dpsLoans',
      'dpsCompletes',
      'specialDpsCompletes',
      'dailySavingsCompletes',
      'installments',
      'dailyLoans',
      'dailyLoanCollections',
      'savingsCollections',
      'specialDpsLoans',
      'specialInstallments',
      'specialDps',
      'fdrDeposits',
      'fdrWithdraws',
      'fdrProfits',
      'startDate',
      'endDate'
    ));
  }
}
