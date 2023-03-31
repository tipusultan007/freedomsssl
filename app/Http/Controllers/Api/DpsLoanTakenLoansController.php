<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TakenLoanResource;
use App\Http\Resources\TakenLoanCollection;

class DpsLoanTakenLoansController extends Controller
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

        $takenLoans = $dpsLoan
            ->takenLoans()
            ->search($search)
            ->latest()
            ->paginate();

        return new TakenLoanCollection($takenLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('create', TakenLoan::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'loan_amount' => ['required', 'numeric'],
            'before_loan' => ['required', 'numeric'],
            'after_loan' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $takenLoan = $dpsLoan->takenLoans()->create($validated);

        return new TakenLoanResource($takenLoan);
    }
}
