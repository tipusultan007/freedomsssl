<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DailySavingsClosing;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySavingsClosingResource;
use App\Http\Resources\DailySavingsClosingCollection;
use App\Http\Requests\DailySavingsClosingStoreRequest;
use App\Http\Requests\DailySavingsClosingUpdateRequest;

class DailySavingsClosingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailySavingsClosing::class);

        $search = $request->get('search', '');

        $dailySavingsClosings = DailySavingsClosing::search($search)
            ->latest()
            ->paginate();

        return new DailySavingsClosingCollection($dailySavingsClosings);
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailySavingsClosingStoreRequest $request)
    {
        $this->authorize('create', DailySavingsClosing::class);

        $validated = $request->validated();

        $dailySavingsClosing = DailySavingsClosing::create($validated);

        return new DailySavingsClosingResource($dailySavingsClosing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('view', $dailySavingsClosing);

        return new DailySavingsClosingResource($dailySavingsClosing);
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingUpdateRequest $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySavingsClosingUpdateRequest $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('update', $dailySavingsClosing);

        $validated = $request->validated();

        $dailySavingsClosing->update($validated);

        return new DailySavingsClosingResource($dailySavingsClosing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('delete', $dailySavingsClosing);

        $dailySavingsClosing->delete();

        return response()->noContent();
    }
}
