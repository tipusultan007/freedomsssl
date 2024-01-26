<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Manager;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('app.transactions.index');
  }

  public function cashIn()
  {
    return view('app.transactions.cashin');
  }
  public function cashOut()
  {
    return view('app.transactions.cashout');
  }
  public function cashReport(Request $request)
  {
    // Get start and end dates from the request, default to current date if not provided
    $startDate = $request->input('start_date', now()->toDateString());
    $endDate = $request->input('end_date', now()->toDateString());

    // Query for cash in transactions with date filtering
    $cashinSums = $this->getFilteredSums('cashin', $startDate, $endDate);

    // Rename cash in transaction types
    $renamedCashinSums = $cashinSums->map(function ($sum) {
      $sum->renamed_type = TransactionController::cashinTransactionType($sum->transactionable_type);
      return $sum;
    });

    // Query for cash out transactions with date filtering
    $cashoutSums = $this->getFilteredSums('cashout', $startDate, $endDate);

    // Rename cash out transaction types
    $renamedCashoutSums = $cashoutSums->map(function ($sum) {
      $sum->renamed_type = TransactionController::cashoutTransactionType($sum->transactionable_type);
      return $sum;
    });

    $summaryIncomeData = Income::whereBetween('date',[$startDate,$endDate])
      ->select('income_category_id', DB::raw('SUM(amount) as total_amount'))
      ->groupBy('income_category_id')
      ->with('incomeCategory') // Eager load the category relationship
      ->get()
      ->map(function($item) {
        return [
          'category_name' => $item->incomeCategory->name??'',
          'total_amount' => $item->total_amount,
        ];
      });

    $summaryExpenseData = Expense::whereBetween('date',[$startDate,$endDate])
      ->select('expense_category_id', DB::raw('SUM(amount) as total_amount'))
      ->groupBy('expense_category_id')
      ->with('expenseCategory') // Eager load the category relationship
      ->get()
      ->map(function($item) {
        return [
          'category_name' => $item->expenseCategory->name??'',
          'total_amount' => $item->total_amount,
        ];
      });

    $totalIncome = Income::whereBetween('date',[[$startDate,$endDate]])->sum('amount');
    $totalExpense = Expense::whereBetween('date',[[$startDate,$endDate]])->sum('amount');

    return view('app.transactions.report', compact('renamedCashinSums', 'renamedCashoutSums','startDate','endDate',
      'summaryIncomeData','summaryExpenseData','totalIncome','totalExpense'));
  }

  private function getFilteredSums($type, $startDate, $endDate)
  {
    $query = DB::table('transactions')
      ->where('type', $type);

    if ($startDate) {
      $query->where('date', '>=', $startDate);
    }

    if ($endDate) {
      $query->where('date', '<=', $endDate);
    }

    return $query
      ->select(
        DB::raw('SUM(amount) as sum_amount'),
        'transactionable_type'
      )
      ->groupBy('transactionable_type')
      ->get();
  }
