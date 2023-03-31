<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySavingsClosingResource;
use App\Http\Resources\DailySavingsClosingCollection;

class UserDailySavingsClosingsController extends Controller
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

        $dailySavingsClosings = $user
            ->dailySavingsClosings()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySavingsClosingCollection($dailySavingsClosings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailySavingsClosing::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'daily_savings_id' => ['required', 'exists:daily_savings,id'],
            'total_deposit' => ['required', 'numeric'],
            'total_withdraw' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'closing_fee' => ['required', 'numeric'],
        ]);

        $dailySavingsClosing = $user
            ->dailySavingsClosings()
            ->create($validated);

        return new DailySavingsClosingResource($dailySavingsClosing);
    }
}
