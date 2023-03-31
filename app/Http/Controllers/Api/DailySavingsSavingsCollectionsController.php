<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SavingsCollectionResource;
use App\Http\Resources\SavingsCollectionCollection;

class DailySavingsSavingsCollectionsController extends Controller
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

        $savingsCollections = $dailySavings
            ->savingsCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SavingsCollectionCollection($savingsCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('create', SavingsCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'saving_amount' => ['required', 'numeric'],
            'type' => ['required', 'string'],
            'collector_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $savingsCollection = $dailySavings
            ->savingsCollections()
            ->create($validated);

        return new SavingsCollectionResource($savingsCollection);
    }
}
