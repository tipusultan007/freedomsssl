<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\DpsWithdrawAccount;
use App\Http\Controllers\Accounts\FdrWithdrawAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\PaidProfitAccount;
use App\Http\Controllers\Accounts\ServiceChargeAccount;
use App\Http\Controllers\Accounts\SpecialWithdrawAccount;
use App\Models\Cashout;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\User;
use App\Models\SpecialDps;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\ClosingAccount;
use App\Http\Requests\ClosingAccountStoreRequest;
use App\Http\Requests\ClosingAccountUpdateRequest;

class ClosingAccountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.closing_accounts.index');
    }

    public function allClosings(Request $request)
    {
        $totalData = ClosingAccount::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        //$dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = ClosingAccount::join('users','closing_accounts.user_id','=','users.id')
                ->select('closing_accounts.*','users.name as name')
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  ClosingAccount::join('users','closing_accounts.user_id','=','users.id')
                ->where('closing_accounts.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('closing_accounts.account_no','asc')
                ->get();

            $totalFiltered = ClosingAccount::join('users','closing_accounts.user_id','=','users.id')
                ->where('closing_accounts.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('closing-accounts.show',$post->id);
                $edit =  route('closing-accounts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['service_charge'] = $post->service_charge;
                $nestedData['date'] = date('d M Y',strtotime($post->date));
                $nestedData['withdraw'] = $post->withdraw;
                $nestedData['profit'] = $post->profit;
                $nestedData['total'] = $post->total;
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
        //$this->authorize('create', ClosingAccount::class);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $allSpecialDps = SpecialDps::pluck('account_no', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.closing_accounts.create',
            compact(
                'users',
                'users',
                'allDailySavings',
                'allDps',
                'allSpecialDps',
                'fdrs'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ClosingAccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////$this->authorize('create', ClosingAccount::class);

        //$validated = $request->validated();
        $data = $request->all();
        $data['trx_id'] = TransactionController::trxId();
        $data['trx_type'] = 'cash';
        if (array_key_exists('daily_savings_id',$data)) {
            $savings = DailySavings::find($data['daily_savings_id']);
            $closingAccount = ClosingAccount::create($data);
            $data['name'] = $closingAccount->user->name;
            $data['profit_type'] = 'daily';
            DailyWithdrawAccount::create($data);
            if ($data['profit'] >0) {
                PaidProfitAccount::create($data);
            }
            if ($data['service_charge']>0)
            {
                ServiceChargeAccount::create($data);
            }
            $savings->status = 'closed';
            $savings->save();

            $data['description'] = 'Daily Savings Closing';

        }elseif (array_key_exists('dps_id',$data)) {
            $savings = Dps::find($data['dps_id']);
            $closingAccount = ClosingAccount::create($data);
            $data['name'] = $closingAccount->user->name;
            $data['profit_type'] = 'dps';
            DailyWithdrawAccount::create($data);
            if ($data['profit'] >0) {
                PaidProfitAccount::create($data);
            }
            if ($data['service_charge']>0)
            {
                ServiceChargeAccount::create($data);
            }
            $savings->status = 'closed';
            $savings->save();

            $data['description'] = 'DPS Closing';

        }elseif (array_key_exists('special_dps_id',$data)) {
            $savings = SpecialDps::find($data['special_dps_id']);
            $closingAccount = ClosingAccount::create($data);
            $data['name'] = $closingAccount->user->name;
            $data['profit_type'] = 'special';
            DailyWithdrawAccount::create($data);
            if ($data['profit'] >0) {
                PaidProfitAccount::create($data);
            }
            if ($data['service_charge']>0)
            {
                ServiceChargeAccount::create($data);
            }
            $savings->status = 'closed';
            $savings->save();

            $data['description'] = 'Special DPS Closing';

        }elseif(array_key_exists('fdr_id',$data)) {
            $savings = Fdr::find($data['fdr_id']);
            $closingAccount = ClosingAccount::create($data);
            $data['name'] = $closingAccount->user->name;
            $data['profit_type'] = 'fdr';
            DailyWithdrawAccount::create($data);
            if ($data['profit'] >0) {
                PaidProfitAccount::create($data);
            }
            if ($data['service_charge']>0)
            {
                ServiceChargeAccount::create($data);
            }
            $savings->status = 'closed';
            $savings->save();

            $data['description'] = 'FDR Closing';
        }

        $cashout = Cashout::create([
            'cashout_category_id' => 9,
            'account_no' => $closingAccount->account_no,
            'closing_id' => $closingAccount->id,
            'description' => $data['description'],
            'amount' => $closingAccount->total,
            'date' => $closingAccount->date,
            'created_by' => $closingAccount->created_by,
            'user_id' => $closingAccount->user_id,
            'trx_id' => $closingAccount->trx_id,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingAccount $closingAccount)
    {
        //$this->authorize('view', $closingAccount);

        return view('app.closing_accounts.show', compact('closingAccount'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ClosingAccount $closingAccount)
    {
        //$this->authorize('update', $closingAccount);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $allSpecialDps = SpecialDps::pluck('account_no', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.closing_accounts.edit',
            compact(
                'closingAccount',
                'users',
                'users',
                'allDailySavings',
                'allDps',
                'allSpecialDps',
                'fdrs'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ClosingAccountUpdateRequest $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $closing = ClosingAccount::find($id);
        if ($closing->daily_savings_id !="") {
            $savings = DailySavings::find($closing->daily_savings_id);
            $savings->status = 'active';
            $savings->save();
            DailyWithdrawAccount::delete($closing->trx_id);
            PaidProfitAccount::delete($closing->trx_id,'daily');
            ServiceChargeAccount::delete($closing->trx_id);
        }elseif ($closing->dps_id !="") {
            $savings = Dps::find($closing->dps_id);
            $savings->status = 'active';
            $savings->save();
            DpsWithdrawAccount::delete($closing->trx_id);
            PaidProfitAccount::delete($closing->trx_id,'dps');
            ServiceChargeAccount::delete($closing->trx_id);
        }elseif ($closing->special_dps_id !="") {
            $savings = SpecialDps::find($closing->special_dps_id);
            $savings->status = 'active';
            $savings->save();
            SpecialWithdrawAccount::delete($closing->trx_id);
            PaidProfitAccount::delete($closing->trx_id,'special');
            ServiceChargeAccount::delete($closing->trx_id);
        }elseif ($closing->fdr_id !="") {
            $savings = Fdr::find($closing->fdr_id);
            $savings->status = 'active';
            $savings->save();
            FdrWithdrawAccount::delete($closing->trx_id);
            PaidProfitAccount::delete($closing->trx_id,'fdr');
            ServiceChargeAccount::delete($closing->trx_id);
        }
        Cashout::where('closing_id',$closing->id)->delete();
        $closing->delete();
    }
}
