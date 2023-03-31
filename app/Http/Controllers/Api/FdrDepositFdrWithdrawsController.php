<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrDeposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrWithdrawResource;
use App\Http\Resources\FdrWithdrawCollection;

class FdrDepositFdrWithdrawsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('view', $fdrDeposit);

        $search = $request->get('search', '');

        $fdrWithdraws = $fdrDeposit
            ->fdrWithdraws()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrWithdrawCollection($fdrWithdraws);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('create', FdrWithdraw::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'date' => ['required', 'date'],
            'withdraw_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrWithdraw = $fdrDeposit->fdrWithdraws()->create($validated);

        return new FdrWithdrawResource($fdrWithdraw);
    }
}
