<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashinCategory;
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


        $search = $request->get('search', '');

        $cashinCategories = CashinCategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.cashin_categories.index',
            compact('cashinCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        return view('app.cashin_categories.create');
    }

    /**
     * @param \App\Http\Requests\CashinCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashinCategoryStoreRequest $request)
    {
        ////$this->authorize('create', CashinCategory::class);

        $validated = $request->validated();

        $cashinCategory = CashinCategory::create($validated);

        return redirect()
            ->route('cashin-categories.edit', $cashinCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashinCategory $cashinCategory)
    {
        ////$this->authorize('view', $cashinCategory);

        return view('app.cashin_categories.show', compact('cashinCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CashinCategory $cashinCategory)
    {
        ////$this->authorize('update', $cashinCategory);

        return view('app.cashin_categories.edit', compact('cashinCategory'));
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
        ////$this->authorize('update', $cashinCategory);

        $validated = $request->validated();

        $cashinCategory->update($validated);

        return redirect()
            ->route('cashin-categories.edit', $cashinCategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashinCategory $cashinCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashinCategory $cashinCategory)
    {
      //  //$this->authorize('delete', $cashinCategory);

        $cashinCategory->delete();

        return redirect()
            ->route('cashin-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
