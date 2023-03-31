<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SavingsCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\SavingsCollectionResource;
use App\Http\Resources\SavingsCollectionCollection;
use App\Http\Requests\SavingsCollectionStoreRequest;
use App\Http\Requests\SavingsCollectionUpdateRequest;

class SavingsCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SavingsCollection::class);

        $search = $request->get('search', '');

        $savingsCollections = SavingsCollection::search($search)
            ->latest()
            ->paginate();

        return new SavingsCollectionCollection($savingsCollections);
    }

    /**
     * @param \App\Http\Requests\SavingsCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavingsCollectionStoreRequest $request)
    {
        $this->authorize('create', SavingsCollection::class);

        $validated = $request->validated();

        $savingsCollection = SavingsCollection::create($validated);

        return new SavingsCollectionResource($savingsCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SavingsCollection $savingsCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SavingsCollection $savingsCollection)
    {
        $this->authorize('view', $savingsCollection);

        return new SavingsCollectionResource($savingsCollection);
    }

    /**
     * @param \App\Http\Requests\SavingsCollectionUpdateRequest $request
     * @param \App\Models\SavingsCollection $savingsCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        SavingsCollectionUpdateRequest $request,
        SavingsCollection $savingsCollection
    ) {
        $this->authorize('update', $savingsCollection);

        $validated = $request->validated();

        $savingsCollection->update($validated);

        return new SavingsCollectionResource($savingsCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SavingsCollection $savingsCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SavingsCollection $savingsCollection
    ) {
        $this->authorize('delete', $savingsCollection);

        $savingsCollection->delete();

        return response()->noContent();
    }
}
