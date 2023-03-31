<?php

namespace App\Http\Controllers\Api;

use App\Models\AdjustAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustAmountResource;
use App\Http\Resources\AdjustAmountCollection;
use App\Http\Requests\AdjustAmountStoreRequest;
use App\Http\Requests\AdjustAmountUpdateRequest;

class AdjustAmountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AdjustAmount::class);

        $search = $request->get('search', '');

        $adjustAmounts = AdjustAmount::search($search)
            ->latest()
            ->paginate();

        return new AdjustAmountCollection($adjustAmounts);
    }

    /**
     * @param \App\Http\Requests\AdjustAmountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdjustAmountStoreRequest $request)
    {
        $this->authorize('create', AdjustAmount::class);

        $validated = $request->validated();

        $adjustAmount = AdjustAmount::create($validated);

        return new AdjustAmountResource($adjustAmount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AdjustAmount $adjustAmount)
    {
        $this->authorize('view', $adjustAmount);

        return new AdjustAmountResource($adjustAmount);
    }

    /**
     * @param \App\Http\Requests\AdjustAmountUpdateRequest $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function update(
        AdjustAmountUpdateRequest $request,
        AdjustAmount $adjustAmount
    ) {
        $this->authorize('update', $adjustAmount);

        $validated = $request->validated();

        $adjustAmount->update($validated);

        return new AdjustAmountResource($adjustAmount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdjustAmount $adjustAmount)
    {
        $this->authorize('delete', $adjustAmount);

        $adjustAmount->delete();

        return response()->noContent();
    }
}
