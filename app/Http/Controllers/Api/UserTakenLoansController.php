<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TakenLoanResource;
use App\Http\Resources\TakenLoanCollection;

class UserTakenLoansController extends Controller
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

        $takenLoans = $user
            ->takenLoans2()
            ->search($search)
            ->latest()
            ->paginate();

        return new TakenLoanCollection($takenLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', TakenLoan::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'loan_amount' => ['required', 'numeric'],
            'before_loan' => ['required', 'numeric'],
            'after_loan' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'dps_loan_id' => ['required', 'exists:dps_loans,id'],
        ]);

        $takenLoan = $user->takenLoans2()->create($validated);

        return new TakenLoanResource($takenLoan);
    }
}
