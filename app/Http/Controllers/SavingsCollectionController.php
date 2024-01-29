<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\SavingsAccount;
use App\Imports\SavingsCollectionImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\SavingsCollection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SavingsCollectionController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {


    $search = $request->get('search', '');

    $savingsCollections = SavingsCollection::search($search)
      ->latest()
      ->paginate(5)
      ->withQueryString();

    return view(
      'app.savings_collections.index',
      compact('savingsCollections', 'search')
    );
  }

  public function dataSavingsCollection(Request $request)
  {

    $totalData = SavingsCollection::query();

    if (!empty($request->account)) {
      $totalData->where('account_no', $request->account);
    }

    if (!empty($request->collector)) {
      $totalData->where('collector_id', $request->collector);
    }

    if (!empty($request->from) && !empty($request->to)) {
      $totalData->whereBetween('date', [$request->from, $request->to]);
    }
    $totalData = $totalData->count();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    if(empty($request->input('search.value')))
    {
      $query = SavingsCollection::with('user', 'collector');

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
        ->orderBy('id', 'desc')
        ->get();
    }
    else {
      $search = $request->input('search.value');
      $posts = SavingsCollection::with('user', 'collector')
        ->where(function ($query) use ($search) {
          $query->where('account_no', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function ($query) use ($search) {
              $query->where('name', 'LIKE', "%{$search}%");
            });
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();

      $totalFiltered = SavingsCollection::where(function ($query) use ($search) {
        $query->where('account_no', 'LIKE', "%{$search}%")
          ->orWhereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
          });
      })->count();

    }

    $data = array();
    if(!empty($posts))
    {
      foreach ($posts as $post)
      {
        $show =  route('savings-collections.show',$post->id);
        $edit =  route('savings-collections.edit',$post->id);

        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['daily_savings_id'] = $post->daily_savings_id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['amount'] = $post->saving_amount;
        $type = '';
        if ($post->type=='withdraw')
        {
          $type = '<span class="badge bg-danger">উত্তোলন</span>';
        }else{
          $type = '<span class="badge bg-success">জমা</span>';
        }
        $nestedData['type'] = $type;
        $nestedData['date'] = date('d/m/Y',strtotime($post->date));
        $nestedData['late_fee'] = $post->late_fee;
        $nestedData['other_fee'] = $post->other_fee;
        $nestedData['balance'] = $post->balance;
        $nestedData['collection_id'] = $post->collection_id;
        $nestedData['collector'] = $post->manager->name;
        $data[] = $nestedData;

      }
    }

    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );

    echo json_encode($json_data);
  }
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

    $allDailySavings = DailySavings::pluck('account_no', 'id');
    $users = User::pluck('name', 'id');

    return view(
      'app.savings_collections.create',
      compact('allDailySavings', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\SavingsCollectionStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(SavingsCollectionStoreRequest $request)
  {


    $validated = $request->validated();

    $savingsCollection = SavingsCollection::create($validated);

    return redirect()
      ->route('savings-collections.edit', $savingsCollection)
      ->withSuccess(__('crud.common.created'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SavingsCollection $savingsCollection
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, SavingsCollection $savingsCollection)
  {

    return view(
      'app.savings_collections.show',
      compact('savingsCollection')
    );
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SavingsCollection $savingsCollection
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, SavingsCollection $savingsCollection)
  {
   // $this->authorize('update', $savingsCollection);

    $allDailySavings = DailySavings::pluck('account_no', 'id');
    $users = User::pluck('name', 'id');

    return view(
      'app.savings_collections.edit',
      compact('savingsCollection', 'allDailySavings', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\SavingsCollectionUpdateRequest $request
   * @param \App\Models\SavingsCollection $savingsCollection
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    $savingsCollection = SavingsCollection::find($id);

    $data = $request->all();
    if ($savingsCollection) {
      $oldSavingType = $savingsCollection->type;
      $oldSavingAmount = $savingsCollection->saving_amount;

      // Update the SavingsCollection model
      $savingsCollection->update([
        'saving_amount' => $data['saving_amount'],
        'type' => $data['type'],
        'late_fee' => $request->late_fee != "" ? $request->late_fee : 0,
        'other_fee' => $request->other_fee != "" ? $request->other_fee : 0,
        'date' => $data['date'],
        'manager_id' => Auth::id()
      ]);

      // Update DailySavings model deposit or withdraw based on saving_type
      $dailySaving = DailySavings::find($savingsCollection->daily_savings_id);

      if ($dailySaving) {



        if ($oldSavingType === 'deposit') {
          $dailySaving->deposit -= $oldSavingAmount;
          $dailySaving->total -= $oldSavingAmount;
          $dailySaving->balance -= $oldSavingAmount;
        } else {
          $dailySaving->withdraw -= $oldSavingAmount;
          $dailySaving->total += $oldSavingAmount;
          $dailySaving->balance += $oldSavingAmount;
        }


        // Update DailySavings model deposit or withdraw based on saving_type
        if ($data['type'] === 'deposit') {
          $dailySaving->deposit += $data['saving_amount'];
          $dailySaving->total += $data['saving_amount'];
          $dailySaving->balance += $data['saving_amount'];
          $data['total'] = $data['saving_amount'] + $savingsCollection->late_fee + $savingsCollection->other_fee;
        } else {
          $dailySaving->withdraw += $data['saving_amount'];
          $dailySaving->total -= $data['saving_amount'];
          $dailySaving->balance -= $data['saving_amount'];
          $data['total'] = $data['saving_amount'] - $savingsCollection->late_fee - $savingsCollection->other_fee;
        }
        $dailySaving->save();

        // Update the total and other fields in SavingsCollection
        $savingsCollection->update([
          'balance' => $dailySaving->total,
          'total' => $data['total'],
        ]);

        // Update the existing transaction
        $transaction = Transaction::where('transactionable_id', $savingsCollection->id)
          ->where('transactionable_type', SavingsCollection::class)
          ->first();

        if ($transaction) {
          $transaction->update([
            'amount' => $savingsCollection->total,
            'type' => $savingsCollection->type == 'deposit' ? 'cashin' : 'cashout',
            'manager_id' => Auth::id()
          ]);
        }

        return response()->json(['status'=>'error','message'=> 'SavingsCollection updated successfully!']);
      }
    }

    return response()->json(['status'=>'error','message'=> 'SavingsCollection not found.']);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SavingsCollection $savingsCollection
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    $savingsCollection = SavingsCollection::find($id);
    $savingsCollection->delete();
    return response()->json([
      'message' => 'Data deleted successfully!'
    ]);
  }

  public function getData($id)
  {
    $data = SavingsCollection::with('user')->find($id);

    return json_encode($data);
  }
  public function import(Request $request)
  {
    Excel::import(new SavingsCollectionImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }

}
