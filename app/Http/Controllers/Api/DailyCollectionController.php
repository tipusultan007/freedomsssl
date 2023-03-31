<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DailyCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyCollectionResource;
use App\Http\Resources\DailyCollectionCollection;
use App\Http\Requests\DailyCollectionStoreRequest;
use App\Http\Requests\DailyCollectionUpdateRequest;

class DailyCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyCollection::class);

        $search = $request->get('search', '');

        $dailyCollections = DailyCollection::search($search)
            ->latest()
            ->paginate();

        return new DailyCollectionCollection($dailyCollections);
    }

    /**
     * @param \App\Http\Requests\DailyCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyCollectionStoreRequest $request)
    {
        $this->authorize('create', DailyCollection::class);

        $validated = $request->validated();

        $dailyCollection = DailyCollection::create($validated);

        return new DailyCollectionResource($dailyCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyCollection $dailyCollection)
    {
        $this->authorize('view', $dailyCollection);

        return new DailyCollectionResource($dailyCollection);
    }

    /**
     * @param \App\Http\Requests\DailyCollectionUpdateRequest $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyCollectionUpdateRequest $request,
        DailyCollection $dailyCollection
    ) {
        $this->authorize('update', $dailyCollection);

        $validated = $request->validated();

        $dailyCollection->update($validated);

        return new DailyCollectionResource($dailyCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyCollection $dailyCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DailyCollection $dailyCollection)
    {
        $this->authorize('delete', $dailyCollection);

        $dailyCollection->delete();

        return response()->noContent();
    }
}
