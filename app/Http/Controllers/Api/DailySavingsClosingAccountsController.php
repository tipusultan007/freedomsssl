<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingAccountResource;
use App\Http\Resources\ClosingAccountCollection;

class DailySavingsClosingAccountsController extends Controller
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

        $closingAccounts = $dailySavings
            ->closingAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingAccountCollection($closingAccounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('create', ClosingAccount::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['nullable', 'string'],
            'deposit' => ['nullable', 'numeric'],
            'Withdraw' => ['nullable', 'numeric'],
            'remain' => ['nullable', 'numeric'],
            'profit' => ['nullable', 'numeric'],
            'service_charge' => ['nullable', 'numeric'],
            'total' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'dps_id' => ['nullable', 'exists:dps,id'],
            'special_dps_id' => ['nullable', 'exists:special_dps,id'],
            'fdr_id' => ['nullable', 'exists:fdrs,id'],
        ]);

        $closingAccount = $dailySavings->closingAccounts()->create($validated);

        return new ClosingAccountResource($closingAccount);
    }
}
