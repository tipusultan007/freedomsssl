<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrWithdrawResource;
use App\Http\Resources\FdrWithdrawCollection;

class UserFdrWithdrawsController extends Controller
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

        $fdrWithdraws = $user
            ->fdrWithdraws2()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrWithdrawCollection($fdrWithdraws);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', FdrWithdraw::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'date' => ['required', 'date'],
            'fdr_deposit_id' => ['required', 'exists:fdr_deposits,id'],
            'withdraw_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrWithdraw = $user->fdrWithdraws2()->create($validated);

        return new FdrWithdrawResource($fdrWithdraw);
    }
}