/*  public function cashReport(Request $request)
  {
    $cashinSums = DB::table('transactions')
      ->where('type', 'cashin')
      ->select(
        DB::raw('SUM(amount) as sum_amount'),
        'transactionable_type'
      )
      ->groupBy('transactionable_type')
      ->get();

    $renamedCashinSums = $cashinSums->map(function ($sum) {
      $sum->renamed_type = TransactionController::cashinTransactionType($sum->transactionable_type);
      return $sum;
    });

    $cashoutSums = DB::table('transactions')
      ->where('type', 'cashout')
      ->select(
        DB::raw('SUM(amount) as sum_amount'),
        'transactionable_type'
      )
      ->groupBy('transactionable_type')
      ->get();

    $renamedCashoutSums = $cashoutSums->map(function ($sum) {
      $sum->renamed_type = TransactionController::cashoutTransactionType($sum->transactionable_type);
      return $sum;
    });

    return view('app.transactions.report', compact('renamedCashinSums', 'renamedCashoutSums'));
  }
*/
  public static function cashinTransactionType($originalType)
  {
    $typeMap = [
      'App\\Models\\FdrDeposit' => 'স্থায়ী সঞ্চয় (FDR) জমা',
      'App\\Models\\SavingsCollection' => 'দৈনিক সঞ্চয় আদায়',
      'App\\Models\\DailyLoanCollection' => 'দৈনিক ঋণ আদায়',
      'App\\Models\\DpsInstallment' => 'মাসিক (DPS) সঞ্চয়/ঋণ আদায়',
      'App\\Models\\SpecialInstallment' => 'বিশেষ (Special) সঞ্চয়/ঋণ আদায়',
      'App\\Models\\DailySavingsComplete' => 'দৈনিক সঞ্চয় উত্তোলন (নিস্পত্তি)',
      'App\\Models\\DpsComplete' => 'মাসিক সঞ্চয় (DPS) উত্তোলন (নিস্পত্তি)',
      'App\\Models\\SpecialDpsComplete' => 'বিশেষ সঞ্চয় (Special) উত্তোলন (নিস্পত্তি)',
      'App\\Models\\FdrComplete' => 'স্থায়ী সঞ্চয় (FDR) উত্তোলন (নিস্পত্তি)',
    ];

    return $typeMap[$originalType] ?? $originalType;
  }
  public static function cashoutTransactionType($originalType)
  {
    $typeMap = [
      'App\\Models\\SavingsCollection' => 'দৈনিক সঞ্চয় উত্তোলন',
      'App\\Models\\FdrWithdraw' => 'স্থায়ী সঞ্চয় (FDR) উত্তোলন',
      'App\\Models\\DailyLoan' => 'দৈনিক ঋণ প্রদান',
      'App\\Models\\TakenLoan' => 'মাসিক (DPS) ঋণ প্রদান',
      'App\\Models\\SpecialLoanTaken' => 'বিশেষ (Special) ঋণ প্রদান',
      'App\\Models\\FdrProfit' => 'FDR মুনাফা উত্তোলন',
      'App\\Models\\DailySavingsComplete' => 'দৈনিক সঞ্চয় উত্তোলন (নিস্পত্তি)',
      'App\\Models\\DpsComplete' => 'মাসিক সঞ্চয় (DPS) উত্তোলন',
      'App\\Models\\SpecialDpsComplete' => 'বিশেষ সঞ্চয় (Special) উত্তোলন (নিস্পত্তি)',
      'App\\Models\\FdrComplete' => 'স্থায়ী সঞ্চয় (FDR) উত্তোলন (নিস্পত্তি)',
    ];

    return $typeMap[$originalType] ?? $originalType;
  }

  public function managerReport(Request $request)
  {
    $startDate = $request->input('start_date', now()->format('Y-m-d'));
    $endDate = $request->input('end_date', now()->format('Y-m-d'));

    $transactionSummary = DB::table('transactions')
      ->select(
        'manager_id',
        DB::raw('SUM(CASE WHEN type = "cashin" THEN amount ELSE 0 END) as total_cashin'),
        DB::raw('SUM(CASE WHEN type = "cashout" THEN amount ELSE 0 END) as total_cashout')
      )
      ->whereBetween('date', [$startDate, $endDate])
      ->groupBy('manager_id')
      ->get();

    $managers = Manager::all(); // Assuming you have a Manager model
    $reportData = [];
    $totalIncomeData = 0;
    $totalExpenseData = 0;
    foreach ($managers as $manager) {
      $totalIncome = Income::whereBetween('date', [$startDate, $endDate])->where('manager_id', $manager->id)->sum('amount');
      $totalExpense = Expense::whereBetween('date', [$startDate, $endDate])->where('manager_id', $manager->id)->sum('amount');
      $totalProfit = $totalIncome - $totalExpense;
      $totalIncomeData += $totalIncome;
      $totalExpenseData += $totalExpense;

      $nested['totalIncome'] =  $totalIncome;
      $nested['totalExpense'] =  $totalExpense;
      $nested['totalProfit'] =  $totalProfit;
      $reportData[$manager->id] = $nested;
    }
    return view('app.transactions.manager_report', compact('reportData','transactionSummary', 'managers','startDate','endDate','totalIncomeData','totalExpenseData'));
  }

  private function getFilteredTransactions($startDate, $endDate)
  {
    return DB::table('transactions')
      ->whereBetween('date', [$startDate, $endDate])
      ->get();
  }

  public function transactionByManager()
  {
    return view('app.transactions.manager');
  }

  public function dataManagerTransaction(Request $request)
  {
    $columns = array(
      0 => 'date',
      1 => 'transactionable_type',
      2 => 'account_no',
    );

    $query = Transaction::query();
    $query->where('manager_id',Auth::id());
    // Apply filters
    if ($request->filled('date_filter')) {
      $query->where('date', $request->input('date_filter'));
    }

    if ($request->filled('account_no_filter')) {
      $query->where('account_no', $request->input('account_no_filter'));
    }

    if ($request->filled('transactionable_type_filter')) {
      $query->where('transactionable_type', $request->input('transactionable_type_filter'));
    }

    $totalData = $query->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $queryTransaction = Transaction::with('user')
        ->where('manager_id',Auth::id())
        ->whereHasMorph('transactionable', [
          'App\Models\SavingsCollection',
          'App\Models\DailyLoanCollection',
          'App\Models\DpsInstallment',
          'App\Models\SpecialInstallment',
          'App\Models\FdrDeposit',
          'App\Models\TakenLoan',
          'App\Models\SpecialLoanTaken',
          'App\Models\DailyLoan',
          'App\Models\FdrWithdraw',
          'App\Models\FdrProfit',
          'App\Models\DailySavingsComplete',
          'App\Models\DpsComplete',
          'App\Models\SpecialDpsComplete',
          'App\Models\FdrComplete',
        ]);
      // Apply filters
      if ($request->filled('date_filter')) {
        $queryTransaction->where('date', $request->input('date_filter'));
      }

      if ($request->filled('account_no_filter')) {
        $queryTransaction->where('account_no', $request->input('account_no_filter'));
      }

      if ($request->filled('transactionable_type_filter')) {
        $queryTransaction->where('transactionable_type', $request->input('transactionable_type_filter'));
      }
      $posts = $queryTransaction->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Transaction::with('user')
        ->where('manager_id',Auth::id())
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Transaction::with('user')
        ->where('manager_id',Auth::id())
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $transaction) {
        if ($transaction->type == 'cashin') {
          $nestedData['amount'] = "<span class='text-success'>{$transaction->amount}</span>";
          $nestedData['transactionable_type'] = "<span class='text-success'>{$transaction->transactionable_display_name}</span>";
        }else{
          $nestedData['amount'] = "<span class='text-danger'>{$transaction->amount}</span>";
          $nestedData['transactionable_type'] = "<span class='text-danger'>{$transaction->transactionable_display_name}</span>";
        }

        $nestedData['account_no'] = $transaction->account_no;
        $nestedData['user_id'] = $transaction->user ? $transaction->user->name : null;
        $nestedData['type'] = $transaction->transaction_type;
        $nestedData['date'] = date('d/m/Y', strtotime($transaction->date));
        //$nestedData['amount'] = $transaction->amount;
        //$nestedData['transactionable_type'] = $transaction->transactionable_display_name;

        $data[] = $nestedData;


      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }
  public function dataCashin(Request $request)
  {
    $columns = array(
      0 => 'date',
      1 => 'transactionable_type',
      2 => 'account_no',
    );

    $query = Transaction::query();
    $query->where('type', 'cashin');
    // Apply filters
    if ($request->filled('date_filter')) {
      $query->where('date', $request->input('date_filter'));
    }

    if ($request->filled('account_no_filter')) {
      $query->where('account_no', $request->input('account_no_filter'));
    }

    if ($request->filled('transactionable_type_filter')) {
      $query->where('transactionable_type', $request->input('transactionable_type_filter'));
    }

    $totalData = $query->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $queryTransaction = Transaction::with('user', 'manager')
        ->whereHasMorph('transactionable', ['App\Models\SavingsCollection',
          'App\Models\DailyLoanCollection',
          'App\Models\DpsInstallment',
          'App\Models\SpecialInstallment',
          'App\Models\FdrDeposit',
          'App\Models\DailySavingsComplete',
          'App\Models\DpsComplete',
          'App\Models\SpecialDpsComplete',
          'App\Models\FdrComplete',
        ])
        ->where('type', 'cashin');
      // Apply filters
      if ($request->filled('date_filter')) {
        $queryTransaction->where('date', $request->input('date_filter'));
      }

      if ($request->filled('account_no_filter')) {
        $queryTransaction->where('account_no', $request->input('account_no_filter'));
      }

      if ($request->filled('transactionable_type_filter')) {
        $queryTransaction->where('transactionable_type', $request->input('transactionable_type_filter'));
      }
      $posts = $queryTransaction->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Transaction::with('user', 'manager')
        ->where('type', 'cashin')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Transaction::with('user', 'manager')
        ->where('type', 'cashin')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $transaction) {
        $nestedData['account_no'] = $transaction->account_no;
        $nestedData['user_id'] = $transaction->user ? $transaction->user->name : null;
        $nestedData['manager'] = $transaction->manager ? $transaction->manager->name : null;
        $nestedData['type'] = $transaction->transaction_type;
        $nestedData['date'] = date('d/m/Y', strtotime($transaction->date));
        $nestedData['amount'] = $transaction->amount;
        $nestedData['transactionable_type'] = $transaction->transactionable_display_name;

        $data[] = $nestedData;


      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }

  public function dataCashout(Request $request)
  {
    $columns = array(
      0 => 'date',
      1 => 'transactionable_type',
      2 => 'account_no',
    );

    $query = Transaction::query();
    $query->where('type', 'cashout');
    // Apply filters
    if ($request->filled('date_filter')) {
      $query->where('date', $request->input('date_filter'));
    }

    if ($request->filled('account_no_filter')) {
      $query->where('account_no', $request->input('account_no_filter'));
    }

    if ($request->filled('transactionable_type_filter')) {
      $query->where('transactionable_type', $request->input('transactionable_type_filter'));
    }

    $totalData = $query->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $queryTransaction = Transaction::with('user', 'manager')
        ->whereHasMorph('transactionable', [
          'App\Models\SavingsCollection',
          'App\Models\TakenLoan',
          'App\Models\SpecialLoanTaken',
          'App\Models\DailyLoan',
          'App\Models\FdrWithdraw',
          'App\Models\FdrProfit',
          'App\Models\DailySavingsComplete',
          'App\Models\DpsComplete',
          'App\Models\SpecialDpsComplete',
          'App\Models\FdrComplete',
        ])
        ->where('type', 'cashout');
      // Apply filters
      if ($request->filled('date_filter')) {
        $queryTransaction->where('date', $request->input('date_filter'));
      }

      if ($request->filled('account_no_filter')) {
        $queryTransaction->where('account_no', $request->input('account_no_filter'));
      }

      if ($request->filled('transactionable_type_filter')) {
        $queryTransaction->where('transactionable_type', $request->input('transactionable_type_filter'));
      }
      $posts = $queryTransaction->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Transaction::with('user', 'manager')
        ->where('type', 'cashout')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Transaction::with('user', 'manager')
        ->where('type', 'cashout')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $transaction) {
        $nestedData['account_no'] = $transaction->account_no;
        $nestedData['user_id'] = $transaction->user ? $transaction->user->name : null;
        $nestedData['manager'] = $transaction->manager ? $transaction->manager->name : null;
        $nestedData['date'] = date('d/m/Y', strtotime($transaction->date));
        $nestedData['amount'] = $transaction->amount;
        $nestedData['transactionable_type'] = $transaction->transactionable_display_name;

        $data[] = $nestedData;


      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }
  public function dataTransactions(Request $request)
  {
    $columns = array(
      0 => 'date',
      1 => 'transactionable_type',
      2 => 'account_no',
    );

    $query = Transaction::query();
    // Apply filters
    if ($request->filled('date_filter')) {
      $query->where('date', $request->input('date_filter'));
    }

    if ($request->filled('account_no_filter')) {
      $query->where('account_no', $request->input('account_no_filter'));
    }

    if ($request->filled('transactionable_type_filter')) {
      $query->where('transactionable_type', $request->input('transactionable_type_filter'));
    }

    $totalData = $query->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $queryTransaction = Transaction::with('user', 'manager')
        ->whereHasMorph('transactionable', ['App\Models\SavingsCollection',
          'App\Models\DailyLoanCollection',
          'App\Models\DpsInstallment',
          'App\Models\SpecialInstallment',
          'App\Models\FdrDeposit',
          'App\Models\TakenLoan',
          'App\Models\SpecialLoanTaken',
          'App\Models\DailyLoan',
          'App\Models\FdrWithdraw',
          'App\Models\FdrProfit',
          'App\Models\DailySavingsComplete',
          'App\Models\DpsComplete',
          'App\Models\SpecialDpsComplete',
          'App\Models\FdrComplete',
        ]);
      // Apply filters
      if ($request->filled('date_filter')) {
        $queryTransaction->where('date', $request->input('date_filter'));
      }

      if ($request->filled('account_no_filter')) {
        $queryTransaction->where('account_no', $request->input('account_no_filter'));
      }

      if ($request->filled('transactionable_type_filter')) {
        $queryTransaction->where('transactionable_type', $request->input('transactionable_type_filter'));
      }
      $posts = $queryTransaction->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Transaction::with('user', 'manager')->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Transaction::with('user', 'manager')->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $transaction) {
        $nestedData['account_no'] = $transaction->account_no;
        $nestedData['user_id'] = $transaction->user ? $transaction->user->name : null;
        $nestedData['manager'] = $transaction->manager ? $transaction->manager->name : null;
        $nestedData['type'] = $transaction->transaction_type;
        $nestedData['date'] = date('d/m/Y', strtotime($transaction->date));
        if ($transaction->type == 'cashin') {
          $nestedData['amount'] = "<span class='text-success'>{$transaction->amount}</span>";
          $nestedData['transactionable_type'] = "<span class='text-success'>{$transaction->transactionable_display_name}</span>";
        }else{
          $nestedData['amount'] = "<span class='text-danger'>{$transaction->amount}</span>";
          $nestedData['transactionable_type'] = "<span class='text-danger'>{$transaction->transactionable_display_name}</span>";
        }


        $data[] = $nestedData;


      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public static function trxId($date)
  {
    $record = Transaction::latest('id')->first();
    $dateTime = new Carbon($date);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $uid = substr(str_shuffle($permitted_chars), 0, 6);
    if ($record) {
      $expNum = explode('-', $record->trx_id);
      if ($dateTime->format('jny') == $expNum[1]) {
        $s = str_pad($expNum[3] + 1, 4, "0", STR_PAD_LEFT);
        $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $uid . '-' . $s;
      } else {
        //increase 1 with last invoice number
        $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';
      }
    } else {

      $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';

    }

    return $nextTxNumber;
  }


}
