<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DpsCollection;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Models\SavingsCollection;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Crm extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $dashboard = [];
    $totalCustomers = User::count();

    $totalDailyLoan = DailyLoan::sum('loan_amount');
    $totalDpsLoan = TakenLoan::sum('loan_amount');
    $totalSpecialLoan = SpecialLoanTaken::sum('loan_amount');

    $dailyLoanCollection = DailyLoanCollection::sum('loan_installment');

    $dailyLoanSummary = DailyLoan::where('balance', '<=', 0)
      ->selectRaw('SUM(loan_amount) as principalLoan, SUM(total) as principalWithInterestLoan')
      ->first();

    $principalLoan = $dailyLoanSummary->principalLoan ?? 0;
    $principalWithInterestLoan = $dailyLoanSummary->principalWithInterestLoan ?? 0;
    $dailyInterest = $principalWithInterestLoan - $principalLoan;

    $dpsLoanCollection = DpsLoanCollection::sum('loan_installment');
    $specialLoanCollection = SpecialLoanCollection::sum('loan_installment');

    $dpsCollectionSummary = DpsInstallment::selectRaw('SUM(interest) as interest, SUM(grace) as grace')->first();
    $specialCollectionSummary = SpecialInstallment::selectRaw('SUM(interest) as interest, SUM(grace) as grace')->first();

    $dpsLoanInterest = $dpsCollectionSummary->interest - $dpsCollectionSummary->grace;
    $specialLoanInterest = $specialCollectionSummary->interest - $specialCollectionSummary->grace;

    $dashboard['total_customers'] = $totalCustomers;
    $dashboard['total_loans'] = $totalDailyLoan + $totalDpsLoan + $totalSpecialLoan;
    $dashboard['total_loans_return'] = $dailyLoanCollection + $dpsLoanCollection + $specialLoanCollection - $dailyInterest;
    $dashboard['total_loans_interest'] = $dpsLoanInterest + $specialLoanInterest + $dailyInterest;
    return view('content.dashboard.ecom',compact('dashboard'));
  }

  public function getSavingsChartData()
  {
    $currentYear = Carbon::now()->year;

    // Fetch data for all months of the current year
    $data = SavingsCollection::whereYear('date', $currentYear)
      ->groupBy(['type', \DB::raw('MONTH(date)')])
      ->orderBy('date', 'asc')
      ->selectRaw('MONTH(date) as month, type, SUM(amount) as total')
      ->get();

    // Create an array with all months of the year
    $allMonths = range(1, 12);

    // Initialize datasets array
    $datasets = [];

    // Organize data into datasets with empty values for months without data
    foreach ($allMonths as $month) {
      foreach (['deposit', 'withdraw'] as $type) {
        $matchingEntry = $data->first(function ($entry) use ($month, $type) {
          return $entry->month == $month && $entry->type == $type;
        });

        // If data exists for the month and type, use the total; otherwise, use 0
        $total = $matchingEntry ? $matchingEntry->total : 0;

        if (!isset($datasets[$type])) {
          $datasets[$type] = [
            'name' => ucfirst($type) . 's',
            'data' => [],
          ];
        }

        $datasets[$type]['data'][$month] = $total;
      }
    }

    return response()->json(['labels' => $allMonths, 'datasets' => array_values($datasets)]);
  }

  public function getDpsChartData()
  {
    $currentYear = Carbon::now()->year;
    $data = DpsCollection::whereYear('date', $currentYear)
      ->groupBy(DB::raw('MONTH(date)'))
      ->selectRaw('MONTH(date) as month, SUM(dps_amount) as total')
      ->get();

    return response()->json(['labels' => $data->pluck('month'), 'datasets' => [['name' => 'DPS Collections', 'data' => $data->pluck('total')]]]);
  }

  public function getDailyLoanChartData()
  {
    $currentYear = Carbon::now()->year;
    $data = DailyLoanCollection::whereYear('date', $currentYear)
      ->groupBy(DB::raw('MONTH(date)'))
      ->selectRaw('MONTH(date) as month, SUM(loan_installment) as total')
      ->get();

    return response()->json(['labels' => $data->pluck('month'), 'datasets' => [['name' => 'Daily Loan Collections', 'data' => $data->pluck('total')]]]);
  }
}
