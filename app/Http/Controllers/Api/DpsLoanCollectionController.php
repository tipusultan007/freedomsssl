<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DpsLoanCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanCollectionResource;
use App\Http\Resources\DpsLoanCollectionCollection;
use App\Http\Requests\DpsLoanCollectionStoreRequest;
use App\Http\Requests\DpsLoanCollectionUpdateRequest;

class DpsLoanCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsLoanCollection::class);

        $search = $request->get('search', '');

        $dpsLoanCollections = DpsLoanCollection::search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollectionCollection($dpsLoanCollections);
    }

    /**
     * @param \App\Http\Requests\DpsLoanCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsLoanCollectionStoreRequest $request)
    {
        $this->authorize('create', DpsLoanCollection::class);

        $validated = $request->validated();

        $dpsLoanCollection = DpsLoanCollection::create($validated);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsLoanCollection $dpsLoanCollection)
    {
        $this->authorize('view', $dpsLoanCollection);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }

    /**
     * @param \App\Http\Requests\DpsLoanCollectionUpdateRequest $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsLoanCollectionUpdateRequest $request,
        DpsLoanCollection $dpsLoanCollection
    ) {
        $this->authorize('update', $dpsLoanCollection);

        $validated = $request->validated();

        $dpsLoanCollection->update($validated);

        return new DpsLoanCollectionResource($dpsLoanCollection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoanCollection $dpsLoanCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DpsLoanCollection $dpsLoanCollection
    ) {
        $this->authorize('delete', $dpsLoanCollection);

        $dpsLoanCollection->delete();

        return response()->noContent();
    }
}
