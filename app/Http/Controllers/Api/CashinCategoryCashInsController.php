<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashinCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashInResource;
use App\Http\Resources\CashInCollection;

class CashinCategoryCashInsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CashinCategory $cashinCategory)
    {
        $this->authorize('view', $cashinCategory);

        $search = $request->get('search', '');

        $cashIns = $cashinCategory
            ->cashIns()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashInCollection($cashIns);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashinCategory $cashinCategory)
    {
        $this->authorize('create', CashIn::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'account_no' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $cashIn = $cashinCategory->cashIns()->create($validated);

        return new CashInResource($cashIn);
    }
}
