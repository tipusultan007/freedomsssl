<?php

namespace App\Http\Controllers\Api;

use App\Models\SpecialDps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingAccountResource;
use App\Http\Resources\ClosingAccountCollection;

class SpecialDpsClosingAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SpecialDps $specialDps)
    {
        $this->authorize('view', $specialDps);

        $search = $request->get('search', '');

        $closingAccounts = $specialDps
            ->closingAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingAccountCollection($closingAccounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SpecialDps $specialDps)
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
            'daily_savings_id' => ['nullable', 'exists:daily_savings,id'],
            'dps_id' => ['nullable', 'exists:dps,id'],
            'fdr_id' => ['nullable', 'exists:fdrs,id'],
        ]);

        $closingAccount = $specialDps->closingAccounts()->create($validated);

        return new ClosingAccountResource($closingAccount);
    }
}
