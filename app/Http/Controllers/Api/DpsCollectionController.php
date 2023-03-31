<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DpsCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollectionResource;
use App\Http\Resources\DpsCollectionCollection;
use App\Http\Requests\DpsCollectionStoreRequest;
use App\Http\Requests\DpsCollectionUpdateRequest;

class DpsCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsCollection::class);

        $search = $request->get('search', '');

        $dpsCollections = DpsCollection::search($search)
            ->latest()
            ->paginate();

        return new DpsCollectionCollection($dpsCollections);
    }

    /**
     * @param \App\Http\Requests\DpsCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsCollectionStoreRequest $request)
    {
        $this->authorize('create', DpsCollection::class);

        $validated = $request->validated();

        $dpsCollection = DpsCollection::create($validated);

        return new DpsCollectionResource($dpsCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsCollection $dpsCollection)
    {
        $this->authorize('view', $dpsCollection);

        return new DpsCollectionResource($dpsCollection);
    }

    /**
     * @param \App\Http\Requests\DpsCollectionUpdateRequest $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsCollectionUpdateRequest $request,
        DpsCollection $dpsCollection
    ) {
        $this->authorize('update', $dpsCollection);

        $validated = $request->validated();

        $dpsCollection->update($validated);

        return new DpsCollectionResource($dpsCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsCollection $dpsCollection)
    {
        $this->authorize('delete', $dpsCollection);

        $dpsCollection->delete();

        return response()->noContent();
    }
}
