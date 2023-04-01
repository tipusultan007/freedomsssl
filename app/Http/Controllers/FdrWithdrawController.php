<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\FdrWithdrawAccount;
use App\Models\Account;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrDeposit;
use App\Models\FdrWithdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrWithdrawStoreRequest;
use App\Http\Requests\FdrWithdrawUpdateRequest;
use Illuminate\Support\Facades\Auth;

class FdrWithdrawController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrWithdraw::class);

        $breadcrumbs = [
            ['name' => 'List']
        ];

        return view(
            'app.fdr_withdraws.index',
            compact('breadcrumbs')
        );
    }

    public function allFdrWithdraws(Request $request)
    {
        $columns = array(
            1 => 'name',
            2 => 'account',
            3 => 'amount',
        );

        $totalData = FdrWithdraw::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = FdrWithdraw::join('users', 'users.id', '=', 'fdr_withdraws.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_withdraws.created_by')
                ->select('fdr_withdraws.*', 'users.name as name', 'users.phone1', 'creator.name as created_by')
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no', 'asc')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = FdrWithdraw::join('users', 'users.id', '=', 'fdr_withdraws.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_withdraws.created_by')
                ->select('fdr_withdraws.*', 'users.name as name', 'users.phone1', 'creator.name as created_by')
                ->where('fdr_withdraws.account_no', 'LIKE', "%{$search}%")
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no', 'asc')
                ->get();

            $totalFiltered = FdrWithdraw::join('users', 'users.id', '=', 'fdr_withdraws.user_id')
                ->join('users as creator', 'creator.id', '=', 'fdr_withdraws.created_by')
                ->select('fdr_withdraws.*', 'users.name as name', 'creator.name as created_by')
                ->where('fdr_withdraws.account_no', 'LIKE', "%{$search}%")
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $fdrDeposit = FdrDeposit::find($post->fdr_deposit_id);
                $show       = route('fdr-withdraws.show', $post->id);
                $edit       = route('fdr-withdraws.edit', $post->id);

                $commencement             = new Carbon($post->commencement);
                $nestedData['id']         = $post->id;
                $nestedData['user_id']    = $post->user_id;
                $nestedData['phone']      = $post->phone1 ?? '';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name']       = $post->name;
                $nestedData['package']    = $fdrDeposit->fdrPackage->name;
                $nestedData['created_by'] = $post->created_by;
                $nestedData['amount']     = $post->amount;
                $nestedData['date']       = $post->date;
                $nestedData['balance']    = $post->balance;
                $data[]                   = $nestedData;

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
        $this->authorize('create', FdrWithdraw::class);

        $users       = User::pluck('name', 'id');
        $fdrs        = Fdr::pluck('account_no', 'id');
        $fdrDeposits = FdrDeposit::pluck('account_no', 'id');

        return view(
            'app.fdr_withdraws.create',
            compact('users', 'fdrs', 'fdrDeposits', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrWithdrawStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', FdrWithdraw::class);

        $data               = $request->all();
        $fdr                = Fdr::find($request->fdr_id);
        $data['account_no'] = $fdr->account_no;
        $data['user_id']    = $fdr->user_id;
        $data['trx_id']    = $this->trxId();
        $data['created_by'] = Auth::id();

        $fdr->balance -= $request->amount;
        $fdr->save();
        $fdrDeposit          = FdrDeposit::find($request->fdr_deposit_id);
        $fdrDeposit->balance -= $request->amount;
        $fdrDeposit->save();
        $data['balance'] = $fdrDeposit->balance;
        $fdrWithdraw     = FdrWithdraw::create($data);

        $cashout = Cashout::create([
            'cashout_category_id' => 5,
            'account_no'          => $fdrWithdraw->account_no,
            'fdr_withdraw_id'     => $fdrWithdraw->id,
            'fdr_deposit_id'      => $fdrWithdraw->fdr_deposit_id,
            'amount'              => $fdrWithdraw->amount,
            'date'                => $fdrWithdraw->date,
            'created_by'          => $fdrWithdraw->created_by,
            'user_id'             => $fdrWithdraw->user_id,
            'trx_id' => $fdrWithdraw->trx_id
        ]);
        $data['name'] = $fdr->user->name;
        $data['trx_type'] = 'cash';
        FdrWithdrawAccount::create($data);
        //$transaction = $this->accountTransaction($fdrWithdraw);

        return "success";

        /*return redirect()
            ->route('fdr-withdraws.edit', $fdrWithdraw)
            ->withSuccess(__('crud.common.created'));*/
    }
    public function trxId()
    {
        $record = Transaction::latest()->first();
        $dateTime = Carbon::now('Asia/Dhaka');

        if ($record) {

            $expNum = explode('-', $record->trx_id);

            if ($dateTime->format('jny') == $expNum[1]) {
                $s = str_pad($expNum[2] + 1, 4, "0", STR_PAD_LEFT);
                $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $s;
            } else {
                //increase 1 with last invoice number
                $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-0001';
            }
        } else {

            $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-0001';

        }

        return $nextTxNumber;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrWithdraw $fdrWithdraw)
    {
        $this->authorize('view', $fdrWithdraw);

        return view('app.fdr_withdraws.show', compact('fdrWithdraw'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrWithdraw $fdrWithdraw)
    {
        $this->authorize('update', $fdrWithdraw);

        $users       = User::pluck('name', 'id');
        $fdrs        = Fdr::pluck('account_no', 'id');
        $fdrDeposits = FdrDeposit::pluck('account_no', 'id');

        return view(
            'app.fdr_withdraws.edit',
            compact('fdrWithdraw', 'users', 'fdrs', 'fdrDeposits', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrWithdrawUpdateRequest $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrWithdrawUpdateRequest $request,
        FdrWithdraw              $fdrWithdraw
    )
    {
        $this->authorize('update', $fdrWithdraw);

        $validated = $request->validated();

        $fdrWithdraw->update($validated);

        return redirect()
            ->route('fdr-withdraws.edit', $fdrWithdraw)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fdrWithdraw = FdrWithdraw::find($id);
        //$this->authorize('delete', $fdrWithdraw);

        $fdrDeposit = FdrDeposit::find($fdrWithdraw->fdr_deposit_id);
        $fdrDeposit->balance += $fdrWithdraw->amount;
        $fdrDeposit->save();

        $fdr          = Fdr::find($fdrWithdraw->fdr_id);
        $fdr->balance += $fdrWithdraw->amount;
        $fdr->save();

        FdrWithdrawAccount::delete($fdrWithdraw->trx_id);
        /*$withdrawAccount = Account::find(16);
        $withdrawAccount->balance -= $fdrWithdraw->amount;
        $withdrawAccount->save();*/

        //Transaction::where('trx_id',$fdrWithdraw->trx_id)->delete();

        /*$depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
        $depositAccount->balance += $fdrWithdraw->amount;
        $depositAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance += $fdrWithdraw->amount;
        $cashAccount->save();

        $fdr_deposit          = FdrDeposit::find($fdrWithdraw->fdr_deposit_id);
        $fdr_deposit->balance += $fdrWithdraw->amount;
        $fdr_deposit->save();*/
        Cashout::where('fdr_withdraw_id',$id)->delete();
        $fdrWithdraw->delete();

        /*return redirect()
            ->route('fdr-withdraws.index')
            ->withSuccess(__('crud.common.removed'));*/
    }

    public function accountTransaction(FdrWithdraw $withdraw)
    {
        $transaction = Transaction::create([
               'account_id' => 16,
               'description' => 'FDR withdraw',
               'trx_id' => $withdraw->trx_id,
               'date' => $withdraw->date,
               'amount' => $withdraw->amount,
               'user_id' => $withdraw->created_by,
               'account_no' => $withdraw->account_no,
               'name' => $withdraw->user->name
           ]);
        $withdrawAccount = Account::find(16); //LIABILITY (DEPOSIT -)
        $withdrawAccount->balance += $transaction->amount;
        $withdrawAccount->save();

        $depositAccount = Account::find(1); //LIABILITY (DEPOSIT -)
        $depositAccount->balance -= $transaction->amount;
        $depositAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH-)
        $cashAccount->balance -= $transaction->amount;
        $cashAccount->save();
    }
}
