<?php

namespace App\Http\Controllers\Api;

use App\Models\Fdr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrWithdrawResource;
use App\Http\Resources\FdrWithdrawCollection;

class FdrFdrWithdrawsController extends Controller
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

        $fdrWithdraws = $fdr
            ->fdrWithdraws()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrWithdrawCollection($fdrWithdraws);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fdr $fdr)
    {
        $this->authorize('create', FdrWithdraw::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'fdr_deposit_id' => ['required', 'exists:fdr_deposits,id'],
            'withdraw_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrWithdraw = $fdr->fdrWithdraws()->create($validated);

        return new FdrWithdrawResource($fdrWithdraw);
    }
}
