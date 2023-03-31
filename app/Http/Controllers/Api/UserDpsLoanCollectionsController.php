<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanCollectionResource;
use App\Http\Resources\DpsLoanCollectionCollection;

class UserDpsLoanCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $dpsLoanCollections = $user
            ->dpsLoanCollections2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollectionCollection($dpsLoanCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DpsLoanCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'dps_loan_id' => ['required', 'exists:dps_loans,id'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
            'trx_id' => ['required', 'string'],
            'loan_installment' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'receipt_no' => ['nullable', 'string'],
        ]);

        $dpsLoanCollection = $user->dpsLoanCollections2()->create($validated);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }
}
