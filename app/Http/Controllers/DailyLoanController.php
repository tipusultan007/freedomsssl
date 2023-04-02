<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyLoanAccount;
use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoanCollection;
use App\Models\DailySavings;
use App\Models\Guarantor;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailyLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DailyLoanPackage;
use App\Http\Requests\DailyLoanStoreRequest;
use App\Http\Requests\DailyLoanUpdateRequest;
use Illuminate\Support\Facades\Auth;

class DailyLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyLoan::class);

        /* $search = $request->get('search', '');

         $dailyLoans = DailyLoan::search($search)
             ->latest()
             ->paginate(5)
             ->withQueryString();*/

        return view('app.daily_loans.index');
    }

    public function dailyLoanData(Request $request)
    {
        $totalData = DailyLoan::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DailyLoan::with('user', 'package')->offset($start)
                ->limit($limit)
                //->orderBy($order,$dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DailyLoan::with('user', 'package')
                ->join('users', 'daily_loans.user_id', '=', 'users.id')
                ->where('daily_loans.account_no', 'LIKE', "%{$search}%")
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                // ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DailyLoan::join('users', 'daily_loans.user_id', '=', 'users.id')
                ->where('daily_loans.account_no', 'LIKE', "%{$search}%")
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('daily-loans.show', $post->id);
                $edit = route('daily-loans.edit', $post->id);

                $date = new Carbon($post->opening_date);
                $nestedData['id']                = $post->id;
                $nestedData['name']              = $post->user->name;
                $nestedData['phone']             = $post->user->phone1;
                $nestedData['balance']           = $post->balance;
                $nestedData['adjusted_amount']   = $post->adjusted_amount;
                $nestedData['commencement']      = $post->commencement;
                $nestedData['account_no']        = $post->account_no;
                $nestedData['months']            = $post->package->months;
                $nestedData['date']              = $date->format('d M Y');;
                $nestedData['per_installment']   = $post->per_installment;
                $nestedData['interest']          = $post->interest;
                $nestedData['loan_amount']       = $post->loan_amount;
                $nestedData['total']             = $post->loan_amount + $post->interest;
                $nestedData['status']            = $post->status;
                $nestedData['profile_photo_url'] = $post->user->profile_photo_path;
                $data[]                          = $nestedData;

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

    public function getLoanCollectionDataByLoan(Request $request)
    {
        $totalData     = DailyLoanCollection::where('daily_loan_id', $request->id)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {
            $posts = DailyLoanCollection::join('users', 'users.id', '=', 'daily_loan_collections.user_id')
                ->join('users as collector', 'collector.id', '=', 'daily_loan_collections.collector_id')
                ->select('daily_loan_collections.*', 'users.name', 'collector.name as c_name')
                ->where('daily_loan_collections.daily_loan_id', $request->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {

                $date = new Carbon($post->opening_date);

                $nestedData['id']            = $post->id;
                $nestedData['user_id']       = $post->user_id;
                $nestedData['daily_loan_id'] = $post->daily_loan_id;
                $nestedData['name']          = $post->name;
                $nestedData['account_no']    = $post->account_no;
                $nestedData['amount']        = $post->loan_installment;
                $nestedData['date']          = $date->format('d M Y');
                $nestedData['late_fee']      = $post->loan_late_fee;
                $nestedData['other_fee']     = $post->loan_other_fee;
                $nestedData['balance']       = $post->loan_balance;
                $nestedData['note']          = $post->loan_note;
                $nestedData['collector']     = $post->c_name;
                $nestedData['collection_id'] = $post->collection_id;
                $data[]                      = $nestedData;

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
        $this->authorize('create', DailyLoan::class);

        $users             = User::all();
        $dailyLoanPackages = DailyLoanPackage::all();

        return view(
            'app.daily_loans.create',
            compact('users', 'dailyLoanPackages', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailyLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DailyLoan::class);

        //$validated = $request->validated();

        $data               = $request->all();
        $data['trx_id'] = TransactionController::trxId();
      //  $savings = DailySavings::where('account_no',$request->account_no)->latest()->first();
        $data['created_by'] = Auth::id();
       // $data['user_id'] = $savings->user_id;
        $dailyLoan          = DailyLoan::create($data);

        $cashout = Cashout::create([
            'cashout_category_id' => 1,
            'account_no'          => $dailyLoan->account_no,
            'daily_loan_id'       => $dailyLoan->id,
            'amount'              => $dailyLoan->loan_amount,
            'date'                => $dailyLoan->opening_date,
            'created_by'          => $dailyLoan->created_by,
            'user_id'             => $dailyLoan->user_id,
            'trx_id' => $dailyLoan->trx_id
        ]);

        $data['daily_loan_id'] = $dailyLoan->id;
        $guarantor             = Guarantor::create($data);
        $data['trx_type'] = 'cash';
        $data['name'] = $dailyLoan->user->name;
        DailyLoanAccount::create($data);
        /*$transaction = Transaction::create([
               'account_id' => 2,
               'description' => 'Daily Loan Provide',
               'trx_id' => $dailyLoan->trx_id,
               'date' => $dailyLoan->opening_date,
               'amount' => $dailyLoan->loan_amount,
               'user_id' => $dailyLoan->created_by,
               'account_no' => $dailyLoan->account_no,
               'name' => $dailyLoan->user->name,
           ]);
        $loanProvide = Account::find(2);
        $loanProvide->balance += $transaction->amount;
        $loanProvide->save();

        $cashAccount = Account::find(4);
        $cashAccount->balance -= $transaction->amount;
        $cashAccount->save();*/
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */


    public function show(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('view', $dailyLoan);

        return view('app.daily_loans.show', compact('dailyLoan'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('update', $dailyLoan);

        $users             = User::pluck('name', 'id');
        $dailyLoanPackages = DailyLoanPackage::pluck('id', 'id');

        return view(
            'app.daily_loans.edit',
            compact('dailyLoan', 'users', 'dailyLoanPackages', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailyLoanUpdateRequest $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyLoanUpdateRequest $request,
        DailyLoan              $dailyLoan
    )
    {
        $this->authorize('update', $dailyLoan);

        $validated = $request->validated();

        $dailyLoan->update($validated);

        return redirect()
            ->route('daily-loans.edit', $dailyLoan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = DailyLoan::find($id);
        $this->authorize('delete', $loan);

        DailyLoanAccount::delete($loan->trx_id);

        //$cashAccount = Account::find(5);
        //$loanProvideAccount = Account::find(10);
       // $loanPaymentAccount = Account::find(11);
        //$interestPaidAccount = Account::find(32);

       /* if ($loan) {
            $balance = $loan->balance;
            $paid = $loan->loan_amount + $loan->interest - $loan->balance;
            if ($paid >= $loan->interest) {
                $interestPaidAccount->balance -= $loan->interest;
                $interestPaidAccount->save();

                $cashAccount->balance -= $loan->interest;
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
        }*/

        $dailyLoanCollection = DailyLoanCollection::where('daily_loan_id',$loan->id)->get();
        foreach ($dailyLoanCollection as $item)
        {
            $dailyCollection = DailyCollection::where('trx_id',$item->trx_id)->first();
            if ($dailyCollection->saving_amount>0)
            {
                $dailyCollection->loan_installment = NULL;
                $dailyCollection->loan_late_fee = NULL;
                $dailyCollection->loan_other_fee = NULL;
                $dailyCollection->loan_balance = NULL;
                $dailyCollection->daily_loan_id = NULL;
                $dailyCollection->loan_note = NULL;
                $dailyCollection->save();
            }else{
                $dailyCollection->delete();
            }
            DailyLoanPaymentAccount::delete($item->trx_id);
            PaidInterestAccount::delete($item->trx_id,'daily');
            if ($item->loan_late_fee>0)
            {
                LateFeeAccount::delete($item->trx_id);
            }
            if ($item->loan_other_fee>0)
            {
                OtherFeeAccount::delete($item->trx_id);
            }
            CashIn::where('trx_id',$item->trx_id)->delete();
            //Transaction::where('trx_id',$item->trx_id)->delete();
            $item->delete();
        }


        Cashout::where('daily_loan_id',$id)->delete();
        //Transaction::whereIn('account_id',[10,11,32])->where('account_no',$loan->account_no)->delete();
        $loan->delete();

        return "success";
    }

    public function deleteInterestTransaction($trxId)
    {
        $transaction = Transaction::where('account_id',7)->where('trx_id',$trxId)->first();
        if ($transaction) {
            $interestAccount = Account::find(7); //INCOME (LOAN INTEREST PAID+)
            $interestAccount->balance -= $transaction->amount;
            $interestAccount->save();

            $cashAccount = Account::find(4); //ASSET (CASH+)
            $cashAccount->balance -= $transaction->amount;
            $cashAccount->save();

            $unpaidInterestAccount = Account::find(8); //INCOME (LOAN INTEREST UNPAID-)
            $unpaidInterestAccount->balance += $transaction->amount;
            $unpaidInterestAccount->save();

            $unpaidInterestAccount1 = Account::find(5); //ASSET (LOAN INTEREST UNPAID-)
            $unpaidInterestAccount1->balance += $transaction->amount;
            $unpaidInterestAccount1->save();

            $transaction->delete();
        }
    }
    public function deleteLoanTransaction($trxId)
    {
        $transaction = Transaction::where('account_id',13)->where('trx_id',$trxId)->first();

        if ($transaction) {
            $interestAccount = Account::find(13); //LOAN PAYMENT+
            $interestAccount->balance -= $transaction->amount;
            $interestAccount->save();

            $cashAccount = Account::find(4); //ASSET (CASH+)
            $cashAccount->balance -= $transaction->amount;
            $cashAccount->save();

            $loanProvidetAccount = Account::find(2); //ASSET (LOAN PROVIDE-)
            $loanProvidetAccount->balance += $transaction->amount;
            $loanProvidetAccount->save();

            $transaction->delete();
        }
    }

}
