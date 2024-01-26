<?php

namespace App\Http\Controllers;

use App\Models\DpsPackage;
use Illuminate\Http\Request;
use App\Models\DpsPackageValue;
use App\Http\Requests\DpsPackageValueStoreRequest;
use App\Http\Requests\DpsPackageValueUpdateRequest;

class DpsPackageValueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ////$this->authorize('view-any', DpsPackageValue::class);

        $search = $request->get('search', '');

        $dpsPackageValues = DpsPackageValue::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.dps_package_values.index',
            compact('dpsPackageValues', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        ////$this->authorize('create', DpsPackageValue::class);

        $dpsPackages = DpsPackage::pluck('name', 'id');

        return view('app.dps_package_values.create', compact('dpsPackages'));
    }

    /**
     * @param \App\Http\Requests\DpsPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsPackageValueStoreRequest $request)
    {
        ////$this->authorize('create', DpsPackageValue::class);

        $validated = $request->validated();

        $dpsPackageValue = DpsPackageValue::create($validated);

        return redirect()
            ->route('dps-package-values.edit', $dpsPackageValue)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsPackageValue $dpsPackageValue)
    {
        ////$this->authorize('view', $dpsPackageValue);

        return view('app.dps_package_values.show', compact('dpsPackageValue'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsPackageValue $dpsPackageValue)
    {
        ////$this->authorize('update', $dpsPackageValue);

        $dpsPackages = DpsPackage::pluck('name', 'id');

        return view(
            'app.dps_package_values.edit',
            compact('dpsPackageValue', 'dpsPackages')
        );
    }

    /**
     * @param \App\Http\Requests\DpsPackageValueUpdateRequest $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsPackageValueUpdateRequest $request,
        DpsPackageValue $dpsPackageValue
    ) {
        /////$this->authorize('update', $dpsPackageValue);

        $validated = $request->validated();

        $dpsPackageValue->update($validated);

        return redirect()
            ->route('dps-package-values.edit', $dpsPackageValue)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsPackageValue $dpsPackageValue)
    {
       // //$this->authorize('delete', $dpsPackageValue);

        $dpsPackageValue->delete();

        return redirect()
            ->route('dps-package-values.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
