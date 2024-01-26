<?php

namespace App\Http\Controllers;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Models\FdrPackageValue;
use App\Http\Requests\FdrPackageValueStoreRequest;
use App\Http\Requests\FdrPackageValueUpdateRequest;

class FdrPackageValueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', FdrPackageValue::class);

        $search = $request->get('search', '');

        $fdrPackageValues = FdrPackageValue::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.fdr_package_values.index',
            compact('fdrPackageValues', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', FdrPackageValue::class);

        $fdrPackages = FdrPackage::pluck('name', 'id');

        return view('app.fdr_package_values.create', compact('fdrPackages'));
    }

    /**
     * @param \App\Http\Requests\FdrPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrPackageValueStoreRequest $request)
    {
        //$this->authorize('create', FdrPackageValue::class);

        $validated = $request->validated();

        $fdrPackageValue = FdrPackageValue::create($validated);

        return redirect()
            ->route('fdr-package-values.edit', $fdrPackageValue)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrPackageValue $fdrPackageValue)
    {
        //$this->authorize('view', $fdrPackageValue);

        return view('app.fdr_package_values.show', compact('fdrPackageValue'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrPackageValue $fdrPackageValue)
    {
        //$this->authorize('update', $fdrPackageValue);

        $fdrPackages = FdrPackage::pluck('name', 'id');

        return view(
            'app.fdr_package_values.edit',
            compact('fdrPackageValue', 'fdrPackages')
        );
    }

    /**
     * @param \App\Http\Requests\FdrPackageValueUpdateRequest $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrPackageValueUpdateRequest $request,
        FdrPackageValue $fdrPackageValue
    ) {
        //$this->authorize('update', $fdrPackageValue);

        $validated = $request->validated();

        $fdrPackageValue->update($validated);

        return redirect()
            ->route('fdr-package-values.edit', $fdrPackageValue)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrPackageValue $fdrPackageValue)
    {
        //$this->authorize('delete', $fdrPackageValue);

        $fdrPackageValue->delete();

        return redirect()
            ->route('fdr-package-values.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
