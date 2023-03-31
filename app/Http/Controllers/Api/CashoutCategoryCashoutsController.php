<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashoutCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashoutResource;
use App\Http\Resources\CashoutCollection;

class CashoutCategoryCashoutsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CashoutCategory $cashoutCategory)
    {
        $this->authorize('view', $cashoutCategory);

        $search = $request->get('search', '');

        $cashouts = $cashoutCategory
            ->cashouts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashoutCollection($cashouts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashoutCategory $cashoutCategory)
    {
        $this->authorize('create', Cashout::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $cashout = $cashoutCategory->cashouts()->create($validated);

        return new CashoutResource($cashout);
    }
}
