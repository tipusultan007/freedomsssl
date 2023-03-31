<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanCollectionResource;
use App\Http\Resources\DpsLoanCollectionCollection;

class DpsInstallmentDpsLoanCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('view', $dpsInstallment);

        $search = $request->get('search', '');

        $dpsLoanCollections = $dpsInstallment
            ->dpsLoanCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollectionCollection($dpsLoanCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('create', DpsLoanCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'dps_loan_id' => ['required', 'exists:dps_loans,id'],
            'collector_id' => ['required', 'exists:users,id'],
            'trx_id' => ['required', 'string'],
            'loan_installment' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'receipt_no' => ['nullable', 'string'],
        ]);

        $dpsLoanCollection = $dpsInstallment
            ->dpsLoanCollections()
            ->create($validated);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }
}
