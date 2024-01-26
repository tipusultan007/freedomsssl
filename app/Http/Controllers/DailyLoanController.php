<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyLoanAccount;
use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Imports\DailyLoanImport;
use App\Imports\SavingsCollectionImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoanCollection;
use App\Models\DailySavings;
use App\Models\Guarantor;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailyLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DailyLoanPackage;
use App\Http\Requests\DailyLoanStoreRequest;
use App\Http\Requests\DailyLoanUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DailyLoanController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    ////$this->authorize('view-any', DailyLoan::class);
//        $collections = DailyCollection::where('loan_installment','>',0)->get();
//        foreach ($collections as $collection)
//        {
//            $collection->trx_id = Str::uuid();
//            $expNum = explode('-', $collection->account_no);
//            $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
//            $collection->account_no = 'DS'.$s;
//            $collection->save();
//        }

    /*  $loans = DailyLoan::all();
       foreach ($loans as $loan)
       {
           $expNum = explode('-', $loan->account_no);
           $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
           $loan->account_no = 'DS'.$s;
           $loan->save();

           $principal = $loan->loan_amount;
           $package = DailyLoanPackage::find($loan->package_id);
           $interest = $principal*($package->interest/100)*1;
           $principalWithInterest = floatval($principal) + floatval($interest);
           $installment = $principalWithInterest/$package->months;

           $loan->interest = $interest;
           $loan->total = $principalWithInterest;
           $loan->balance = $principalWithInterest;
           $loan->per_installment = $installment;
           $loan->save();
           $loan->trx_id = Str::uuid();
           $loan->save();
           $data = $loan;
           $data['name'] = $loan->user->name;
           $data = $loan;
           $data['name'] = $loan->user->name;
           $data['trx_type'] = 'cash';
           DailyLoanAccount::create($data);
           Cashout::create([
               'cashout_category_id' => 1,
               'account_no'          => $loan->account_no,
               'daily_loan_id'       => $loan->id,
               'amount'              => $loan->loan_amount,
               'date'                => $loan->opening_date,
               'created_by'          => $loan->created_by,
               'user_id'             => $loan->user_id,
               'trx_id' => $loan->trx_id
           ]);
       }*/

    return view('app.daily_loans.index');
  }

  public function dailyLoanData(Request $request)
  {
    $totalData = DailyLoan::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    //$order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $posts = DailyLoan::with('user', 'package')
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = DailyLoan::with('user', 'package')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        // ->orderBy($order,$dir)
        ->get();

      $totalFiltered = DailyLoan::with('user', 'package')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('daily-loans.show', $post->id);
        $edit = route('daily-loans.edit', $post->id);

        $date = new Carbon($post->opening_date);
        $nestedData['id'] = $post->id;
        $nestedData['name'] = $post->user->name;
        $nestedData['phone'] = $post->user->phone1;
        $nestedData['balance'] = $post->balance;
        $nestedData['adjusted_amount'] = $post->adjusted_amount;
        $nestedData['commencement'] = $post->commencement;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['months'] = $post->package->months;
        $nestedData['date'] = $date->format('d/m/Y');;
        $nestedData['per_installment'] = $post->per_installment;
        $nestedData['interest'] = $post->interest;
        $nestedData['loan_amount'] = $post->loan_amount;
        $nestedData['total'] = $post->loan_amount + $post->interest;
        $nestedData['status'] = $post->status;
        $nestedData['profile_photo_url'] = $post->user->image;
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

  public function getLoanCollectionDataByLoan(Request $request)
  {
    $totalData = DailyLoanCollection::where('daily_loan_id', $request->id)->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    if (empty($request->input('search.value'))) {
      $posts = DailyLoanCollection::with('user', 'collector')->where('daily_loan_id', $request->id)
        ->offset($start)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {

        $date = new Carbon($post->date);

        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['daily_loan_id'] = $post->daily_loan_id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['amount'] = $post->loan_installment;
        $nestedData['date'] = $date->format('d M Y');
        $nestedData['late_fee'] = $post->loan_late_fee;
        $nestedData['other_fee'] = $post->loan_other_fee;
        $nestedData['balance'] = $post->loan_balance;
        $nestedData['note'] = $post->loan_note;
        $nestedData['collector'] = $post->collector->name;
        $nestedData['collection_id'] = $post->collection_id;
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
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    // //$this->authorize('create', DailyLoan::class);

    $users = User::all();
    $dailyLoanPackages = DailyLoanPackage::all();

    return view(
      'app.daily_loans.create',
      compact('users', 'dailyLoanPackages', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DailyLoanStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $data['trx_id'] = Str::uuid();
    $data['manager_id'] = Auth::id();
    $activeLoan = DailyLoan::where('account_no', $data['account_no'])->where('balance', '>', 0)->first();

    if ($activeLoan) {
      return redirect()->route('daily-loans.create')->with("error", "প্রদত্ত হিসাব নং - {$data['account_no']} এর দৈনিক ঋণ চলমান রয়েছে!");
    }
    $dailyLoan = DailyLoan::create($data);

    $dailyLoan->total = $dailyLoan->interest + $dailyLoan->loan_amount;
    $dailyLoan->balance = $dailyLoan->interest + $dailyLoan->loan_amount;
    $dailyLoan->save();

    $data['daily_loan_id'] = $dailyLoan->id;
    $guarantor = Guarantor::create($data);

    return redirect()->route('daily-loans.index')->with('success', 'ঋণ বিতরন সফল হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoan $dailyLoan
   * @return \Illuminate\Http\Response
   */


  public function show(Request $request, DailyLoan $dailyLoan)
  {
    // //$this->authorize('view', $dailyLoan);

    return view('app.daily_loans.show', compact('dailyLoan'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoan $dailyLoan
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, DailyLoan $dailyLoan)
  {
    ////$this->authorize('update', $dailyLoan);

    $users = User::all();
    $dailyLoanPackages = DailyLoanPackage::all();

    return view(
      'app.daily_loans.edit',
      compact('dailyLoan', 'users', 'dailyLoanPackages', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DailyLoanUpdateRequest $request
   * @param \App\Models\DailyLoan $dailyLoan
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, DailyLoan $dailyLoan)
  {
    $old_loan = $dailyLoan->loan_amount;
    $data = $request->all();
    $dailyLoan->update($data);


    $guarantor = Guarantor::firstOrCreate(['daily_loan_id' => $dailyLoan->id]);
    //dd($guarantor);
    $guarantor->update($data);
    if ($old_loan != $dailyLoan->loan_amount) {
      $transaction = Transaction::where('transactionable_id', $dailyLoan->id)
        ->where('transactionable_type', DailyLoan::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $dailyLoan->loan_amount,
          'type' => 'cashout',
          'manager_id' => Auth::id()
        ]);
      }
    }
    //DailyLoanAccount::update($dailyLoan->trx_id,$dailyLoan->loan_amount);
    return redirect()
      ->route('daily-loans.index')
      ->with('success', 'ঋণ বিতরণ এডিট সম্পন্ন হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoan $dailyLoan
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $loan = DailyLoan::with('dailyLoanCollections')->find($id);

    $dailyLoanCollection = $loan->dailyLoanCollections->pluck('id');
    Transaction::where('transactionable_type', DailyLoanCollection::class)
      ->whereIn('transactionable_id', $dailyLoanCollection)
      ->delete();

    $loan->delete();
    return "success";
  }

  public function deleteInterestTransaction($trxId)
  {
    $transaction = Transaction::where('account_id', 7)->where('trx_id', $trxId)->first();
    if ($transaction) {
      $interestAccount = Account::find(7); //INCOME (LOAN INTEREST PAID+)
      $interestAccount->balance -= $transaction->amount;
      $interestAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance -= $transaction->amount;
      $cashAccount->save();

      $unpaidInterestAccount = Account::find(8); //INCOME (LOAN INTEREST UNPAID-)
      $unpaidInterestAccount->balance += $transaction->amount;
      $unpaidInterestAccount->save();

      $unpaidInterestAccount1 = Account::find(5); //ASSET (LOAN INTEREST UNPAID-)
      $unpaidInterestAccount1->balance += $transaction->amount;
      $unpaidInterestAccount1->save();

      $transaction->delete();
    }
  }

  public function deleteLoanTransaction($trxId)
  {
    $transaction = Transaction::where('account_id', 13)->where('trx_id', $trxId)->first();

    if ($transaction) {
      $interestAccount = Account::find(13); //LOAN PAYMENT+
      $interestAccount->balance -= $transaction->amount;
      $interestAccount->save();

      $cashAccount = Account::find(4); //ASSET (CASH+)
      $cashAccount->balance -= $transaction->amount;
      $cashAccount->save();

      $loanProvidetAccount = Account::find(2); //ASSET (LOAN PROVIDE-)
      $loanProvidetAccount->balance += $transaction->amount;
      $loanProvidetAccount->save();

      $transaction->delete();
    }
  }

  public function import(Request $request)
  {
    Excel::import(new DailyLoanImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }

}
