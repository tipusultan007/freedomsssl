<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySavingsClosingResource;
use App\Http\Resources\DailySavingsClosingCollection;

class DailySavingsDailySavingsClosingsController extends Controller
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

        $dailySavingsClosings = $dailySavings
            ->dailySavingsClosings()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySavingsClosingCollection($dailySavingsClosings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('create', DailySavingsClosing::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'total_deposit' => ['required', 'numeric'],
            'total_withdraw' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'closing_by' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'closing_fee' => ['required', 'numeric'],
        ]);

        $dailySavingsClosing = $dailySavings
            ->dailySavingsClosings()
            ->create($validated);

        return new DailySavingsClosingResource($dailySavingsClosing);
    }
}
