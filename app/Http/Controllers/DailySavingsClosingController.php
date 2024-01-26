<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\PaidProfitAccount;
use App\Http\Controllers\Accounts\ServiceChargeAccount;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\SavingsCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\DailySavingsClosing;
use App\Http\Requests\DailySavingsClosingStoreRequest;
use App\Http\Requests\DailySavingsClosingUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DailySavingsClosingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', DailySavingsClosing::class);

        $search = $request->get('search', '');

        $dailySavingsClosings = DailySavingsClosing::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.daily_savings_closings.index',
            compact('dailySavingsClosings', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', DailySavingsClosing::class);

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.daily_savings_closings.create',
            compact('allDailySavings', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////$this->authorize('create', DailySavingsClosing::class);

        $data = $request->all();
        $dailySavings = DailySavings::find($data['daily_savings_id']);
        $data['trx_id'] = Str::uuid();
        $data['trx_type'] = 'cash';
        $data['name'] = $dailySavings->user->name;
        $data['profit_type'] = 'daily';
        //$data['saving_amount'] = $data['deposit'];
        $data['manager_id'] = Auth::id();
        $data['collector_id'] = Auth::id();
        DailyWithdrawAccount::create($data);
        $dailyCollection = DailyCollection::create($data);

        $savingsCollection = SavingsCollection::create([
            'account_no' => $dailyCollection->account_no,
            'daily_savings_id' => $dailyCollection->daily_savings_id,
            'saving_amount' => $dailyCollection->saving_amount,
            'type' => $dailyCollection->saving_type,
            'collector_id' => $dailyCollection->collector_id,
            'date' => $dailyCollection->date,
            'balance' => 0,
            'user_id' => $dailyCollection->user_id,
            'collection_id' => $dailyCollection->id,
            'manager_id' => $dailyCollection->manager_id,
            'trx_id' => $dailyCollection->trx_id,
        ]);

        $dailySavings->withdraw += $dailyCollection->saving_amount;
        $dailySavings->total = 0;
        $dailySavings->save();

        $cashout = Cashout::create([
            'cashout_category_id' => 2,
            'account_no' => $dailyCollection->account_no,
            'daily_collection_id' => $dailyCollection->id,
            'amount' => $dailyCollection->saving_amount,
            'date' => $dailyCollection->date,
            'manager_id' => $dailyCollection->manager_id,
            'user_id' => $dailyCollection->user_id,
            'trx_id' => $dailyCollection->trx_id,
        ]);
        if ($data['profit'] >0) {
            PaidProfitAccount::create($data);
        }
        if ($data['service_charge']>0)
        {
            ServiceChargeAccount::create($data);
        }
        if (array_key_exists('loan_installment',$data))
        {
            $dailyLoan = DailyLoan::find($data['daily_loan_id']);
            $dailyLoan->balance -= $data['loan_installment'];
            $dailyLoan->grace= $data['grace'];
            $dailyLoan->save();

            $dailyCollection->loan_balance = $dailyLoan->balance;
            $dailyCollection->save();

            $data['loan_installment'] = $data['loan'];
            $data['grace'] = $data['grace'];
            $data['loan_balance'] = $dailyLoan->balance;
            $data['daily_loan_id'] = $dailyLoan->id;
            $data['user_id'] = $dailySavings->user_id;

            if ($data['grace']>0)
            {
                GraceAccount::create($data);
            }

           // $dailyCollection = DailyCollection::create($data);

            $loanCollection = DailyLoanCollection::create([
                'account_no' => $dailyCollection->account_no,
                'daily_loan_id' => $dailyCollection->daily_loan_id,
                'loan_installment' => $dailyCollection->loan_installment,
                'loan_balance' => $dailyLoan->balance,
                'collector_id' => $dailyCollection->manager_id,
                'manager_id' => $dailyCollection->manager_id,
                'date' => $dailyCollection->date,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'trx_id' => $dailyCollection->trx_id,
            ]);

            $cashin = CashIn::create([
                'user_id' => $dailyCollection->user_id,
                'cashin_category_id' => 4,
                'account_no' => $dailyCollection->account_no,
                'daily_collection_id' => $dailyCollection->id,
                'amount' => $dailyCollection->loan_installment - $dailyCollection->grace,
                'date' => $dailyCollection->date,
                'manager_id' => $dailyCollection->manager_id,
                'trx_id' => $dailyCollection->trx_id,
            ]);

            $loan = DailyLoan::find($dailyCollection->daily_loan_id);
            $interest = $loan->interest;
            $paidInterest = $loan->paid_interest;
            $data['trx_type'] = 'cash';
            $data['interest_type'] = 'daily';
            $data['name'] = $loan->user->name;
            if ($paidInterest<$interest)
            {
                $remain = $interest-$paidInterest;
                if ($remain < $dailyCollection->loan_installment)
                {
                    $data['interest'] = $remain;
                    $loan->paid_interest += $remain;
                    $loan->save();
                    //PaidInterestAccount::create($data);
                    $data['loan_installment'] = $dailyCollection->loan_installment - $remain;
                    //DailyLoanPaymentAccount::create($data);
                }else{
                    $data['interest'] = $dailyCollection->loan_installment;
                    $loan->paid_interest += $dailyCollection->loan_installment;
                    $loan->save();
                    //PaidInterestAccount::create($data);
                }
            }else{
                //DailyLoanPaymentAccount::create($data);
            }

            $dailyLoan->status = 'closed';
            $dailyLoan->save();
        }

        //dd($data);

        $dailySavingsClosing = DailySavingsClosing::create($data);
        $dailySavings->status = 'closed';
        $dailySavings->save();


        return redirect()->back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        //$this->authorize('view', $dailySavingsClosing);

        return view(
            'app.daily_savings_closings.show',
            compact('dailySavingsClosing')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        //$this->authorize('update', $dailySavingsClosing);

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.daily_savings_closings.edit',
            compact('dailySavingsClosing', 'allDailySavings', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingUpdateRequest $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySavingsClosingUpdateRequest $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        //$this->authorize('update', $dailySavingsClosing);

        $validated = $request->validated();

        $dailySavingsClosing->update($validated);

        return redirect()
            ->route('daily-savings-closings.edit', $dailySavingsClosing)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $closing = DailySavingsClosing::find($id);
        $savings = DailySavings::find($closing->daily_savings_id);
        $savings->withdraw -= $closing->payable;
        $savings->total = $closing->deposit;
        $savings->status = "active";
        $savings->save();
        Cashout::where('trx_id',$closing->trx_id)->delete();
        DailyWithdrawAccount::delete($closing->trx_id);
        PaidProfitAccount::delete($closing->trx_id,'daily');
        ServiceChargeAccount::delete($closing->trx_id);
        $collection = DailyCollection::where('trx_id',$closing->trx_id)->delete();
        SavingsCollection::where('trx_id',$closing->trx_id)->delete();
        if ($closing->daily_loan_id !="")
        {
            $loan = DailyLoan::find($closing->daily_loan_id);
            $loan->balance += $closing->loan;
            $loan->grace = $closing->loan;
            $loan->status = "active";
            $loan->save();

            DailyLoanCollection::where('trx_id',$closing->trx_id)->delete();

            CashIn::where('trx_id',$closing->trx_id)->delete();
            DailyLoanPaymentAccount::delete($closing->trx_id);
            PaidInterestAccount::delete($closing->trx_id,'cash');
            GraceAccount::delete($closing->trx_id);
        }
        $closing->delete();
    }
}
