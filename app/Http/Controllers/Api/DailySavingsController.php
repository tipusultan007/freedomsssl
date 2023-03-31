<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySavingsResource;
use App\Http\Resources\DailySavingsCollection;
use App\Http\Requests\DailySavingsStoreRequest;
use App\Http\Requests\DailySavingsUpdateRequest;

class DailySavingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailySavings::class);

        $search = $request->get('search', '');

        $allDailySavings = DailySavings::search($search)
            ->latest()
            ->paginate();

        return new DailySavingsCollection($allDailySavings);
    }

    /**
     * @param \App\Http\Requests\DailySavingsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailySavingsStoreRequest $request)
    {
        $this->authorize('create', DailySavings::class);

        $validated = $request->validated();

        $dailySavings = DailySavings::create($validated);

        return new DailySavingsResource($dailySavings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('view', $dailySavings);

        return new DailySavingsResource($dailySavings);
    }

    /**
     * @param \App\Http\Requests\DailySavingsUpdateRequest $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySavingsUpdateRequest $request,
        DailySavings $dailySavings
    ) {
        $this->authorize('update', $dailySavings);

        $validated = $request->validated();

        $dailySavings->update($validated);

        return new DailySavingsResource($dailySavings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('delete', $dailySavings);

        $dailySavings->delete();

        return response()->noContent();
    }
}
