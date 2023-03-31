<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AddProfit;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DailySavingsClosing;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\LoanDocuments;
use App\Models\Nominees;
use App\Models\SavingsCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Requests\DailySavingsStoreRequest;
use App\Http\Requests\DailySavingsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailySavingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailySavings::class);
        $savings = DailySavings::all();
        $breadcrumbs = [
            ['name' => "List"]
        ];
        return view(
            'app.all_daily_savings.index',compact('breadcrumbs')
        );
    }

    public function dailySavingsData(Request $request)
    {
       /* $columns = array(
            0 =>'account_no',
            1=> 'name',
            2=> 'date',
            3=> 'deposit',
            4=> 'withdraw',
            5=> 'profit',
            6=> 'total',
            7=> 'status'
        );*/

        $totalData = DailySavings::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        //$dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = DailySavings::with('user')->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  DailySavings::with('user')
                ->join('users','daily_savings.user_id','=','users.id')
                ->where('daily_savings.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no','asc')
                ->get();

            $totalFiltered = DailySavings::with('user')
                ->join('users','daily_savings.user_id','=','users.id')
                ->where('daily_savings.account_no', 'LIKE',"%{$search}%")
                ->orWhere('users.name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('daily-savings.show',$post->id);
                $edit =  route('daily-savings.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->user->name;
                $nestedData['phone'] = $post->user->phone1;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['date'] = $post->opening_date;
                $nestedData['withdraw'] = $post->withdraw;
                $nestedData['profit'] = $post->profit;
                $nestedData['total'] = $post->total;
                $nestedData['status'] = $post->status;
                $nestedData['profile_photo_url'] = $post->user->profile_photo_path;
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
        $this->authorize('create', DailySavings::class);

        $users = User::all();

        return view(
            'app.all_daily_savings.create',
            compact('users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DailySavings::class);

       // $validated = $request->validated();

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['account_no'] = 'DS'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $dailySavings = DailySavings::create($data);
        $data['user_id'] = $request->nominee_account;
        $nominee = Nominees::create($data);

        $info = DailySavings::with('user')->find($dailySavings->id);
        $data['name'] = $info->user->name;
        $data['account_no'] = $info->account_no;
        $data['opening_date'] = $info->opening_date;
        $data['deposit'] = $info->deposit;
        $data['withdraw'] = $info->withdraw;
        $data['profit'] = $info->profit;
        $data['total'] = $info->total;
        $data['status'] = $info->status;
        $data['id'] = $info->id;
       /* return redirect()
            ->route('all-daily-savings.edit', $dailySavings)
            ->withSuccess(__('crud.common.created'));*/
        echo json_encode($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dailySavings = DailySavings::find($id);
        $this->authorize('view', $dailySavings);

        $breadcrumbs = [
            ['link' => "/daily-savings", 'name' => "Daily Savings"], ['link' =>"javascript:void(0)" ,'name' => "Details"],['name' => $dailySavings->account_no]
        ];

        return view('app.all_daily_savings.show', compact('dailySavings','breadcrumbs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('update', $dailySavings);

        $users = User::pluck('name', 'id');

        return view(
            'app.all_daily_savings.edit',
            compact('dailySavings', 'users', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsUpdateRequest $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySavingsUpdateRequest $request,
        DailySavings $dailySavings
    ) {
        $this->authorize('update', $dailySavings);

        $validated = $request->validated();

        $dailySavings->update($validated);

        return redirect()
            ->route('all-daily-savings.edit', $dailySavings)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // $this->authorize('delete', $dailySavings);

        $dailySavings = DailySavings::find($id);

        $withdrawAccount = Account::find(16);
        $depositAccount = Account::find(1);
        $cashAccount = Account::find(4);
        $loanProvideAccount = Account::find(2);
        $loanPaymentAccount = Account::find(13);
        $interestPaidAccount = Account::find(7);
        $loan = DailyLoan::where('account_no',$dailySavings->account_no)->where('status','active')->first();
        if ($loan) {
            $balance = $loan->balance;
            $paid = $loan->loan_amount + $loan->interest - $loan->balance;
            if ($paid >= $loan->interest) {
                $interestPaidAccount->balance -= $loan->interest;
                $interestPaidAccount->save();

                $cashAccount->balance = $loan->interest;
                $cashAccount->save();

                $cashAccount->balance += $loan->loan_amount - $paid;
                $cashAccount->save();

                $loanProvideAccount->balance -= $loan->loan_amount - $paid;
                $loanProvideAccount->save();
            }

            $loanPayment = ($loan->total - $loan->balance) - $loan->interest;
            if ($loanPayment > 0) {
                $loanPaymentAccount->balance -= ($loan->total - $loan->balance) - $loan->interest;
                $loanPaymentAccount->save();
            }
        }

        $withdrawAccount->balance -= $dailySavings->withdraw;
        $withdrawAccount->save();

        $depositAccount->balance -= $dailySavings->total;
        $depositAccount->save();

        $cashAccount->balance -= $dailySavings->total;
        $cashAccount->save();

        DailyLoan::where('account_no',$dailySavings->account_no)->delete();
        Nominees::where('account_no',$dailySavings->account_no)->delete();
        LoanDocuments::where('account_no',$dailySavings->account_no)->delete();
        AddProfit::where('account_no',$dailySavings->account_no)->delete();
        SavingsCollection::where('account_no',$dailySavings->account_no)->delete();
        DailyLoanCollection::where('account_no',$dailySavings->account_no)->delete();
        DailySavingsClosing::where('account_no',$dailySavings->account_no)->delete();
        DailyCollection::where('account_no',$dailySavings->account_no)->delete();
        CashIn::where('account_no',$dailySavings->account_no)->delete();
        Cashout::where('account_no',$dailySavings->account_no)->delete();
        Transaction::where('account_no',$dailySavings->account_no)->delete();
        $dailySavings->delete();
        echo "success";
    }

    public function savingsInfoByAccount($account)
    {
        $daily_savings = DailySavings::where('account_no',$account)->first();
        $user = User::find($daily_savings->user_id);
        $dps = Dps::where('user_id',$user->id)->count();
        $daily_savings = DailySavings::where('user_id',$user->id)->count();
        $special_dps = SpecialDps::where('user_id',$user->id)->count();
        $daily_loans = DailyLoan::where('user_id',$user->id)->count();
        $dps_loans = DpsLoan::where('user_id',$user->id)->count();
        $special_dps_loans = SpecialDpsLoan::where('user_id',$user->id)->count();

        $data['user'] = $user;
        $data['dps'] = $dps;
        $data['daily_savings'] = $daily_savings;
        $data['special_dps'] = $special_dps;
        $data['daily_loans'] = $daily_loans;
        $data['dps_loans'] = $dps_loans;
        $data['special_dps_loans'] = $special_dps_loans;
        return json_encode($data);
    }

    public function isSavingsExist($ac)
    {
        $savings = DailySavings::where('account_no',$ac)->count();

        if ($savings>0)
        {
            return "yes";
        }else{
            return "no";
        }
    }

    public function reset($id)
    {
        $savings = DailySavings::find($id);
        Transaction::where('account_no',$savings->account_no)->delete();

        $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
        $depositAccount->balance -= $savings->deposit;
        $depositAccount->save();

        $depositAccount->balance += $savings->withdraw;
        $depositAccount->save();

        $cashAccount = Account::find(4); //ASSET (CASH+)
        $cashAccount->balance -= $savings->deposit;
        $cashAccount->save();
        $cashAccount->balance += $savings->withdraw;
        $cashAccount->save();

        $withdrawAccount = Account::find(16); //LIABILITY (DEPOSIT -)
        $withdrawAccount->balance -= $savings->withdraw;
        $withdrawAccount->save();

        $savings->deposit = 0;
        $savings->withdraw = 0;
        $savings->profit = 0;
        $savings->total = 0;
        $savings->save();

    }
}
