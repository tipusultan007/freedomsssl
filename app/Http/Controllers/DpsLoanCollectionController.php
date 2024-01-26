<?php

namespace App\Http\Controllers;

use App\Imports\DpsLoanImport;
use App\Models\CashIn;
use App\Models\DpsLoanInterest;
use App\Models\LoanPayment;
use App\Models\TakenLoan;
use App\Models\User;
use App\Models\DpsLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Http\Requests\DpsLoanCollectionStoreRequest;
use App\Http\Requests\DpsLoanCollectionUpdateRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DpsLoanCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', DpsLoanCollection::class);

        $search = $request->get('search', '');

        $dpsLoanCollections = DpsLoanCollection::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.dps_loan_collections.index',
            compact('dpsLoanCollections', 'search')
        );
    }

    public function dataDpsLoanCollection(Request $request)
    {
        $totalData = DpsLoanCollection::where('dps_loan_id', $request->loanId)->count();

        $totalFiltered = $totalData;
        $limit         = $request->input('length');
        $start         = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = DpsLoanCollection::with('collector')->where('dps_loan_id', $request->loanId)
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();

        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                //$show = route('dps-collections.show', $post->id);
                //$edit = route('dps-collections.edit', $post->id);

                $date                             = new Carbon($post->date);
                $nestedData['id']        = $post->id;
                $nestedData['dps_loan_id']        = $post->dps_loan_id;
                $nestedData['dps_installment_id'] = $post->dps_installment_id;
                $nestedData['date']               = $date->format('d/m/Y');
                $nestedData['loan_installment']   = $post->loan_installment;
                $nestedData['balance']            = $post->balance;
                $nestedData['interest']           = $post->interest;
                $nestedData['receipt_no']         = $post->receipt_no;
                $nestedData['collector']         = $post->collector->name;
                $data[]                           = $nestedData;

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
        //$this->authorize('create', DpsLoanCollection::class);

        $users           = User::pluck('name', 'id');
        $dpsLoans        = DpsLoan::pluck('account_no', 'id');
        $dpsInstallments = DpsInstallment::pluck('account_no', 'id');

        return view(
            'app.dps_loan_collections.create',
            compact('users', 'dpsLoans', 'users', 'dpsInstallments')
        );
    }

    /**
     * @param \App\Http\Requests\DpsLoanCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsLoanCollectionStoreRequest $request)
    {
        //$this->authorize('create', DpsLoanCollection::class);

        $validated = $request->validated();

        $dpsLoanCollection = DpsLoanCollection::create($validated);

        return redirect()
            ->route('dps-loan-collections.edit', $dpsLoanCollection)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsLoanCollection $dpsLoanCollection)
    {
        //$this->authorize('view', $dpsLoanCollection);

        return view(
            'app.dps_loan_collections.show',
            compact('dpsLoanCollection')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsLoanCollection $dpsLoanCollection)
    {
        //$this->authorize('update', $dpsLoanCollection);

        $users           = User::pluck('name', 'id');
        $dpsLoans        = DpsLoan::pluck('account_no', 'id');
        $dpsInstallments = DpsInstallment::pluck('account_no', 'id');

        return view(
            'app.dps_loan_collections.edit',
            compact(
                'dpsLoanCollection',
                'users',
                'dpsLoans',
                'users',
                'dpsInstallments'
            )
        );
    }

    /**
     * @param \App\Http\Requests\DpsLoanCollectionUpdateRequest $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsLoanCollectionUpdateRequest $request,
        DpsLoanCollection              $dpsLoanCollection
    )
    {
        //$this->authorize('update', $dpsLoanCollection);

        $validated = $request->validated();

        $dpsLoanCollection->update($validated);

        return redirect()
            ->route('dps-loan-collections.edit', $dpsLoanCollection)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dpsLoanCollection = DpsLoanCollection::find($id);
        //$this->authorize('delete', $dpsLoanCollection);
        $dps_installments = DpsInstallment::find($dpsLoanCollection->dps_installment_id);

        if ($dpsLoanCollection->loan_installment>0)
        {
            $dps_installments->total -= $dpsLoanCollection->loan_installment;
            $loan = DpsLoan::find($dps_installments->dps_loan_id);
            if ($loan->remain_loan >= $dps_installments->loan_installment)
            {
                $loan->remain_loan += $dps_installments->loan_installment;
                $loan->save();
            }

            $loanPayments = LoanPayment::where('dps_installment_id',$dpsLoanCollection->dps_installment_id)->get();
            foreach ($loanPayments as $loanPayment)
            {
                $loanTaken = TakenLoan::find($loanPayment->taken_loan_id);
                if ($loanTaken->remain >= $loanPayment->amount)
                {
                    $loanTaken->remain += $loanPayment->amount;
                    $loanTaken->save();
                }
                $loanPayment->save();
            }

            $dps_installments->save();
        }
        if ($dps_installments->interest>0)
        {
            $dps_installments->total -= $dpsLoanCollection->interest;
            $loan = DpsLoan::find($dps_installments->dps_loan_id);
            if ($loan->paid_interest >= $dps_installments->interest)
            {
                $loan->paid_interest -= $dps_installments->interest;
                $loan->save();
            }

            DpsLoanInterest::where('dps_installment_id',$dpsLoanCollection->dps_installment_id)->delete();
            $dps_installments->save();
        }

        if ($dpsLoanCollection->unpaid_interest>0)
        {
            $loan = DpsLoan::find($dps_installments->dps_loan_id);
            $loan->dueInterest -= $dpsLoanCollection->unpaid_interest;
            $loan->save();
        }

        if ($dpsLoanCollection->loan_late_fee>0)
        {
            $dps_installments->total -= $dpsLoanCollection->loan_late_fee;
            $dps_installments->save();
        }
        if ($dpsLoanCollection->loan_other_fee>0)
        {
            $dps_installments->total -= $dpsLoanCollection->loan_other_fee;
            $dps_installments->save();
        }

        $dps_installments->loan_grace = NULL;
        $dps_installments->loan_installment = NULL;
        $dps_installments->interest = NULL;
        $dps_installments->loan_balance = NULL;
        $dps_installments->due_interest = NULL;
        $dps_installments->loan_note = NULL;
        $dps_installments->dps_loan_id = NULL;
        $dps_installments->save();
        CashIn::where('cashin_category_id',4)->where('dps_installment_id', $dpsLoanCollection->dps_installment_id)->delete();
        $dpsLoanCollection->delete();

        return "success";
    }


}
