<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsInstallmentResource;
use App\Http\Resources\DpsInstallmentCollection;

class UserDpsInstallmentsController extends Controller
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

        $dpsInstallments = $user
            ->dpsInstallments2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsInstallmentCollection($dpsInstallments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DpsInstallment::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'dps_id' => ['nullable', 'exists:dps,id'],
            'dps_loan_id' => ['nullable', 'exists:dps_loans,id'],
            'dps_amount' => ['nullable', 'numeric'],
            'dps_balance' => ['nullable', 'numeric'],
            'receipt_no' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'grace' => ['nullable', 'numeric'],
            'advance' => ['nullable', 'numeric'],
            'loan_installment' => ['nullable', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'trx_id' => ['required', 'string'],
            'loan_balance' => ['nullable', 'numeric'],
            'total' => ['required', 'numeric'],
            'due' => ['nullable', 'numeric'],
            'due_return' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $dpsInstallment = $user->dpsInstallments2()->create($validated);

        return new DpsInstallmentResource($dpsInstallment);
    }
}
