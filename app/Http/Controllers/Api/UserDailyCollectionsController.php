<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyCollectionResource;
use App\Http\Resources\DailyCollectionCollection;

class UserDailyCollectionsController extends Controller
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

        $dailyCollections = $user
            ->dailyCollections2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyCollectionCollection($dailyCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailyCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'saving_amount' => ['nullable', 'numeric'],
            'saving_type' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'loan_installment' => ['nullable', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'saving_note' => ['nullable', 'string'],
            'loan_note' => ['nullable', 'string'],
            'daily_savings_id' => ['nullable', 'exists:daily_savings,id'],
            'daily_loan_id' => ['nullable', 'exists:daily_loans,id'],
            'savings_balance' => ['nullable', 'numeric'],
            'loan_balance' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $dailyCollection = $user->dailyCollections2()->create($validated);

        return new DailyCollectionResource($dailyCollection);
    }
}
