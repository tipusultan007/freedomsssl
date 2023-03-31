<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DailyLoanCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanCollectionResource;
use App\Http\Resources\DailyLoanCollectionCollection;
use App\Http\Requests\DailyLoanCollectionStoreRequest;
use App\Http\Requests\DailyLoanCollectionUpdateRequest;

class DailyLoanCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyLoanCollection::class);

        $search = $request->get('search', '');

        $dailyLoanCollections = DailyLoanCollection::search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollectionCollection($dailyLoanCollections);
    }

    /**
     * @param \App\Http\Requests\DailyLoanCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyLoanCollectionStoreRequest $request)
    {
        $this->authorize('create', DailyLoanCollection::class);

        $validated = $request->validated();

        $dailyLoanCollection = DailyLoanCollection::create($validated);

        return new DailyLoanCollectionResource($dailyLoanCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanCollection $dailyLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        DailyLoanCollection $dailyLoanCollection
    ) {
        $this->authorize('view', $dailyLoanCollection);

        return new DailyLoanCollectionResource($dailyLoanCollection);
    }

    /**
     * @param \App\Http\Requests\DailyLoanCollectionUpdateRequest $request
     * @param \App\Models\DailyLoanCollection $dailyLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyLoanCollectionUpdateRequest $request,
        DailyLoanCollection $dailyLoanCollection
    ) {
        $this->authorize('update', $dailyLoanCollection);

        $validated = $request->validated();

        $dailyLoanCollection->update($validated);

        return new DailyLoanCollectionResource($dailyLoanCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanCollection $dailyLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailyLoanCollection $dailyLoanCollection
    ) {
        $this->authorize('delete', $dailyLoanCollection);

        $dailyLoanCollection->delete();

        return response()->noContent();
    }
}
