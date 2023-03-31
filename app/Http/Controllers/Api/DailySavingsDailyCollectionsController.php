<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyCollectionResource;
use App\Http\Resources\DailyCollectionCollection;

class DailySavingsDailyCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('view', $dailySavings);

        $search = $request->get('search', '');

        $dailyCollections = $dailySavings
            ->dailyCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyCollectionCollection($dailyCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('create', DailyCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'collector_id' => ['required', 'exists:users,id'],
            'saving_amount' => ['nullable', 'numeric'],
            'saving_type' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'loan_installment' => ['nullable', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'saving_note' => ['nullable', 'string'],
            'loan_note' => ['nullable', 'string'],
            'daily_loan_id' => ['nullable', 'exists:daily_loans,id'],
            'savings_balance' => ['nullable', 'numeric'],
            'loan_balance' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $dailyCollection = $dailySavings
            ->dailyCollections()
            ->create($validated);

        return new DailyCollectionResource($dailyCollection);
    }
}
