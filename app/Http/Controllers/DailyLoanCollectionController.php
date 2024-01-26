<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Imports\DailyLoanCollectionImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\DailyCollection;
use App\Models\SavingsCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Models\DailyLoanCollection;
use App\Http\Requests\DailyLoanCollectionStoreRequest;
use App\Http\Requests\DailyLoanCollectionUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DailyLoanCollectionController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    ////$this->authorize('view-any', DailyLoanCollection::class);

    $search = $request->get('search', '');

    $dailyLoanCollections = DailyLoanCollection::search($search)
      ->latest()
      ->paginate(5)
      ->withQueryString();

    return view(
      'app.daily_loan_collections.index',
      compact('dailyLoanCollections', 'search')
    );
  }

  public function dataDailyLoanCollection(Request $request)
  {
    $query = DailyLoanCollection::query();

    if (!empty($request->account)) {
      $query->where('account_no', $request->account);
    }

    if (!empty($request->collector)) {
      $query->where('collector_id', $request->collector);
    }

    if (!empty($request->from) && !empty($request->to)) {
      $query->whereBetween('date', [$request->from, $request->to]);
    }

    $totalData = $query->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    if (empty($request->input('search.value'))) {
      $query = DailyLoanCollection::with('user', 'collector', 'createdBy');

      if (!empty($request->account)) {
        $query->where('account_no', $request->account);
      }

      if (!empty($request->collector)) {
        $query->where('collector_id', $request->collector);
      }

      if (!empty($request->from) && !empty($request->to)) {
        $query->whereBetween('date', [$request->from, $request->to]);
      }

      $posts = $query->offset($start)
        ->limit($limit)
        ->orderBy('date', 'asc')
        ->get();

    } else {
      $search = $request->input('search.value');

      $posts = DailyLoanCollection::with('user', 'collector', 'createdBy')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          return $query->where('name', 'LIKE', "%{$search}%");
        })->offset($start)
        ->limit($limit)
        ->orderBy('date', 'desc')
        ->get();

      $totalFiltered = DailyLoanCollection::with('user', 'collector', 'createdBy')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          return $query->where('name', 'LIKE', "%{$search}%");
        }
        )->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('daily-loan-collections.show', $post->id);
        $edit = route('daily-loan-collections.edit', $post->id);

        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['daily_loan_id'] = $post->daily_loan_id;
        $nestedData['name'] = $post->user->name??"";
        $nestedData['account_no'] = $post->account_no;
        $nestedData['amount'] = $post->loan_installment;
        $nestedData['date'] = date('d/m/Y',strtotime($post->date));
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
    ////$this->authorize('create', DailyLoanCollection::class);

    $dailyLoans = DailyLoan::pluck('opening_date', 'id');
    $users = User::pluck('name', 'id');

    return view(
      'app.daily_loan_collections.create',
      compact('dailyLoans', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DailyLoanCollectionStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(DailyLoanCollectionStoreRequest $request)
  {
    ////$this->authorize('create', DailyLoanCollection::class);

    $validated = $request->validated();

    $dailyLoanCollection = DailyLoanCollection::create($validated);

    return redirect()
      ->route('daily-loan-collections.edit', $dailyLoanCollection)
      ->withSuccess(__('crud.common.created'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoanCollection $dailyLoanCollection
   * @return \Illuminate\Http\Response
   */
  public function show(
    Request             $request,
    DailyLoanCollection $dailyLoanCollection
  )
  {
    // //$this->authorize('view', $dailyLoanCollection);

    return view(
      'app.daily_loan_collections.show',
      compact('dailyLoanCollection')
    );
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoanCollection $dailyLoanCollection
   * @return \Illuminate\Http\Response
   */
  public function edit(
    Request             $request,
    DailyLoanCollection $dailyLoanCollection
  )
  {
    // //$this->authorize('update', $dailyLoanCollection);

    $dailyLoans = DailyLoan::pluck('opening_date', 'id');
    $users = User::pluck('name', 'id');

    return view(
      'app.daily_loan_collections.edit',
      compact('dailyLoanCollection', 'dailyLoans', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DailyLoanCollectionUpdateRequest $request
   * @param \App\Models\DailyLoanCollection $dailyLoanCollection
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $dailyLoanCollection = DailyLoanCollection::find($request->id);
    $dailyLoan = DailyLoan::find($dailyLoanCollection->daily_loan_id);
    $dailyLoan->balance += $dailyLoanCollection->loan_installment;
    $dailyLoan->save();

    $late_fee = $request->loan_late_fee != "" ? $request->loan_late_fee : 0;
    $other_fee = $request->loan_other_fee != "" ? $request->loan_other_fee : 0;
    $data = $request->all();
    $data['late_fee'] = $late_fee;
    $data['other_fee'] = $other_fee;
    $data['manager_id'] = Auth::id();
    $dailyLoanCollection->update($data);
    $dailyLoan->balance -= $dailyLoanCollection->loan_installment;
    $dailyLoan->save();
    $dailyLoanCollection->loan_balance = $dailyLoan->balance;
    $dailyLoanCollection->save();


    // Update the existing transaction
    $transaction = Transaction::where('transactionable_id', $dailyLoanCollection->id)
      ->where('transactionable_type', DailyLoanCollection::class)
      ->first();

    if ($transaction) {
      $transaction->update([
        'amount' => $dailyLoanCollection->loan_installment + $late_fee + $other_fee,
        'type' => 'cashin',
        'manager_id' => Auth::id()
      ]);
    }

    return json_encode("Success");
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DailyLoanCollection $dailyLoanCollection
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dailyLoanCollection = DailyLoanCollection::find($id);
    $dailyLoan = DailyLoan::find($dailyLoanCollection->daily_loan_id);

    $dailyLoan->balance += $dailyLoanCollection->loan_installment;
    $dailyLoan->save();
    $dailyLoanCollection->delete();

    return response()->json([
      'message' => 'Data deleted successfully!'
    ]);

  }

  public function getLoanCollectionData($id)
  {
    $data = DailyLoanCollection::with('user')->find($id);
    return json_encode($data);
  }

  public function import(Request $request)
  {
    Excel::import(new DailyLoanCollectionImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
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

}
