<?php

namespace App\Http\Controllers\Api;

use App\Models\Fdr;
use Illuminate\Http\Request;
use App\Http\Resources\FdrResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrCollection;
use App\Http\Requests\FdrStoreRequest;
use App\Http\Requests\FdrUpdateRequest;

class FdrController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Fdr::class);

        $search = $request->get('search', '');

        $fdrs = Fdr::search($search)
            ->latest()
            ->paginate();

        return new FdrCollection($fdrs);
    }

    /**
     * @param \App\Http\Requests\FdrStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrStoreRequest $request)
    {
        $this->authorize('create', Fdr::class);

        $validated = $request->validated();

        $fdr = Fdr::create($validated);

        return new FdrResource($fdr);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Fdr $fdr)
    {
        $this->authorize('view', $fdr);

        return new FdrResource($fdr);
    }

    /**
     * @param \App\Http\Requests\FdrUpdateRequest $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function update(FdrUpdateRequest $request, Fdr $fdr)
    {
        $this->authorize('update', $fdr);

        $validated = $request->validated();

        $fdr->update($validated);

        return new FdrResource($fdr);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Fdr $fdr)
    {
        $this->authorize('delete', $fdr);

        $fdr->delete();

        return response()->noContent();
    }
}
