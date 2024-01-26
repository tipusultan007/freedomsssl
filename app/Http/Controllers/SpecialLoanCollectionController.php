<?php

namespace App\Http\Controllers;

use App\Models\CashIn;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpecialLoanCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function dataDpsLoanCollection(Request $request)
    {
        $totalData = SpecialLoanCollection::where('special_dps_loan_id', $request->loanId)->count();

        $totalFiltered = $totalData;
        $limit         = $request->input('length');
        $start         = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = SpecialLoanCollection::with('manager')->where('special_dps_loan_id', $request->loanId)
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
                $nestedData['dps_loan_id']        = $post->special_dps_loan_id;
                $nestedData['dps_installment_id'] = $post->special_installment_id;
                $nestedData['date']               = $date->format('d/m/Y');
                $nestedData['loan_installment']   = $post->loan_installment;
                $nestedData['balance']            = $post->balance;
                $nestedData['interest']           = $post->interest;
                $nestedData['receipt_no']         = $post->receipt_no;
                $nestedData['collector']         = $post->manager->name;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dpsLoanCollection = SpecialLoanCollection::find($id);

        $dps_installments = SpecialInstallment::find($dpsLoanCollection->special_installment_id);

        if ($dpsLoanCollection->loan_installment>0)
        {
            $dps_installments->total -= $dpsLoanCollection->loan_installment;
            $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
            if ($loan->remain_loan >= $dps_installments->loan_installment)
            {
                $loan->remain_loan += $dps_installments->loan_installment;
                $loan->save();
            }

            $loanPayments = SpecialLoanPayment::where('special_installment_id',$dpsLoanCollection->special_installment_id)->get();
            foreach ($loanPayments as $loanPayment)
            {
                $loanTaken = SpecialLoanTaken::find($loanPayment->special_loan_taken_id);
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
            $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
            if ($loan->paid_interest >= $dps_installments->interest)
            {
                $loan->paid_interest -= $dps_installments->interest;
                $loan->save();
            }

            SpecialLoanInterest::where('special_installment_id',$dpsLoanCollection->special_installment_id)->delete();
            $dps_installments->save();
        }

        if ($dpsLoanCollection->unpaid_interest>0)
        {
            $loan = SpecialDpsLoan::find($dps_installments->special_dps_loan_id);
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
        $dps_installments->special_dps_loan_id = NULL;
        $dps_installments->save();
        $dpsLoanCollection->delete();

        return "success";
    }
}
