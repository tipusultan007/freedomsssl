<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\Nominees;
use App\Models\ProfitCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrStoreRequest;
use App\Http\Requests\FdrUpdateRequest;

class FdrController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Fdr::class);

        $search = $request->get('search', '');
        $users = User::all();
        $fdrPackages = FdrPackage::all();
        $fdrs = Fdr::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.fdrs.index', compact('fdrs', 'search','users','fdrPackages'));
    }

    public function allFdrs(Request $request)
    {

        $columns = array(
            1 =>'name',
            2=> 'account',
            3=> 'amount',
        );

        $totalData = Fdr::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = Fdr::join('users','users.id','=','fdrs.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdrs.created_by')
                ->select('fdrs.*','users.name as name','users.phone1','creator.name as created_by')
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Fdr::join('users','users.id','=','fdrs.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdrs.created_by')
                ->select('fdrs.*','users.name as name','users.phone1','creator.name as created_by')
                ->where('fdrs.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();

            $totalFiltered =  Fdr::join('users','users.id','=','fdrs.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdrs.created_by')
                ->select('fdrs.*','users.name as name','users.phone1','creator.name as created_by')
                ->where('fdrs.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('fdrs.show',$post->id);
                $edit =  route('fdrs.edit',$post->id);

                $date = new Carbon($post->date);
                $nestedData['id'] = $post->id;
                $nestedData['user_id'] = $post->user_id;
                $nestedData['phone'] = $post->phone1??'';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->name;
                $nestedData['created_by'] = $post->created_by;
                $nestedData['package'] = $post->package;
                $nestedData['amount'] = $post->amount;
                $nestedData['date'] = $date->format('d/m/Y');
                $nestedData['note'] = $post->note;
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
        $this->authorize('create', Fdr::class);

        $users = User::all();
        $fdrPackages = FdrPackage::all();

        return view('app.fdrs.create', compact('users', 'fdrPackages'));
    }

    /**
     * @param \App\Http\Requests\FdrStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Fdr::class);

        $data = $request->all();
        $data['account_no'] = 'FDR'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $fdr = Fdr::create($data);
        $data['fdr_id'] = $fdr->id;
        $data['balance'] = $fdr->amount;
        $fdr->balance += $request->amount;
        $fdr->save();
        $deposit = FdrDeposit::create($data);

        $transaction =

        $cashin = CashIn::create([
            'user_id' => $fdr->user_id,
            'cashin_category_id' => 5,
            'account_no' => $fdr->account_no,
            'frd_deposit_id' => $deposit->id,
            'amount' => $deposit->amount,
            'date' => $deposit->date,
            'created_by' => $deposit->created_by
        ]);

        $transaction = $this->accountTransaction($deposit);
       /* return redirect()
            ->route('fdrs.edit', $fdr)
            ->withSuccess(__('crud.common.created'));*/
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Fdr $fdr)
    {
        $this->authorize('view', $fdr);

        return view('app.fdrs.show', compact('fdr'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fdr $fdr)
    {
        $this->authorize('update', $fdr);

        $users = User::pluck('name', 'id');
        $fdrPackages = FdrPackage::pluck('name', 'id');

        return view('app.fdrs.edit', compact('fdr', 'users', 'fdrPackages'));
    }

    /**
     * @param \App\Http\Requests\FdrUpdateRequest $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function update(FdrUpdateRequest $request, Fdr $fdr)
    {
        $this->authorize('update', $fdr);

        $validated = $request->validated();

        $fdr->update($validated);

        return redirect()
            ->route('fdrs.edit', $fdr)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fdr = Fdr::find($id);
        $this->authorize('delete', $fdr);
        $deposits = FdrDeposit::where('fdr_id',$id)->get();
        $withdraws = FdrWithdraw::where('fdr_id',$id)->get();
        $profits = FdrProfit::where('fdr_id',$id)->get();
        foreach ($deposits as $deposit)
        {
            Transaction::where('account_id',1)->where('trx_id',$deposit->trx_id)->delete();
            $deposit->delete();
        }
        foreach ($withdraws as $withdraw)
        {
            Transaction::where('account_id',16)->where('trx_id',$deposit->trx_id)->delete();
            $withdraw->delete();
        }
        foreach ($profits as $profit)
        {
            Transaction::where('account_id',16)->where('trx_id',$profit->trx_id)->delete();
            ProfitCollection::where('fdr_profit_id',$profit->id)->delete();
            $profit->delete();
        }
        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance += $fdr->profit;
        $cashAccount->save();

        $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
        $depositAccount->balance -= $fdr->balance;
        $depositAccount->save();

        Nominees::where('account_no',$fdr->account_no)->delete();
        CashIn::where('account_no',$fdr->account_no)->delete();
        Cashout::where('account_no',$fdr->account_no)->delete();
        $fdr->delete();

        return "success";
    }

    public function isExist($account)
    {
        $fdr = Fdr::where('account_no',$account)->first();
        if ($fdr)
        {
            return "yes";
        }else{
            return "no";
        }
    }

}
