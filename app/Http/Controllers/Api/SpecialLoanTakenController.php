<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialLoanTaken;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialLoanTakenResource;
use App\Http\Resources\SpecialLoanTakenCollection;
use App\Http\Requests\SpecialLoanTakenStoreRequest;
use App\Http\Requests\SpecialLoanTakenUpdateRequest;

class SpecialLoanTakenController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SpecialLoanTaken::class);

        $search = $request->get('search', '');

        $specialLoanTakens = SpecialLoanTaken::search($search)
            ->latest()
            ->paginate();

        return new SpecialLoanTakenCollection($specialLoanTakens);
    }

    /**
     * @param \App\Http\Requests\SpecialLoanTakenStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialLoanTakenStoreRequest $request)
    {
        $this->authorize('create', SpecialLoanTaken::class);

        $validated = $request->validated();

        $specialLoanTaken = SpecialLoanTaken::create($validated);

        return new SpecialLoanTakenResource($specialLoanTaken);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialLoanTaken $specialLoanTaken
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SpecialLoanTaken $specialLoanTaken)
    {
        $this->authorize('view', $specialLoanTaken);

        return new SpecialLoanTakenResource($specialLoanTaken);
    }

    /**
     * @param \App\Http\Requests\SpecialLoanTakenUpdateRequest $request
     * @param \App\Models\SpecialLoanTaken $specialLoanTaken
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialLoanTakenUpdateRequest $request,
        SpecialLoanTaken $specialLoanTaken
    ) {
        $this->authorize('update', $specialLoanTaken);

        $validated = $request->validated();

        $specialLoanTaken->update($validated);

        return new SpecialLoanTakenResource($specialLoanTaken);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialLoanTaken $specialLoanTaken
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SpecialLoanTaken $specialLoanTaken
    ) {
        $this->authorize('delete', $specialLoanTaken);

        $specialLoanTaken->delete();

        return response()->noContent();
    }
}
