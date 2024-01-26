<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\FdrDepositAccount;
use App\Http\Controllers\Accounts\FdrWithdrawAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\ProfitCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrDeposit;
use App\Models\FdrPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrDepositStoreRequest;
use App\Http\Requests\FdrDepositUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FdrDepositController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
           ['name' => 'List']
        ];

        return view('app.fdr_deposits.index', compact('breadcrumbs'));
    }

    public function allFdrDeposits(Request $request)
    {

        $columns = array(
            1 =>'name',
            2=> 'account',
            3=> 'amount',
        );

        $totalData = FdrDeposit::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
       // $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = FdrDeposit::with('user','manager','fdrPackage')
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  FdrDeposit::with('user','manager','fdrPackage')
                ->where('account_no','LIKE',"%{$search}%")
                ->orWhereHas('user',function ($query) use($search){
                  $query->where('name', 'LIKE',"%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered =  FdrDeposit::with('user','manager','fdrPackage')
              ->where('account_no','LIKE',"%{$search}%")
              ->orWhereHas('user',function ($query) use($search){
                $query->where('name', 'LIKE',"%{$search}%");
              })->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('fdr-deposits.show',$post->id);
                $edit =  route('fdr-deposits.edit',$post->id);

                $commencement = new Carbon($post->commencement);
                $nestedData['id'] = $post->id;
                $nestedData['user_id'] = $post->user_id??'';
                $nestedData['phone'] = $post->user->phone1??'';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->user->name??'';
                $nestedData['created_by'] = $post->manager->name;
                $nestedData['package'] = $post->fdrPackage->name??'';
                $nestedData['amount'] = $post->amount;
                $nestedData['date'] = $post->date;
                $nestedData['commencement'] = $commencement->format('d/m/Y');
                $nestedData['balance'] = $post->balance;
                $nestedData['profit'] = $post->profit??'-';
                $nestedData['image'] = $post->user->image;

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
        $fdrs = Fdr::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');
        $fdrPackages = FdrPackage::pluck('name', 'id');

        return view(
            'app.fdr_deposits.create',
            compact('fdrs', 'users', 'fdrPackages', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrDepositStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', FdrDeposit::class);
        $fdr = Fdr::find($request->fdr_id);
        $fdr->amount +=$request->amount;
        $fdr->balance +=$request->amount;
        $fdr->save();
        $data = $request->all();
        $data['account_no'] = $fdr->account_no;
        $data['user_id'] = $fdr->user_id;
        $data['balance'] = $request->amount;
        $data['manager_id'] = Auth::id();
        $fdrDeposit = FdrDeposit::create($data);
       return 'success';
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrDeposit $fdrDeposit)
    {
        //$this->authorize('view', $fdrDeposit);
        $fdrPackages = FdrPackage::all();
        return view('app.fdr_deposits.show', compact('fdrDeposit','fdrPackages'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrDeposit $fdrDeposit)
    {
        //$this->authorize('update', $fdrDeposit);

        $fdrs = Fdr::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');
        $fdrPackages = FdrPackage::pluck('name', 'id');

        return view(
            'app.fdr_deposits.edit',
            compact('fdrDeposit', 'fdrs', 'users', 'fdrPackages', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrDepositUpdateRequest $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fdrDeposit = FdrDeposit::find($request->id);
        //$this->authorize('update', $fdrDeposit);

        $fdr = Fdr::find($fdrDeposit->fdr_id);
        $fdr->amount -= $request->old_amount;
        $fdr->balance -= $request->old_amount;
        $fdr->save();

        $data = $request->all();
        $data['balance'] = $request->amount;
        $fdrDeposit->update($data);
        $fdr->amount += $request->amount;
        $fdr->balance += $request->amount;
        $fdr->save();

        return "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fdrDeposit = FdrDeposit::find($id);
        $fdr = Fdr::find($fdrDeposit->fdr_id);
        $fdr->amount -= $fdrDeposit->balance;
        $fdr->balance -= $fdr->balance;
        $fdr->save();
        //$this->authorize('delete', $fdrDeposit);
        $profitCollections = ProfitCollection::where('fdr_deposit_id',$id)->get();

        $fdrWithdraws = FdrWithdraw::where('fdr_deposit_id',$id)->get();
        //$withdrawAccount = Account::find(16);
        //$withdrawAccount->balance -= $fdrWithdraws->sum('amount');
        //$withdrawAccount->save();

        foreach ($profitCollections as $collection)
        {
          $totalProfit = 0;
          $profit = FdrProfit::where('id',$collection->fdr_profit_id)->first();
          $totalProfit = $profit->profit - $profit->other_fee + $profit->grace;

          if ($totalProfit == $collection->total)
          {
            $profit->delete();
            $collection->delete();
          }else{
            $profit->profit -= $collection->total;
            $profit->save();
            $collection->save();
          }
        }
        foreach ($fdrWithdraws as $withdraw)
        {
            $withdraw->delete();
        }
        $fdrDeposit->delete();

        return "success";
    }

    public function fdrDeposits($fdrId)
    {
        $fdrs = FdrDeposit::with('fdrPackage')->where('fdr_id',$fdrId)->get();

        echo json_encode($fdrs);
    }

    public function getFdrDeposit($id)
    {
        $fdrDeposit = FdrDeposit::with('user')->find($id);

        return json_encode($fdrDeposit);
    }

    public function accountTransaction(FdrDeposit $deposit)
    {
        $dps_transaction = Transaction::create([
               'account_id' => 1,
               'description' => 'FDR Deposit',
               'trx_id' => $deposit->trx_id,
               'date' => $deposit->date,
               'amount' => $deposit->amount,
               'user_id' => $deposit->created_by,
               'account_no' => $deposit->account_no,
               'name' => $deposit->user->name,
           ]);
        $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
        $depositAccount->balance += $dps_transaction->amount;
        $depositAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance += $dps_transaction->amount;
        $cashAccount->save();
    }
}
