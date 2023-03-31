<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanCollectionResource;
use App\Http\Resources\DailyLoanCollectionCollection;

class DailyLoanDailyLoanCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('view', $dailyLoan);

        $search = $request->get('search', '');

        $dailyLoanCollections = $dailyLoan
            ->dailyLoanCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollectionCollection($dailyLoanCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('create', DailyLoanCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'loan_installment' => ['required', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'loan_note' => ['nullable', 'string'],
            'loan_balance' => ['required', 'numeric'],
            'collector_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $dailyLoanCollection = $dailyLoan
            ->dailyLoanCollections()
            ->create($validated);

        return new DailyLoanCollectionResource($dailyLoanCollection);
    }
}
