<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrDepositResource;
use App\Http\Resources\FdrDepositCollection;

class UserFdrDepositsController extends Controller
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

        $fdrDeposits = $user
            ->fdrDeposits2()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrDepositCollection($fdrDeposits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', FdrDeposit::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'amount' => ['required', 'numeric'],
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrDeposit = $user->fdrDeposits2()->create($validated);

        return new FdrDepositResource($fdrDeposit);
    }
}
