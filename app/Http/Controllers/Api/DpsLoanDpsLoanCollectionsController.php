<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanCollectionResource;
use App\Http\Resources\DpsLoanCollectionCollection;

class DpsLoanDpsLoanCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('view', $dpsLoan);

        $search = $request->get('search', '');

        $dpsLoanCollections = $dpsLoan
            ->dpsLoanCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollectionCollection($dpsLoanCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('create', DpsLoanCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'collector_id' => ['required', 'exists:users,id'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
            'trx_id' => ['required', 'string'],
            'loan_installment' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'receipt_no' => ['nullable', 'string'],
        ]);

        $dpsLoanCollection = $dpsLoan->dpsLoanCollections()->create($validated);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }
}
