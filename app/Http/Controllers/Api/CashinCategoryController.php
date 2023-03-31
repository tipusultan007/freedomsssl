<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashinCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashinCategoryResource;
use App\Http\Resources\CashinCategoryCollection;
use App\Http\Requests\CashinCategoryStoreRequest;
use App\Http\Requests\CashinCategoryUpdateRequest;

class CashinCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CashinCategory::class);

        $search = $request->get('search', '');

        $cashinCategories = CashinCategory::search($search)
            ->latest()
            ->paginate();

        return new CashinCategoryCollection($cashinCategories);
    }

    /**
     * @param \App\Http\Requests\CashinCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashinCategoryStoreRequest $request)
    {
        $this->authorize('create', CashinCategory::class);

        $validated = $request->validated();

        $cashinCategory = CashinCategory::create($validated);

        return new CashinCategoryResource($cashinCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashinCategory $cashinCategory)
    {
        $this->authorize('view', $cashinCategory);

        return new CashinCategoryResource($cashinCategory);
    }

    /**
     * @param \App\Http\Requests\CashinCategoryUpdateRequest $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        CashinCategoryUpdateRequest $request,
        CashinCategory $cashinCategory
    ) {
        $this->authorize('update', $cashinCategory);

        $validated = $request->validated();

        $cashinCategory->update($validated);

        return new CashinCategoryResource($cashinCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashinCategory $cashinCategory)
    {
        $this->authorize('delete', $cashinCategory);

        $cashinCategory->delete();

        return response()->noContent();
    }
}
