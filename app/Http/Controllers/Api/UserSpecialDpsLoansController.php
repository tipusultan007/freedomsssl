<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsLoanResource;
use App\Http\Resources\SpecialDpsLoanCollection;

class UserSpecialDpsLoansController extends Controller
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

        $specialDpsLoans = $user
            ->specialDpsLoans3()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsLoanCollection($specialDpsLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SpecialDpsLoan::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'loan_amount' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['nullable', 'numeric'],
            'application_date' => ['required', 'date'],
            'opening_date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'status' => ['required', 'string'],
            'total_paid' => ['nullable', 'numeric'],
            'remain_loan' => ['nullable', 'numeric'],
        ]);

        $specialDpsLoan = $user->specialDpsLoans3()->create($validated);

        return new SpecialDpsLoanResource($specialDpsLoan);
    }
}
