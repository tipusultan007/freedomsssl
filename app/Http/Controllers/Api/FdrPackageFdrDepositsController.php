<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrDepositResource;
use App\Http\Resources\FdrDepositCollection;

class FdrPackageFdrDepositsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('view', $fdrPackage);

        $search = $request->get('search', '');

        $fdrDeposits = $fdrPackage
            ->fdrDeposits()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrDepositCollection($fdrDeposits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('create', FdrDeposit::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrDeposit = $fdrPackage->fdrDeposits()->create($validated);

        return new FdrDepositResource($fdrDeposit);
    }
}
