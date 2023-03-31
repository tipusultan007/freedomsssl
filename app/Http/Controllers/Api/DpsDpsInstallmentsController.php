<?php

namespace App\Http\Controllers\Api;

use App\Models\Dps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsInstallmentResource;
use App\Http\Resources\DpsInstallmentCollection;

class DpsDpsInstallmentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Dps $dps)
    {
        $this->authorize('view', $dps);

        $search = $request->get('search', '');

        $dpsInstallments = $dps
            ->dpsInstallments()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsInstallmentCollection($dpsInstallments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dps $dps)
    {
        $this->authorize('create', DpsInstallment::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'collector_id' => ['required', 'exists:users,id'],
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

        $dpsInstallment = $dps->dpsInstallments()->create($validated);

        return new DpsInstallmentResource($dpsInstallment);
    }
}
