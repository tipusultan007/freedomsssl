<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingAccountResource;
use App\Http\Resources\ClosingAccountCollection;

class UserClosingAccountsController extends Controller
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

        $closingAccounts = $user
            ->closingAccounts2()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingAccountCollection($closingAccounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', ClosingAccount::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'type' => ['nullable', 'string'],
            'deposit' => ['nullable', 'numeric'],
            'Withdraw' => ['nullable', 'numeric'],
            'remain' => ['nullable', 'numeric'],
            'profit' => ['nullable', 'numeric'],
            'service_charge' => ['nullable', 'numeric'],
            'total' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'daily_savings_id' => ['nullable', 'exists:daily_savings,id'],
            'dps_id' => ['nullable', 'exists:dps,id'],
            'special_dps_id' => ['nullable', 'exists:special_dps,id'],
            'fdr_id' => ['nullable', 'exists:fdrs,id'],
        ]);

        $closingAccount = $user->closingAccounts2()->create($validated);

        return new ClosingAccountResource($closingAccount);
    }
}
