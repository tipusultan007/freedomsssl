<?php

namespace App\Http\Controllers\Api;

use App\Models\Fdr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingAccountResource;
use App\Http\Resources\ClosingAccountCollection;

class FdrClosingAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Fdr $fdr)
    {
        $this->authorize('view', $fdr);

        $search = $request->get('search', '');

        $closingAccounts = $fdr
            ->closingAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingAccountCollection($closingAccounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fdr $fdr)
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
            'special_dps_id' => ['nullable', 'exists:special_dps,id'],
        ]);

        $closingAccount = $fdr->closingAccounts()->create($validated);

        return new ClosingAccountResource($closingAccount);
    }
}
