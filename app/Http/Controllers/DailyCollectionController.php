<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\CashAccount;
use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\SavingsAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyLoanCollection;
use App\Models\SavingsCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\DailyCollection;
use App\Http\Requests\DailyCollectionStoreRequest;
use App\Http\Requests\DailyCollectionUpdateRequest;

class DailyCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyCollection::class);

        return view('app.daily_collections.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DailyCollection::class);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $dailyLoans = DailyLoan::pluck('opening_date', 'id');

        return view(
            'app.daily_collections.create',
            compact('users', 'users', 'allDailySavings', 'dailyLoans')
        );
    }

    /**
     * @param \App\Http\Requests\DailyCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DailyCollection::class);

        //$validated = $request->validated();
        $late_fee = $request->late_fee != "" ? $request->late_fee : 0;
        $other_fee = $request->other_fee != "" ? $request->other_fee : 0;
        $loan_late_fee = $request->loan_late_fee != "" ? $request->loan_late_fee : 0;
        $loan_other_fee = $request->loan_other_fee != "" ? $request->loan_other_fee : 0;

        $data = $request->all();
        $data['trx_id'] = TransactionController::trxId();
        //$data['user_id'] = $request->created_by;
        $dailyCollection = DailyCollection::create($data);
        if ($dailyCollection->saving_amount > 0) {
            $dailySavings = DailySavings::find($dailyCollection->daily_savings_id);
            if ($dailyCollection->saving_type == 'deposit') {
                $dailySavings->deposit += $dailyCollection->saving_amount;
                $dailySavings->total += $dailyCollection->saving_amount;
                $dailySavings->save();

                $cashin = CashIn::create([
                    'user_id' => $dailyCollection->user_id,
                    'cashin_category_id' => 3,
                    'account_no' => $dailyCollection->account_no,
                    'daily_collection_id' => $dailyCollection->id,
                    'amount' => $dailyCollection->saving_amount + $late_fee + $other_fee,
                    'date' => $dailyCollection->date,
                    'created_by' => $dailyCollection->created_by,
                    'trx_id' => $dailyCollection->trx_id,
                ]);
            } elseif ($dailyCollection->saving_type == 'withdraw') {
                $dailySavings->withdraw += $dailyCollection->saving_amount;
                $dailySavings->total -= $dailyCollection->saving_amount;
                $dailySavings->save();

                $cashout = Cashout::create([
                    'cashout_category_id' => 2,
                    'account_no' => $dailyCollection->account_no,
                    'daily_collection_id' => $dailyCollection->id,
                    'amount' => $dailyCollection->saving_amount - ($late_fee + $other_fee),
                    'date' => $dailyCollection->date,
                    'created_by' => $dailyCollection->created_by,
                    'user_id' => $dailyCollection->user_id,
                    'trx_id' => $dailyCollection->trx_id,
                ]);

            }
            $savingsCollection = SavingsCollection::create([
                'account_no' => $dailyCollection->account_no,
                'daily_savings_id' => $dailyCollection->daily_savings_id,
                'saving_amount' => $dailyCollection->saving_amount,
                'type' => $dailyCollection->saving_type,
                'collector_id' => $dailyCollection->collector_id,
                'date' => $dailyCollection->date,
                'late_fee' => $dailyCollection->late_fee,
                'other_fee' => $dailyCollection->other_fee,
                'balance' => $dailySavings->total,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'created_by' => $dailyCollection->created_by,
                'trx_id' => $dailyCollection->trx_id,
            ]);

            $dailyCollection->savings_balance = $dailySavings->total;
            $dailyCollection->save();

        }
        if ($dailyCollection->loan_installment > 0) {
            $dailyLoan = DailyLoan::find($dailyCollection->daily_loan_id);
            $dailyLoan->balance -= $dailyCollection->loan_installment;
            $dailyLoan->save();

            $loanCollection = DailyLoanCollection::create([
                'account_no' => $dailyCollection->account_no,
                'daily_loan_id' => $dailyCollection->daily_loan_id,
                'loan_installment' => $dailyCollection->loan_installment,
                'installment_no' => $request->installment_no,
                'loan_late_fee' => $dailyCollection->loan_late_fee,
                'loan_other_fee' => $dailyCollection->loan_other_fee,
                'loan_note' => $dailyCollection->loan_note,
                'loan_balance' => $dailyLoan->balance,
                'collector_id' => $dailyCollection->collector_id,
                'date' => $dailyCollection->date,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'created_by' => $dailyCollection->created_by,
                'trx_id' => $dailyCollection->trx_id,
            ]);


            $dailyCollection->loan_balance = $dailyLoan->balance;
            $dailyCollection->save();

            $cashin = CashIn::create([
                'user_id' => $dailyCollection->user_id,
                'cashin_category_id' => 4,
                'account_no' => $dailyCollection->account_no,
                'daily_collection_id' => $dailyCollection->id,
                'amount' => $dailyCollection->loan_installment + $loan_late_fee + $loan_other_fee,
                'date' => $dailyCollection->date,
                'created_by' => $dailyCollection->created_by,
                'trx_id' => $dailyCollection->trx_id,
            ]);

        }


        $transaction = $this->savingsTransaction($dailyCollection);
        echo "Success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyCollection $dailyCollection)
    {
        $this->authorize('view', $dailyCollection);

        return view('app.daily_collections.show', compact('dailyCollection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailyCollection $dailyCollection)
    {
        $this->authorize('update', $dailyCollection);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $dailyLoans = DailyLoan::pluck('opening_date', 'id');

        return view(
            'app.daily_collections.edit',
            compact(
                'dailyCollection',
                'users',
                'users',
                'allDailySavings',
                'dailyLoans'
            )
        );
    }

    /**
     * @param \App\Http\Requests\DailyCollectionUpdateRequest $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyCollectionUpdateRequest $request,
        DailyCollection              $dailyCollection
    )
    {
        $this->authorize('update', $dailyCollection);

        $validated = $request->validated();

        $dailyCollection->update($validated);

        return redirect()
            ->route('daily-collections.edit', $dailyCollection)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DailyCollection $dailyCollection)
    {
        $this->authorize('delete', $dailyCollection);

        $dailyCollection->delete();

        return redirect()
            ->route('daily-collections.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function dataByAccount($account)
    {
        $savings = DailySavings::with('user')->where('status', 'active')->where('account_no', $account)->first();
        $loan = DailyLoan::where('status', 'active')->where('account_no', $account)->latest()->first();
        $data['savings'] = $savings;
        $data['loans'] = $loan;

        return json_encode($data);
    }

    public function savingsTransactionBackup(DailyCollection $collection)
    {
        if ($collection->saving_type == 'deposit') {
            $transaction = Transaction::create([
                'account_id' => 1,
                'description' => 'Daily Savings deposit',
                'trx_id' => $collection->trx_id,
                'date' => $collection->date,
                'amount' => $collection->saving_amount,
                'user_id' => $collection->created_by,
                'account_no' => $collection->account_no,
                'name' => $collection->user->name
            ]);

            $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
            $depositAccount->balance += $transaction->amount;
            $depositAccount->save();

            $cashAccount = Account::find(4); //ASSET (CASH+)
            $cashAccount->balance += $transaction->amount;
            $cashAccount->save();
        }
        if ($collection->saving_type == 'withdraw') {
            $transaction = Transaction::create([
                'account_id' => 16,
                'description' => 'Daily Savings withdraw',
                'trx_id' => $collection->trx_id,
                'date' => $collection->date,
                'amount' => $collection->saving_amount,
                'user_id' => $collection->created_by,
                'account_no' => $collection->account_no,
                'name' => $collection->user->name
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
        if ($collection->loan_installment > 0) {
            $loan = DailyLoan::find($collection->daily_loan_id);
            $interest = $loan->interest;
            $paidInstallment = DailyLoanCollection::where('daily_loan_id', $collection->daily_loan_id)->sum('loan_installment') - $collection->loan_installment;
            if ($interest > $paidInstallment) {
                $transaction = Transaction::create([
                    'account_id' => 7,
                    'description' => 'Daily Loan Interest',
                    'trx_id' => $collection->trx_id,
                    'date' => $collection->date,
                    'amount' => $collection->loan_installment,
                    'user_id' => $collection->created_by,
                    'account_no' => $collection->account_no,
                    'name' => $collection->user->name,
                ]);

                $interestAccount = Account::find(7); //INCOME (LOAN INTEREST PAID+)
                $interestAccount->balance += $transaction->amount;
                $interestAccount->save();

                $cashAccount = Account::find(4); //ASSET (CASH+)
                $cashAccount->balance += $transaction->amount;
                $cashAccount->save();

                $unpaidInterestAccount = Account::find(8); //INCOME (LOAN INTEREST UNPAID-)
                $unpaidInterestAccount->balance -= $transaction->amount;
                $unpaidInterestAccount->save();

                $unpaidInterestAccount1 = Account::find(5); //ASSET (LOAN INTEREST UNPAID-)
                $unpaidInterestAccount1->balance -= $transaction->amount;
                $unpaidInterestAccount1->save();

            } elseif ($interest <= $paidInstallment) {
                $transaction = Transaction::create([
                    'account_id' => 13,
                    'description' => 'Daily Loan Payment',
                    'trx_id' => $collection->trx_id,
                    'date' => $collection->date,
                    'amount' => $collection->loan_installment,
                    'user_id' => $collection->created_by,
                    'account_no' => $collection->account_no,
                    'name' => $collection->user->name,
                ]);

                $interestAccount = Account::find(13); //LOAN PAYMENT+
                $interestAccount->balance += $transaction->amount;
                $interestAccount->save();

                $cashAccount = Account::find(4); //ASSET (CASH+)
                $cashAccount->balance += $transaction->amount;
                $cashAccount->save();

                $loanProvidetAccount = Account::find(2); //ASSET (LOAN PROVIDE-)
                $loanProvidetAccount->balance -= $transaction->amount;
                $loanProvidetAccount->save();
            }
        }
    }

    public function savingsTransaction(DailyCollection $collection)
    {
        $data = array();
        $data = $collection;
        $data['name'] = $collection->user->name;
        $data['trx_type'] = 'cash';
        if ($collection->saving_type == 'deposit') {
            SavingsAccount::create($data);
            /* $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
             $depositAccount->balance += $transaction->amount;
             $depositAccount->save();

             $cashAccount = Account::find(4); //ASSET (CASH+)
             $cashAccount->balance += $transaction->amount;
             $cashAccount->save();*/
        }
        if ($collection->saving_type == 'withdraw') {
            DailyWithdrawAccount::create($data);
            /*$transaction = Transaction::create([
                   'account_id' => 16,
                   'description' => 'Daily Savings withdraw',
                   'trx_id' => $collection->trx_id,
                   'date' => $collection->date,
                   'amount' => $collection->saving_amount,
                   'user_id' => $collection->created_by,
                   'account_no' => $collection->account_no,
                   'name' => $collection->user->name
               ]);

            $withdrawAccount = Account::find(16); //LIABILITY (DEPOSIT -)
            $withdrawAccount->balance += $transaction->amount;
            $withdrawAccount->save();

            $depositAccount = Account::find(1); //LIABILITY (DEPOSIT -)
            $depositAccount->balance -= $transaction->amount;
            $depositAccount->save();

            $cashAccount = Account::find(4); //ASSET (CASH-)
            $cashAccount->balance -= $transaction->amount;
            $cashAccount->save();*/
        }

        if ($collection->late_fee > 0) {
            $data['collector_id'] = $collection->created_by;
            LateFeeAccount::create($data);
        }
        if ($collection->other_fee > 0) {
            {
                $data['collector_id'] = $collection->created_by;
                OtherFeeAccount::create($data);
            }
        }

        if ($collection->loan_installment > 0)
        {
            $loan = DailyLoan::find($collection->daily_loan_id);
            $interest = $loan->interest;
            $paidInterest = $loan->paid_interest;
            $data['trx_type'] = 'cash';
            $data['interest_type'] = 'daily';
            $data['name'] = $loan->user->name;
            if ($paidInterest<$interest)
            {
                $remain = $interest-$paidInterest;
                if ($remain < $collection->loan_installment)
                {
                    $data['interest'] = $remain;
                    $loan->paid_interest += $remain;
                    $loan->save();
                    PaidInterestAccount::create($data);
                    $data['loan_installment'] = $collection->loan_installment - $remain;
                    DailyLoanPaymentAccount::create($data);
                }else{
                    $data['interest'] = $collection->loan_installment;
                    $loan->paid_interest += $collection->loan_installment;
                    $loan->save();
                    PaidInterestAccount::create($data);
                }
            }else{
                DailyLoanPaymentAccount::create($data);
            }

            if ($collection->loan_late_fee > 0) {
                $data['collector_id'] = $collection->created_by;
                $data['late_fee'] = $collection->loan_late_fee;
                LateFeeAccount::create($data);
            }
            if ($collection->loan_other_fee > 0) {
                {
                    $data['collector_id'] = $collection->created_by;
                    $data['other_fee'] = $collection->loan_other_fee;
                    OtherFeeAccount::create($data);
                }
            }
        }
        /*if ($collection->loan_installment > 0) {
            $loan = DailyLoan::find($collection->daily_loan_id);
            $interest = $loan->interest;
            $paidInstallment = DailyLoanCollection::where('daily_loan_id', $collection->daily_loan_id)->sum('loan_installment') - $collection->loan_installment;
            if ($interest > $paidInstallment) {
                $data['interest'] = $collection->loan_installment;
                $data['interest_type'] = 'daily';
                PaidInterestAccount::create($data);
            } elseif ($interest <= $paidInstallment) {
                DailyLoanPaymentAccount::create($data);
            }
            if ($collection->loan_late_fee > 0) {
                $data['collector_id'] = $collection->created_by;
                $data['late_fee'] = $collection->loan_late_fee;
                LateFeeAccount::create($data);
            }
            if ($collection->loan_other_fee > 0) {
                {
                    $data['collector_id'] = $collection->created_by;
                    $data['other_fee'] = $collection->loan_other_fee;
                    OtherFeeAccount::create($data);
                }
            }
        }*/
    }

}
