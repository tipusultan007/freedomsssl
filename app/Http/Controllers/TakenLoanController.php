<?php

namespace App\Http\Controllers;

use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\LoanPayment;
use App\Models\User;
use App\Models\DpsLoan;
use App\Models\TakenLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TakenLoanStoreRequest;
use App\Http\Requests\TakenLoanUpdateRequest;
use Illuminate\Support\Facades\DB;

class TakenLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TakenLoan::class);

        $search = $request->get('search', '');

        $takenLoans = TakenLoan::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.taken_loans.index', compact('takenLoans', 'search'));
    }

    public function dataTakenLoans(Request $request)
    {
        if (!empty($request->dps_loan_id)) {
            $totalData = TakenLoan::where('dps_loan_id', $request->dps_loan_id)->count();
        } elseif (!empty($request->account_no)) {
            $totalData = TakenLoan::where('account_no', $request->account_no)->count();
        } else {
            $totalData = TakenLoan::count();
        }


        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            if (!empty($request->dps_loan_id)) {
                $posts = TakenLoan::leftJoin('users', 'users.id', '=', 'taken_loans.user_id')
                    ->leftJoin('users as c', 'c.id', '=', 'taken_loans.created_by')
                    ->select('taken_loans.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('taken_loans.account_no', 'asc')
                    ->where('taken_loans.dps_loan_id', $request->dps_loan_id)
                    ->get();
            } elseif (!empty($request->account_no)) {
                $posts = TakenLoan::leftJoin('users', 'users.id', '=', 'taken_loans.user_id')
                    ->leftJoin('users as c', 'c.id', '=', 'taken_loans.created_by')
                    ->select('taken_loans.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('taken_loans.id', 'asc')
                    ->where('taken_loans.account_no', $request->account_no)
                    ->get();
            } else {
                $posts = TakenLoan::leftJoin('users', 'users.id', '=', 'taken_loans.user_id')
                    ->leftJoin('users as c', 'c.id', '=', 'taken_loans.created_by')
                    ->select('taken_loans.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('taken_loans.account_no', 'asc')
                    ->get();
            }
        } else {
            $search = $request->input('search.value');

            $posts = TakenLoan::leftJoin('users', 'users.id', '=', 'taken_loans.user_id')
                ->leftJoin('users as c', 'c.id', '=', 'taken_loans.created_by')
                ->select('taken_loans.*', 'users.name as name', 'users.phone1', 'users.profile_photo_path', 'c.name as createdBy')
                ->where('taken_loans.account_no', 'LIKE', "%{$search}%")
                ->where('users.name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('taken_loans.account_no', 'asc')
                ->get();

            $totalFiltered = TakenLoan::leftJoin('users', 'users.id', '=', 'taken_loans.user_id')
                ->leftJoin('users as c', 'c.id', '=', 'taken_loans.created_by')
                ->where('taken_loans.account_no', 'LIKE', "%{$search}%")
                ->where('users.name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('taken-loans.show', $post->id);
                $edit = route('taken-loans.edit', $post->id);

                $date                     = new Carbon($post->date);
                $commencement             = new Carbon($post->commencement);
                $nestedData['id']         = $post->id;
                $nestedData['name']       = $post->name;
                $nestedData['history']    = 'Before-' . $post->before_loan . '<br>After-' . $post->after_loan;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['date']       = 'D-' . $date->format('d/m/Y') . '<br>C-' . $commencement->format('d/m/Y');
                //$nestedData['commencement'] = $post->commencement;
                $nestedData['loan_amount'] = $post->loan_amount;
                //$nestedData['interest'] = $post->interest1.'%';
                if ($post->interest2 > 0) {
                    $nestedData['interest'] = $post->interest1 . '%' . ' | ' . $post->interest2 . '%';
                } else {
                    $nestedData['interest'] = $post->interest1 . '%';
                }
                $nestedData['upto_amount'] = $post->upto_amount ?? 'N/A';
                $nestedData['remain']      = $post->remain;
                $nestedData['phone']       = $post->phone1;
                $nestedData['createdBy']   = $post->createdBy;
                $nestedData['photo']       = $post->profile_photo_path;
                $data[]                    = $nestedData;

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
        $this->authorize('create', TakenLoan::class);

        $users    = User::pluck('name', 'id');
        $dpsLoans = DpsLoan::pluck('account_no', 'id');

        return view(
            'app.taken_loans.create',
            compact('users', 'users', 'dpsLoans')
        );
    }

    /**
     * @param \App\Http\Requests\TakenLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TakenLoanStoreRequest $request)
    {
        $this->authorize('create', TakenLoan::class);

        $validated = $request->validated();

        $takenLoan = TakenLoan::create($validated);

        $cashout = Cashout::create([
            'cashout_category_id' => 3,
            'account_no'          => $takenLoan->account_no,
            'dps_loan_id'         => $takenLoan->id,
            'amount'              => $takenLoan->loan_amount,
            'date'                => $takenLoan->date,
            'created_by'          => $takenLoan->created_by,
            'user_id'             => $takenLoan->user_id,
        ]);

        return redirect()
            ->route('taken-loans.edit', $takenLoan)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('view', $takenLoan);

        return view('app.taken_loans.show', compact('takenLoan'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('update', $takenLoan);

        $users    = User::pluck('name', 'id');
        $dpsLoans = DpsLoan::pluck('account_no', 'id');

        return view(
            'app.taken_loans.edit',
            compact('takenLoan', 'users', 'users', 'dpsLoans')
        );
    }

    /**
     * @param \App\Http\Requests\TakenLoanUpdateRequest $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function update(
        TakenLoanUpdateRequest $request,
        TakenLoan              $takenLoan
    )
    {
        $this->authorize('update', $takenLoan);

        $validated = $request->validated();

        $takenLoan->update($validated);

        return redirect()
            ->route('taken-loans.edit', $takenLoan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('delete', $takenLoan);

        $takenLoan->delete();

        return redirect()
            ->route('taken-loans.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function dataTakenLoanTransaction(Request $request)
    {
        $q_date         = 'dps_installments.date';
        $q_loan         = 'loan_payments.amount';
        $q_remain       = 'loan_payments.balance';
        $q_interest     = 'dps_loan_interests.total as totalInterest';
        $q_installments = 'dps_loan_interests.installments';
        $q_rate         = 'dps_loan_interests.interest';
        $totalData      = DB::table('dps_installments')
            ->leftJoin('dps_loan_interests', 'dps_loan_interests.dps_installment_id', '=', 'dps_installments.id')
            ->leftJoin('loan_payments', 'loan_payments.dps_installment_id', '=', 'dps_installments.id')
            ->select($q_date, $q_loan, $q_remain, $q_interest, $q_installments, $q_rate)
            ->where('dps_loan_interests.taken_loan_id', $request->loanId)
            ->orWhere('loan_payments.taken_loan_id', $request->loanId)
            ->count();

        $totalFiltered = $totalData;
        $limit         = $request->input('length');
        $start         = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = DB::table('dps_installments')
                ->leftJoin('dps_loan_interests', 'dps_loan_interests.dps_installment_id', '=', 'dps_installments.id')
                ->leftJoin('loan_payments', 'loan_payments.dps_installment_id', '=', 'dps_installments.id')
                ->select($q_date, $q_loan, $q_remain, $q_interest, $q_installments, $q_rate, 'dps_loan_interests.id as interestId', 'loan_payments.id as paymentId')
                ->where('dps_loan_interests.taken_loan_id', $request->loanId)
                ->orWhere('loan_payments.taken_loan_id', $request->loanId)
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps_installments.id', 'desc')
                ->get();

        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                //$show = route('dps-collections.show', $post->id);
                //$edit = route('dps-collections.edit', $post->id);

                $date                           = new Carbon($post->date);
                $nestedData['paymentId']        = $post->paymentId;
                $nestedData['interestId']       = $post->interestId;
                $nestedData['date']             = $date->format('d/m/Y');
                $nestedData['loan_installment'] = $post->amount;
                $nestedData['remain']           = $post->balance;
                $nestedData['interest']         = $post->totalInterest;
                $nestedData['installments']     = $post->installments;
                $nestedData['rate']             = $post->interest;
                $data[]                         = $nestedData;

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

    public function deleteInterestByLoanId($id)
    {
        $loanInterest    = DpsLoanInterest::find($id);
        $dps_installment = DpsInstallment::find($loanInterest->dps_installment_id);
        $loanCollection  = DpsLoanCollection::where('dps_installment_id', $loanInterest->dps_installment_id)->first();
        $loan            = DpsLoan::find($dps_installment->dps_loan_id);
        if ($loan->paid_interest > 0) {
            $loan->paid_interest -= $loanInterest->total;
        }
        $loan->save();

        $dps_installment->interest -= $loanInterest->total;
        $dps_installment->total    -= $loanInterest->total;
        $loanCollection->interest  -= $loanInterest->total;
        $loanCollection->save();
        $cashin         = CashIn::where('cashin_category_id', 4)->where('dps_installment_id', $dps_installment->id)->latest()->first();
        $cashin->amount -= $loanInterest->total;
        $cashin->save();
        $dps_installment->save();
        $loanInterest->delete();
        echo "success";

    }

    public function deleteLoanPaymentByLoanId($id)
    {
        $loanPayment                         = LoanPayment::find($id);
        $loanTaken                           = TakenLoan::find($loanPayment->taken_loan_id);
        $loan                                = DpsLoan::find($loanTaken->dps_loan_id);
        $dpsInstallment                      = DpsInstallment::find($loanPayment->dps_installment_id);
        $dpsLoanCollection                   = DpsLoanCollection::where('dps_installment_id', $loanPayment->dps_installment_id)->first();
        $dpsLoanCollection->loan_installment -= $loanPayment->amount;
        $dpsInstallment->loan_installment    -= $loanPayment->amount;
        $loan->remain_loan                   += $loanPayment->amount;
        $loanTaken->remain                   += $loanPayment->amount;
        $loan->save();
        $loanTaken->save();
        $dpsInstallment->save();
        $dpsLoanCollection->save();
        $cashin         = CashIn::where('cashin_category_id', 4)->where('dps_installment_id', $dpsInstallment->id)->latest()->first();
        $cashin->amount -= $loanPayment->amount;
        $cashin->save();
        $loanPayment->delete();

        echo "success";
    }
}
