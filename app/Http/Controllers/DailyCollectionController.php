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
use App\Models\DailyInstallment;
use App\Models\DailyLoanCollection;
use App\Models\SavingsCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\DailyCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DailyCollectionController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('app.daily_collections.index');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

  }

  /**
   * @param \App\Http\Requests\DailyCollectionStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $late_fee = $request->late_fee != "" ? $request->late_fee : 0;
    $other_fee = $request->other_fee != "" ? $request->other_fee : 0;

    $data = $request->all();

    $data['trx_id'] = Str::uuid();
    $data['collector_id'] = Auth::id();
    $data['manager_id'] = Auth::id();

    // Process for Savings
    if ($data['saving_amount'] > 0) {
      // Update DailySaving model deposit or withdraw based on saving_type
      $dailySaving = DailySavings::find($data['daily_savings_id']);
      if ($dailySaving)
      {
        if ($data['saving_type'] === 'deposit') {
          $dailySaving->deposit += $data['saving_amount'];
          $dailySaving->total += $data['saving_amount'];
          $dailySaving->balance += $data['saving_amount'];
          $data['total'] = $data['saving_amount'] + $late_fee + $other_fee;
        } else {
          $dailySaving->withdraw += $data['saving_amount'];
          $dailySaving->total -= $data['saving_amount'];
          $dailySaving->balance -= $data['saving_amount'];
          $data['total'] = $data['saving_amount'] - $late_fee - $other_fee;
        }
        $dailySaving->save();

        $data['balance'] = $dailySaving->total;
        $data['type'] = $data['saving_type'];


        // Save to SavingsCollection model
       $dailyCollection = SavingsCollection::create($data);

      }
    }

    $loan_late_fee = $request->loan_late_fee != "" ? $request->loan_late_fee : 0;
    $loan_other_fee = $request->loan_other_fee != "" ? $request->loan_other_fee : 0;

    // Process for Loans
    if ($data['loan_installment'] > 0) {
      // Update DailyLoan model balance
      $dailyLoan = DailyLoan::find($data['daily_loan_id']);
      if ($dailyLoan)
      {
        $dailyLoan->balance -= $data['loan_installment'];
        $dailyLoan->save();

        $data['loan_balance'] = $dailyLoan->balance;
        // Save to DailyLoanCollection model
        DailyLoanCollection::create($data);
      }
    }

    // Add any other logic you might need

    //return redirect()->back()->with('success', 'Form submitted successfully!');


    //$transaction = $this->savingsTransaction($dailyCollection);
    return response()->json([
      'success' => true,
      'message' => "Successfully saved"
    ]);
  }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyCollection $dailyCollection)
    {
       // //$this->authorize('view', $dailyCollection);

        return view('app.daily_collections.show', compact('dailyCollection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailyCollection $dailyCollection)
    {
        ////$this->authorize('update', $dailyCollection);

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
        ////$this->authorize('update', $dailyCollection);

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
        ////$this->authorize('delete', $dailyCollection);

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
        if ($collection->saving_type == 'deposit' && $collection->saving_amount>0) {
            SavingsAccount::create($data);
        }
        if ($collection->saving_type == 'withdraw' && $collection->saving_amount>0) {
            DailyWithdrawAccount::create($data);
        }

        if ($collection->late_fee > 0) {
            $data['created_by'] = $collection->created_by;
            LateFeeAccount::create($data);
        }
        if ($collection->other_fee > 0) {
            {
                $data['created_by'] = $collection->created_by;
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
