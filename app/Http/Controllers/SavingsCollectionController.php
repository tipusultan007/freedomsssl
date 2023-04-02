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
use App\Http\Requests\SavingsCollectionStoreRequest;
use App\Http\Requests\SavingsCollectionUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class SavingsCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SavingsCollection::class);

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

        if (!empty($request->account) && !empty($request->collector) && !empty($request->from) && !empty($request->to))
        {
            $totalData = SavingsCollection::where('account_no',$request->account)
                ->where('collector_id',$request->collector)
                ->whereBetween('date',[$request->from,$request->to])
                ->count();
        }elseif (!empty($request->from) && !empty($request->to))
        {
            $totalData = SavingsCollection::whereBetween('date',[$request->from,$request->to])
                ->count();
        }elseif (!empty($request->account) && !empty($request->collector))
        {
            $totalData = SavingsCollection::where('account_no',$request->account)
                ->where('collector_id',$request->collector)
                ->count();
        }elseif (!empty($request->account) && !empty($request->from) && !empty($request->to))
        {
            $totalData = SavingsCollection::where('account_no',$request->account)
                ->whereBetween('date',[$request->from,$request->to])
                ->count();
        }elseif (!empty($request->collector) && !empty($request->from) && !empty($request->to))
        {
            $totalData = SavingsCollection::where('collector_id',$request->collector)
                ->whereBetween('date',[$request->from,$request->to])
                ->count();
        }elseif (!empty($request->account))
        {
            $totalData = SavingsCollection::where('account_no',$request->account)->count();
        }elseif (!empty($request->collector))
        {
            $totalData = SavingsCollection::where('collector_id',$request->collector)
                ->whereBetween('date',[$request->from,$request->to])
                ->count();
        }else{
            $totalData = SavingsCollection::count();
        }

        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {
            if (!empty($request->account) && !empty($request->collector) && !empty($request->from) && !empty($request->to))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.account_no',$request->account)
                    ->where('savings_collections.collector_id',$request->collector)
                    ->whereBetween('savings_collections.date',[$request->from,$request->to])
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }elseif (!empty($request->from) && !empty($request->to))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->whereBetween('savings_collections.date',[$request->from,$request->to])
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }elseif (!empty($request->account) && !empty($request->collector))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.account_no',$request->account)
                    ->where('savings_collections.collector_id',$request->collector)
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }elseif ($request->account !="" && $request->from !="" && $request->to !="")
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.account_no',$request->account)
                    ->whereBetween('savings_collections.date',[$request->from,$request->to])
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();

            }elseif (!empty($request->collector) && !empty($request->from) && !empty($request->to))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.collector_id',$request->collector)
                    ->whereBetween('savings_collections.date',[$request->from,$request->to])
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();

            }elseif (!empty($request->account))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.account_no',$request->account)
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }elseif (!empty($request->collector))
            {
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->where('savings_collections.collector_id',$request->collector)
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }else{
                $posts = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                    ->join('users as collector','collector.id','=','savings_collections.collector_id')
                    ->select('savings_collections.*','users.name','collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('savings_collections.date','desc')
                    ->get();
            }
        }
        else {
            $search = $request->input('search.value');
            $posts =  SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                ->join('users as collector','collector.id','=','savings_collections.collector_id')
                ->where('savings_collections.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->select('savings_collections.*','users.name','collector.name as c_name')
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
            $totalFiltered = SavingsCollection::join('users','users.id','=','savings_collections.user_id')
                ->join('users as collector','collector.id','=','savings_collections.collector_id')
                ->where('savings_collections.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->select('savings_collections.*','users.name','collector.name as c_name')
                ->count();

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
                $nestedData['name'] = $post->name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['amount'] = $post->saving_amount;
                $type = '';
                if ($post->type=='withdraw')
                {
                    $type = '<span class="badge bg-light-danger">Withdraw</span>';
                }else{
                    $type = '<span class="badge bg-light-success">Deposit</span>';
                }
                $nestedData['type'] = $type;
                $nestedData['date'] = $post->date;
                $nestedData['late_fee'] = $post->late_fee;
                $nestedData['other_fee'] = $post->other_fee;
                $nestedData['balance'] = $post->balance;
                $nestedData['collection_id'] = $post->collection_id;
                $nestedData['collector_id'] = $post->collector_id;
                $nestedData['collector'] = $post->c_name;
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
        $this->authorize('create', SavingsCollection::class);

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
        $this->authorize('create', SavingsCollection::class);

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
        $this->authorize('view', $savingsCollection);

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
        $this->authorize('update', $savingsCollection);

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
    public function update(Request $request) {
        $savingsCollection = SavingsCollection::find($request->id);
        $dailyCollection = DailyCollection::find($savingsCollection->collection_id);
        $this->authorize('update', $savingsCollection);

        $late_fee = $request->late_fee!=""?$request->late_fee:0;
        $other_fee = $request->other_fee!=""?$request->other_fee:0;

        if ($savingsCollection->type == 'deposit')
        {
            if ($request->type == 'deposit')
            {
                $cashin = CashIn::where('daily_collection_id',$savingsCollection->collection_id)->first();
                $cashin->account_no = $savingsCollection->account_no;
                $cashin->daily_collection_id = $savingsCollection->collection_id;
                $cashin->amount = $request->saving_amount + $late_fee + $other_fee;
                $cashin->date = $request->date;
                $cashin->created_by = $request->collector_id;
                $cashin->save();
                $dailyCollection->saving_amount = $request->saving_amount;
                $dailyCollection->late_fee = $request->late_fee;
                $dailyCollection->other_fee = $request->other_fee;
                $dailyCollection->savings_balance = $request->balance;
                $dailyCollection->collector_id = $request->collector_id;
                $dailyCollection->date = $request->date;
                $dailyCollection->saving_type = $request->type;
                $dailyCollection->save();
            }else{
                CashIn::where('daily_collection_id',$savingsCollection->collection_id)->delete();
                $cashout = Cashout::create([
                    'cashout_category_id' => 1,
                    'account_no' => $savingsCollection->account_no,
                    'daily_collection_id' => $savingsCollection->collection_id,
                    'amount' => $request->saving_amount - ($late_fee + $other_fee),
                    'date' => $request->date,
                    'created_by' => $request->collector_id,
                    'user_id' => $savingsCollection->user_id,
                ]);

                $dailyCollection->saving_amount = $request->saving_amount;
                $dailyCollection->late_fee = $request->late_fee;
                $dailyCollection->other_fee = $request->other_fee;
                $dailyCollection->savings_balance = $request->balance;
                $dailyCollection->collector_id = $request->collector_id;
                $dailyCollection->date = $request->date;
                $dailyCollection->saving_type = $request->type;
                $dailyCollection->save();
            }
        }else{
            if ($request->type == 'withdraw')
            {
                $cashout = Cashout::where('daily_collection_id',$savingsCollection->collection_id)->first();
                $cashout->account_no = $savingsCollection->account_no;
                $cashout->daily_collection_id = $savingsCollection->collection_id;
                $cashout->amount = $request->saving_amount - ($late_fee + $other_fee);
                $cashout->date = $request->date;
                $cashout->created_by = $request->collector_id;
                $cashout->save();
                $dailyCollection->saving_amount = $request->saving_amount;
                $dailyCollection->late_fee = $request->late_fee;
                $dailyCollection->other_fee = $request->other_fee;
                $dailyCollection->savings_balance = $request->balance;
                $dailyCollection->collector_id = $request->collector_id;
                $dailyCollection->date = $request->date;
                $dailyCollection->saving_type = $request->type;
                $dailyCollection->save();
            }else{
                Cashout::where('daily_collection_id',$savingsCollection->collection_id)->delete();
                $cashin = CashIn::create([
                    'cashin_category_id' => 1,
                    'account_no' => $savingsCollection->account_no,
                    'daily_collection_id' => $savingsCollection->collection_id,
                    'amount' => $request->saving_amount + $late_fee + $other_fee,
                    'date' => $request->date,
                    'created_by' => $request->collector_id,
                    'user_id' => $savingsCollection->user_id,
                ]);
                $dailyCollection->saving_amount = $request->saving_amount;
                $dailyCollection->late_fee = $request->late_fee;
                $dailyCollection->other_fee = $request->other_fee;
                $dailyCollection->savings_balance = $request->balance;
                $dailyCollection->collector_id = $request->collector_id;
                $dailyCollection->date = $request->date;
                $dailyCollection->saving_type = $request->type;
                $dailyCollection->save();
            }
        }
        $savingsCollection->update($request->all());
        return 'success';
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SavingsCollection $savingsCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $savingsCollection = SavingsCollection::find($id);
        $dailySavings = DailySavings::find($savingsCollection->daily_savings_id);
        $dailyCollection = DailyCollection::find($savingsCollection->collection_id);
        $this->authorize('delete', $savingsCollection);


        if ($dailyCollection->saving_type=='deposit'){
            $cashIn = CashIn::where('cashin_category_id',2)->where('daily_collection_id',$savingsCollection->collection_id)->first();
            if ($cashIn)
            {
                $cashIn->delete();
            }

            $dailySavings->deposit -= $savingsCollection->saving_amount;
            $dailySavings->total -= $savingsCollection->saving_amount;
            $dailySavings->save();
            SavingsAccount::delete($dailyCollection->trx_id);


        }elseif($dailyCollection->saving_type=='withdraw')
        {
            $cashOut = Cashout::where('cashout_category_id',2)->where('daily_collection_id',$savingsCollection->collection_id)->first();
            if ($cashOut)
            {
                $cashOut->delete();
            }

            $dailySavings->deposit += $savingsCollection->saving_amount;
            $dailySavings->total += $savingsCollection->saving_amount;
            $dailySavings->save();

            DailyWithdrawAccount::delete($dailyCollection->trx_id);
        }

        if ($savingsCollection->late_fee > 0) {
            LateFeeAccount::delete($savingsCollection->trx_id);
        }
        if ($savingsCollection->other_fee > 0) {
            {
                OtherFeeAccount::delete($savingsCollection->trx_id);
            }
        }
        $savingsCollection->delete();
        if ($dailyCollection)
        {
            if ($dailyCollection->loan_installment>0)
            {
                $dailyCollection->saving_amount = NULL;
                $dailyCollection->saving_amount = NULL;
                $dailyCollection->late_fee = NULL;
                $dailyCollection->other_fee = NULL;
                $dailyCollection->savings_balance = NULL;
                $dailyCollection->daily_savings_id = NULL;
                $dailyCollection->saving_note = NULL;
                $dailyCollection->saving_type = NULL;
                $dailyCollection->save();
            }else{
                $dailyCollection->delete();
            }
        }
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
