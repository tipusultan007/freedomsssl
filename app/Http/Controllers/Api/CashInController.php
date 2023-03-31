<?php

namespace App\Http\Controllers\Api;

use App\Models\CashIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashInResource;
use App\Http\Resources\CashInCollection;
use App\Http\Requests\CashInStoreRequest;
use App\Http\Requests\CashInUpdateRequest;

class CashInController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CashIn::class);

        $search = $request->get('search', '');

        $cashIns = CashIn::search($search)
            ->latest()
            ->paginate();

        return new CashInCollection($cashIns);
    }

    /**
     * @param \App\Http\Requests\CashInStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashInStoreRequest $request)
    {
        $this->authorize('create', CashIn::class);

        $validated = $request->validated();

        $cashIn = CashIn::create($validated);

        return new CashInResource($cashIn);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashIn $cashIn)
    {
        $this->authorize('view', $cashIn);

        return new CashInResource($cashIn);
    }

    /**
     * @param \App\Http\Requests\CashInUpdateRequest $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function update(CashInUpdateRequest $request, CashIn $cashIn)
    {
        $this->authorize('update', $cashIn);

        $validated = $request->validated();

        $cashIn->update($validated);

        return new CashInResource($cashIn);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashIn $cashIn)
    {
        $this->authorize('delete', $cashIn);

        $cashIn->delete();

        return response()->noContent();
    }
}
