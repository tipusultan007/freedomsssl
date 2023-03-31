<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanResource;
use App\Http\Resources\DpsLoanCollection;

class UserDpsLoansController extends Controller
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

        $dpsLoans = $user
            ->dpsLoans3()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollection($dpsLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DpsLoan::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'loan_amount' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'application_date' => ['required', 'date'],
            'opening_date' => ['nullable', 'date'],
            'commencement' => ['required', 'date'],
            'status' => ['required', 'string'],
            'total_paid' => ['nullable', 'numeric'],
            'remain_loan' => ['nullable', 'numeric'],
        ]);

        $dpsLoan = $user->dpsLoans3()->create($validated);

        return new DpsLoanResource($dpsLoan);
    }
}
