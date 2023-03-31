<?php

namespace App\Http\Controllers\Api;

use App\Models\Fdr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrDepositResource;
use App\Http\Resources\FdrDepositCollection;

class FdrFdrDepositsController extends Controller
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

        $fdrDeposits = $fdr
            ->fdrDeposits()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrDepositCollection($fdrDeposits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fdr $fdr)
    {
        $this->authorize('create', FdrDeposit::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrDeposit = $fdr->fdrDeposits()->create($validated);

        return new FdrDepositResource($fdrDeposit);
    }
}
