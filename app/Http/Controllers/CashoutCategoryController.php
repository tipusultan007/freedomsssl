<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashoutCategory;
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
        //$this->authorize('view-any', CashoutCategory::class);

        $search = $request->get('search', '');

        $cashoutCategories = CashoutCategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.cashout_categories.index',
            compact('cashoutCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', CashoutCategory::class);

        return view('app.cashout_categories.create');
    }

    /**
     * @param \App\Http\Requests\CashoutCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashoutCategoryStoreRequest $request)
    {
        //$this->authorize('create', CashoutCategory::class);

        $validated = $request->validated();

        $cashoutCategory = CashoutCategory::create($validated);

        return redirect()
            ->route('cashout-categories.edit', $cashoutCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashoutCategory $cashoutCategory)
    {
        //$this->authorize('view', $cashoutCategory);

        return view('app.cashout_categories.show', compact('cashoutCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CashoutCategory $cashoutCategory)
    {
        //$this->authorize('update', $cashoutCategory);

        return view('app.cashout_categories.edit', compact('cashoutCategory'));
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
        //$this->authorize('update', $cashoutCategory);

        $validated = $request->validated();

        $cashoutCategory->update($validated);

        return redirect()
            ->route('cashout-categories.edit', $cashoutCategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashoutCategory $cashoutCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashoutCategory $cashoutCategory)
    {
        //$this->authorize('delete', $cashoutCategory);

        $cashoutCategory->delete();

        return redirect()
            ->route('cashout-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
