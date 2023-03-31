<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashoutCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashoutCategoryResource;
use App\Http\Resources\CashoutCategoryCollection;
use App\Http\Requests\CashoutCategoryStoreRequest;
use App\Http\Requests\CashoutCategoryUpdateRequest;

class CashoutCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CashoutCategory::class);

        $search = $request->get('search', '');

        $cashoutCategories = CashoutCategory::search($search)
            ->latest()
            ->paginate();

        return new CashoutCategoryCollection($cashoutCategories);
    }

    /**
     * @param \App\Http\Requests\CashoutCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashoutCategoryStoreRequest $request)
    {
        $this->authorize('create', CashoutCategory::class);

        $validated = $request->validated();

        $cashoutCategory = CashoutCategory::create($validated);

        return new CashoutCategoryResource($cashoutCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashoutCategory $cashoutCategory)
    {
        $this->authorize('view', $cashoutCategory);

        return new CashoutCategoryResource($cashoutCategory);
    }

    /**
     * @param \App\Http\Requests\CashoutCategoryUpdateRequest $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        CashoutCategoryUpdateRequest $request,
        CashoutCategory $cashoutCategory
    ) {
        $this->authorize('update', $cashoutCategory);

        $validated = $request->validated();

        $cashoutCategory->update($validated);

        return new CashoutCategoryResource($cashoutCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashoutCategory $cashoutCategory)
    {
        $this->authorize('delete', $cashoutCategory);

        $cashoutCategory->delete();

        return response()->noContent();
    }
}
