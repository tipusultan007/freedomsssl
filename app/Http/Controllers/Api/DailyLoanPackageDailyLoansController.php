<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DailyLoanPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanResource;
use App\Http\Resources\DailyLoanCollection;

class DailyLoanPackageDailyLoansController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        $this->authorize('view', $dailyLoanPackage);

        $search = $request->get('search', '');

        $dailyLoans = $dailyLoanPackage
            ->dailyLoans()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollection($dailyLoans);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        $this->authorize('create', DailyLoan::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'per_installment' => ['nullable', 'numeric'],
            'opening_date' => ['required', 'date'],
            'interest' => ['required', 'numeric'],
            'adjusted_amount' => ['nullable', 'numeric'],
            'commencement' => ['required', 'date'],
            'loan_amount' => ['required', 'numeric'],
            'application_date' => ['nullable', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'approved_by' => ['required', 'exists:users,id'],
            'status' => ['required', 'max:255', 'string'],
        ]);

        $dailyLoan = $dailyLoanPackage->dailyLoans()->create($validated);

        return new DailyLoanResource($dailyLoan);
    }
}
