<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanResource;
use App\Http\Resources\DailyLoanCollection;

class UserDailyLoansController extends Controller
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

        $dailyLoans = $user
            ->approvedBy()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollection($dailyLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailyLoan::class);

        $validated = $request->validate([
            'package_id' => ['required', 'exists:daily_loan_packages,id'],
            'per_installment' => ['nullable', 'numeric'],
            'opening_date' => ['required', 'date'],
            'interest' => ['required', 'numeric'],
            'adjusted_amount' => ['nullable', 'numeric'],
            'commencement' => ['required', 'date'],
            'loan_amount' => ['required', 'numeric'],
            'application_date' => ['nullable', 'date'],
            'status' => ['required', 'max:255', 'string'],
        ]);

        $dailyLoan = $user->approvedBy()->create($validated);

        return new DailyLoanResource($dailyLoan);
    }
}
