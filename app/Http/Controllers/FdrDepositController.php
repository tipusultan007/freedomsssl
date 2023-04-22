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

class FdrDepositController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrDeposit::class);

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
            $posts = FdrDeposit::join('users','users.id','=','fdr_deposits.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_deposits.created_by')
                ->join('fdr_packages as packages', 'packages.id', '=', 'fdr_deposits.fdr_package_id')
                ->select('fdr_deposits.*','users.name as name','users.phone1','creator.name as created_by','packages.name as package')
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  FdrDeposit::join('users','users.id','=','fdr_deposits.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_deposits.created_by')
                ->join('fdr_packages as packages', 'packages.id', '=', 'fdr_deposits.fdr_package_id')
                ->select('fdr_deposits.*','users.name as name','users.phone1','creator.name as created_by','packages.name as package')
                ->where('fdr_deposits.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();

            $totalFiltered =  FdrDeposit::join('users','users.id','=','fdr_deposits.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_deposits.created_by')
                ->join('fdr_packages as packages', 'packages.id', '=', 'fdr_deposits.fdr_package_id')
                ->select('fdr_deposits.*','users.name as name','creator.name as created_by','packages.name as package')
                ->where('fdr_deposits.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->count();
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
                $nestedData['user_id'] = $post->user_id;
                $nestedData['phone'] = $post->phone1??'';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->name;
                $nestedData['created_by'] = $post->created_by;
                $nestedData['package'] = $post->package;
                $nestedData['amount'] = $post->amount;
                $nestedData['date'] = $post->date;
                $nestedData['commencement'] = $commencement->format('d-m-Y');
                $nestedData['balance'] = $post->balance;
                $nestedData['profit'] = $post->profit;

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
        $this->authorize('create', FdrDeposit::class);

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
        $this->authorize('create', FdrDeposit::class);
        $fdr = Fdr::find($request->fdr_id);
        $fdr->amount +=$request->amount;
        $fdr->balance +=$request->amount;
        $fdr->save();
        $data = $request->all();
        $data['account_no'] = $fdr->account_no;
        $data['user_id'] = $fdr->user_id;
        $data['trx_id'] = TransactionController::trxId($request->date);
        $data['balance'] = $request->amount;
        $data['created_by'] = Auth::id();
        $fdrDeposit = FdrDeposit::create($data);

        $cashin = CashIn::create([
            'user_id' => $fdrDeposit->user_id,
            'cashin_category_id' => 5,
            'account_no' => $fdrDeposit->account_no,
            'frd_deposit_id' => $fdrDeposit->id,
            'amount' => $fdrDeposit->amount,
            'date' => $fdrDeposit->date,
            'created_by' => $fdrDeposit->created_by,
            'trx_id' => $fdrDeposit->trx_id
        ]);

        $data['trx_type'] = "cash";
        $data['name'] = $fdr->user->name;
        FdrDepositAccount::create($data);
        //$transaction = $this->accountTransaction($fdrDeposit);
       return 'success';
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('view', $fdrDeposit);

        return view('app.fdr_deposits.show', compact('fdrDeposit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('update', $fdrDeposit);

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
        $this->authorize('update', $fdrDeposit);

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

        $cashin = CashIn::where('fdr_deposit_id',$fdrDeposit->id)->latest()->first();
        $cashin->amount = $fdrDeposit->amount;
        $cashin->date = $fdrDeposit->date;
        $cashin->save();

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
        $this->authorize('delete', $fdrDeposit);
        $profitCollections = ProfitCollection::where('fdr_deposit_id',$id)->get();

        $fdrWithdraws = FdrWithdraw::where('fdr_deposit_id',$id)->get();
        //$withdrawAccount = Account::find(16);
        //$withdrawAccount->balance -= $fdrWithdraws->sum('amount');
        //$withdrawAccount->save();

        foreach ($profitCollections as $collection)
        {
            $totalProfit = 0;
            $profit = FdrProfit::where('fdr_profit_id',$collection->fdr_profit_id)->first();
            $totalProfit = $profit->profit - $profit->other_fee + $profit->grace;
            //$trx = Transaction::where('account_id',41)->where('trx_id',$profit->trx_id)->first();
            //$trx->amount -= $collection->total;
            //$trx->save();

            if ($totalProfit == $collection->total)
            {
                $profit->delete();
                $collection->delete();
                //$trx->delete();
            }else{
                $profit->profit -= $collection->total;
                $profit->save();
                $collection->save();
                //$trx->delete();

            }
        }
        foreach ($fdrWithdraws as $withdraw)
        {
            FdrWithdrawAccount::delete($withdraw->trx_id);
            //Transaction::where('trx_id',$withdraw->trx_id)->delete();
            $withdraw->delete();
        }


        /*$depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
        $depositAccount->balance -= $fdrDeposit->balance;
        $depositAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance -= $fdrDeposit->balance;
        $cashAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance += $fdrDeposit->profit;
        $cashAccount->save();*/

        FdrDepositAccount::delete($fdrDeposit->trx_id);

        CashIn::where('fdr_deposit_id',$id)->delete();
        Cashout::where('fdr_deposit_id',$id)->delete();


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
