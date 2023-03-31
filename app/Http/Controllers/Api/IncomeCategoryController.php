<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeCategoryResource;
use App\Http\Resources\IncomeCategoryCollection;
use App\Http\Requests\IncomeCategoryStoreRequest;
use App\Http\Requests\IncomeCategoryUpdateRequest;

class IncomeCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', IncomeCategory::class);

        $search = $request->get('search', '');

        $incomeCategories = IncomeCategory::search($search)
            ->latest()
            ->paginate();

        return new IncomeCategoryCollection($incomeCategories);
    }

    /**
     * @param \App\Http\Requests\IncomeCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeCategoryStoreRequest $request)
    {
        $this->authorize('create', IncomeCategory::class);

        $validated = $request->validated();

        $incomeCategory = IncomeCategory::create($validated);

        return new IncomeCategoryResource($incomeCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, IncomeCategory $incomeCategory)
    {
        $this->authorize('view', $incomeCategory);

        return new IncomeCategoryResource($incomeCategory);
    }

    /**
     * @param \App\Http\Requests\IncomeCategoryUpdateRequest $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        IncomeCategoryUpdateRequest $request,
        IncomeCategory $incomeCategory
    ) {
        $this->authorize('update', $incomeCategory);

        $validated = $request->validated();

        $incomeCategory->update($validated);

        return new IncomeCategoryResource($incomeCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IncomeCategory $incomeCategory)
    {
        $this->authorize('delete', $incomeCategory);

        $incomeCategory->delete();

        return response()->noContent();
    }
}
