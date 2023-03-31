<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanCollectionResource;
use App\Http\Resources\DailyLoanCollectionCollection;

class UserDailyLoanCollectionsController extends Controller
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

        $dailyLoanCollections = $user
            ->dailyLoanCollections2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollectionCollection($dailyLoanCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailyLoanCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'daily_loan_id' => ['required', 'exists:daily_loans,id'],
            'loan_installment' => ['required', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'loan_note' => ['nullable', 'string'],
            'loan_balance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $dailyLoanCollection = $user
            ->dailyLoanCollections2()
            ->create($validated);

        return new DailyLoanCollectionResource($dailyLoanCollection);
    }
}
