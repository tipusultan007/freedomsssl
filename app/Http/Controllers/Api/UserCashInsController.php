<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashInResource;
use App\Http\Resources\CashInCollection;

class UserCashInsController extends Controller
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

        $cashIns = $user
            ->cashIns2()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashInCollection($cashIns);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', CashIn::class);

        $validated = $request->validate([
            'cashin_category_id' => ['required', 'exists:cashin_categories,id'],
            'account_no' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
        ]);

        $cashIn = $user->cashIns2()->create($validated);

        return new CashInResource($cashIn);
    }
}
