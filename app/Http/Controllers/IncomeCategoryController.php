<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
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
        //$this->authorize('view-any', IncomeCategory::class);

        $search = $request->get('search', '');

        $incomeCategories = IncomeCategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.income_categories.index',
            compact('incomeCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', IncomeCategory::class);

        return view('app.income_categories.create');
    }

    /**
     * @param \App\Http\Requests\IncomeCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeCategoryStoreRequest $request)
    {
        //$this->authorize('create', IncomeCategory::class);

        $validated = $request->validated();

        $incomeCategory = IncomeCategory::create($validated);

        return redirect()
            ->route('income-categories.edit', $incomeCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, IncomeCategory $incomeCategory)
    {
        //$this->authorize('view', $incomeCategory);

        return view('app.income_categories.show', compact('incomeCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, IncomeCategory $incomeCategory)
    {
        //$this->authorize('update', $incomeCategory);

        return view('app.income_categories.edit', compact('incomeCategory'));
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
        //$this->authorize('update', $incomeCategory);

        $validated = $request->validated();

        $incomeCategory->update($validated);

        return redirect()
            ->route('income-categories.edit', $incomeCategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IncomeCategory $incomeCategory)
    {
        //$this->authorize('delete', $incomeCategory);

        $incomeCategory->delete();

        return redirect()
            ->route('income-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
