<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DpsLoanAccount;
use App\Http\Controllers\Accounts\DpsLoanPaymentAccount;
use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Imports\DpsLoanImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\LoanPayment;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\TakenLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DpsLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\DpsLoanStoreRequest;
use App\Http\Requests\DpsLoanUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DpsLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsLoan::class);

        $search = $request->get('search', '');

        $dpsLoans = DpsLoan::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.dps_loans.index', compact('dpsLoans', 'search'));
    }

    public function dataDpsLoans(Request $request)
    {
        $totalData = DpsLoan::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            $posts = DpsLoan::select('dps_loans.*','users.name as name','users.phone1','users.profile_photo_path','c.name as createdBy')
                ->leftJoin('users','users.id','=','dps_loans.user_id')
                ->leftJoin('users as c','c.id','=','dps_loans.created_by')
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps_loans.account_no','asc')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DpsLoan::leftJoin('users','users.id','=','dps_loans.user_id')
                ->leftJoin('users as c','c.id','=','dps_loans.created_by')
                ->select('dps_loans.*','users.name as name','users.phone1','users.profile_photo_path','c.name as createdBy')
                ->where('dps_loans.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps_loans.account_no','asc')
                ->get();

            $totalFiltered = DpsLoan::leftJoin('users','users.id','=','dps_loans.user_id')
                ->leftJoin('users as c','c.id','=','dps_loans.created_by')
                ->where('dps_loans.account_no','LIKE',"%{$search}%")
                ->orWhere('users.name','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('dps-loans.show',$post->id);
                $edit =  route('dps-loans.edit',$post->id);

                $date = new Carbon($post->opening_date);
                $commencement = new Carbon($post->commencement);
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['date'] = 'D-'.$date->format('d/m/Y').'<br>C-'.$commencement->format('d/m/Y');
                //$nestedData['commencement'] = $post->commencement;
                $nestedData['loan_amount'] = $post->loan_amount;
                $nestedData['total_paid'] = $post->total_paid;
                $nestedData['interest'] = $post->interest1.'%';
                $nestedData['upto_amount'] = $post->upto_amount;
                $nestedData['remain_loan'] = $post->remain_loan;
                $nestedData['phone'] = $post->phone1;
                $nestedData['createdBy'] = $post->createdBy;
                $nestedData['photo'] = $post->profile_photo_path;
                $nestedData['status'] = $post->status;
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
        $this->authorize('create', DpsLoan::class);

        $users = User::all();

        return view('app.dps_loans.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\DpsLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->authorize('create', DpsLoan::class);
        $data = $request->all();
        $data['trx_id'] = TransactionController::trxId();
        $loan = DpsLoan::where('account_no',$request->account_no)->first();
        if ($loan)
        {
            $data['before_loan'] = $loan->remain_loan;
            $loan->loan_amount += $request->loan_amount;
            $loan->remain_loan += $request->loan_amount;
            $loan->save();
            $data['after_loan'] = $loan->remain_loan;
            $data['created_by'] = Auth::id();
            $data['dps_loan_id'] = $loan->id;
            $data['date'] = $request->opening_date;
            $data['remain'] = $request->loan_amount;
            $takenLoan = TakenLoan::create($data);
            $data['taken_loan_id'] = $takenLoan->id;

            $cashout = Cashout::create([
                'cashout_category_id' => 3,
                'account_no'          => $takenLoan->account_no,
                'dps_loan_id'         => $takenLoan->id,
                'amount'              => $takenLoan->loan_amount,
                'date'                => $takenLoan->date,
                'created_by'          => $takenLoan->created_by,
                'user_id'             => $takenLoan->user_id,
                'trx_id'             => $takenLoan->trx_id,
            ]);

            LoanDocuments::create($data);
            $data['user_id'] = $request->guarantor_user_id;
            Guarantor::create($data);

            $transaction = $this->accountTransaction($takenLoan);

        }else{
            $data['created_by'] = Auth::id();
            $data['remain_loan'] = $request->loan_amount;
            $dpsLoan = DpsLoan::create($data);
            $data['dps_loan_id'] = $dpsLoan->id;
            $data['date'] = $request->opening_date;
            $data['remain'] = $request->loan_amount;
            $data['before_loan'] = 0;
            $data['after_loan'] = $request->loan_amount;
            $takenLoan = TakenLoan::create($data);
            $data['taken_loan_id'] = $takenLoan->id;
            $cashout = Cashout::create([
                'cashout_category_id' => 3,
                'account_no'          => $takenLoan->account_no,
                'dps_loan_id'         => $takenLoan->id,
                'amount'              => $takenLoan->loan_amount,
                'date'                => $takenLoan->date,
                'created_by'          => $takenLoan->created_by,
                'user_id'             => $takenLoan->user_id,
                'trx_id'             => $takenLoan->trx_id,
            ]);

            LoanDocuments::create($data);
            $data['user_id'] = $request->guarantor_user_id;
            Guarantor::create($data);

            $transaction = $this->accountTransaction($takenLoan);
        }
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('view', $dpsLoan);

        return view('app.dps_loans.show', compact('dpsLoan'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('update', $dpsLoan);

        $users = User::pluck('name', 'id');

        return view(
            'app.dps_loans.edit',
            compact('dpsLoan', 'users', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DpsLoanUpdateRequest $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function update(DpsLoanUpdateRequest $request, DpsLoan $dpsLoan)
    {
        $this->authorize('update', $dpsLoan);

        $validated = $request->validated();

        $dpsLoan->update($validated);

        return redirect()
            ->route('dps-loans.edit', $dpsLoan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dpsLoan = DpsLoan::find($id);
        $takenLoans = TakenLoan::where('dps_loan_id',$id)->get();
        /*$loanProvideAccount = Account::find(2);
        $loanPaymentAccount = Account::find(13);
        $cashAccount = Account::find(4);
        $interestAccount = Account::find(7);
        $interestUnpaidAccount = Account::find(5);
        $interestUnpaidAccount1 = Account::find(8);
        $latefeeAccount = Account::find(18);
        $otherfeeAccount = Account::find(19);
        $graceAccount = Account::find(20);

        $grace = Transaction::where('account_id',20)->where('account_no',$dpsLoan->account_no)->sum('amount');
        $lateFee = Transaction::where('account_id',18)->where('account_no',$dpsLoan->account_no)->sum('amount');
        $otherFee = Transaction::where('account_id',19)->where('account_no',$dpsLoan->account_no)->sum('amount');
        $unpaidInterestTransactions = Transaction::where('account_id',8)->where('account_no',$dpsLoan->account_no)->get();
        $totalUnpaidInterest = $unpaidInterestTransactions->sum('amount');
        $remainUnpaid = $totalUnpaidInterest - $dpsLoan->paid_interest;
        $graceAccount->balance -=$grace;
        $graceAccount->save();
        $latefeeAccount->balance -= $lateFee;
        $latefeeAccount->save();
        $otherfeeAccount->balance -= $otherFee;
        $otherfeeAccount->save();

        $loanProvideAccount->balance -= $dpsLoan->remain_loan;
        $loanProvideAccount->save();

        $loanPaymentAccount->balance -= $dpsLoan->total_paid;
        $loanPaymentAccount->save();
        $interestUnpaidAccount->balance -= $remainUnpaid;
        $interestUnpaidAccount->save();
        $interestUnpaidAccount1->balance -= $remainUnpaid;
        $interestUnpaidAccount1->save();
        $interestAccount->balance -= $dpsLoan->paid_interest;
        $interestAccount->save();
        $cashAccount->balance -= ($dpsLoan->paid_interest + $lateFee + $otherFee);
        $cashAccount->save();
        $cashAccount->balance += $dpsLoan->remain_loan;
        $cashAccount->save();*/

        //Transaction::whereIn('account_id',[2,4,5,7,8,13,18,19,20])->where('account_no',$dpsLoan->account_no)->delete();
        //$unpaidInterestTransactions->delete();

        foreach ($takenLoans as $takenLoan)
        {
            LoanPayment::where('taken_loan_id',$takenLoan->id)->delete();
            Cashout::where('dps_loan_id',$takenLoan->id)->delete();
            DpsLoanAccount::delete($takenLoan->trx_id);
            $takenLoan->delete();
        }
        //$this->authorize('delete', $dpsLoan);
        $dpsInstallments = DpsInstallment::where('dps_loan_id',$id)->get();
        foreach ($dpsInstallments as $dpsInstallment)
        {
            if ($dpsInstallment->loan_installment > 0) {
                DpsLoanPaymentAccount::delete($dpsInstallment->trx_id);
            }
            if ($dpsInstallment->loan_installment > 0) {
                PaidInterestAccount::delete($dpsInstallment->trx_id, 'dps');
            }

            if ($dpsInstallment->loan_late_fee > 0) {
                LateFeeAccount::delete($dpsInstallment->trx_id);
            }
            if ($dpsInstallment->loan_other_fee > 0) {
                OtherFeeAccount::delete($dpsInstallment->trx_id);
            }
            if ($dpsInstallment->loan_grace > 0) {
                GraceAccount::delete($dpsInstallment->trx_id);
            }

            DpsLoanInterest::where('dps_installment_id',$dpsInstallment->id)->delete();
            DpsLoanCollection::where('dps_installment_id',$dpsInstallment->id)->delete();
            $cashin = CashIn::where('trx_id',$dpsInstallment->trx_id)->first();
            $cashin->amount -= $dpsInstallment->loan_installment + $dpsInstallment->interest + $dpsInstallment->loan_late_fee + $dpsInstallment->loan_other_fee;
            $cashin->save();
            $cashin->amount += $dpsInstallment->loan_grace;
            $cashin->save();
            $dpsInstallment->loan_grace = NULL;
            $dpsInstallment->loan_installment = NULL;
            $dpsInstallment->interest = NULL;
            $dpsInstallment->loan_balance = NULL;
            $dpsInstallment->due_interest = NULL;
            $dpsInstallment->loan_note = NULL;
            $dpsInstallment->dps_loan_id = NULL;
            $dpsInstallment->save();
        }

        $dpsLoan->delete();
        return "success";
    }
    public function import(Request $request)
    {
        Excel::import(new DpsLoanImport(),
            $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function loanList($id)
    {
        $loans = TakenLoan::where('dps_loan_id',$id)
            ->select('id','date','loan_amount','interest1','interest2','upto_amount','remain','commencement')->get();

        echo json_encode($loans);
    }

    public function loansById(Request $request)
    {

    }
    public function resetLoan($id)
    {
        $loan = DpsLoan::find($id);
        $loan->remain_loan = $loan->loan_amount;
        $loan->paid_interest = 0;
        $loan->dueInterest = 0;
        $loan->grace = 0;
        $loan->save();

        $installments = DpsInstallment::where('account_no',$loan->account_no)
            ->where('loan_installment','>',0)
            ->orWhere('interest','>',0)
            ->get();
        $takenLoans = TakenLoan::where('account_no',$loan->account_no)->get();

        foreach ($installments as $installment)
        {
            DpsLoanCollection::where('dps_installment_id',$installment->id)->delete();
            DpsLoanInterest::where('dps_installment_id',$installment->id)->delete();
            LoanPayment::where('dps_installment_id',$installment->id)->delete();
            CashIn::where('cashin_category_id',4)->where('dps_installment_id',$installment->id)->delete();
            if ($installment->dps_amount == 0 && $installment->dps_amount == NULL)
            {
                $installment->delete();
            }else{

                if ($installment->loan_installment >0)
                {
                    $installment->total -= $installment->loan_installment;
                    $installment->loan_installment = NULL;
                    $installment->save();
                    DpsLoanPaymentAccount::delete($installment->trx_id);
                }

                if ($installment->interest>0)
                {
                    $installment->total -= $installment->interest;
                    $installment->interest = NULL;
                    $installment->save();
                    PaidInterestAccount::delete($installment->trx_id,'dps');
                }

                if ($installment->loan_late_fee>0)
                {
                    $installment->total -= $installment->loan_late_fee;
                    $installment->loan_late_fee = NULL;
                    $installment->save();
                    LateFeeAccount::delete($installment->trx_id);
                }
                if ($installment->loan_other_fee>0)
                {
                    $installment->total -= $installment->loan_other_fee;
                    $installment->loan_other_fee = NULL;
                    $installment->save();
                    OtherFeeAccount::delete($installment->trx_id);
                }
                if ($installment->loan_grace>0)
                {
                    GraceAccount::delete($installment->trx_id);
                }

                $installment->dps_loan_id = NULL;
                $installment->loan_balance = NULL;
                $installment->due_interest = NULL;
                $installment->loan_note = NULL;
                $installment->save();
            }
        }

        foreach ($takenLoans as $takenLoan)
        {
            $takenLoan->remain = $takenLoan->loan_amount;
            $takenLoan->save();
        }



    }

    public function accountTransaction(TakenLoan $loan)
    {
        $data = $loan;
        $data['trx_type'] = 'cash';
        $data['name'] = $loan->user->name;
        DpsLoanAccount::create($data);
        /*$transaction = Transaction::create([
                                               'account_id' => 2,
                                               'description' => 'DPS Loan Provide',
                                               'trx_id' => $loan->trx_id,
                                               'date' => $loan->date,
                                               'amount' => $loan->loan_amount,
                                               'user_id' => $loan->created_by,
            'account_no' => $loan->account_no,
            'name' => $loan->user->name,
                                           ]);
        $loanProvide = Account::find(2);
        $loanProvide->balance += $transaction->amount;
        $loanProvide->save();

        $cashAccount = Account::find(4);
        $cashAccount->balance -= $transaction->amount;
        $cashAccount->save();*/

    }
}
