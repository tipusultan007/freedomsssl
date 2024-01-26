<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Models\SpecialDpsPackageValue;
use App\Http\Requests\SpecialDpsPackageValueStoreRequest;
use App\Http\Requests\SpecialDpsPackageValueUpdateRequest;

class SpecialDpsPackageValueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', SpecialDpsPackageValue::class);

        $search = $request->get('search', '');

        $specialDpsPackageValues = SpecialDpsPackageValue::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.special_dps_package_values.index',
            compact('specialDpsPackageValues', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', SpecialDpsPackageValue::class);

        $specialDpsPackages = SpecialDpsPackage::pluck('name', 'id');

        return view(
            'app.special_dps_package_values.create',
            compact('specialDpsPackages')
        );
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialDpsPackageValueStoreRequest $request)
    {
        //$this->authorize('create', SpecialDpsPackageValue::class);

        $validated = $request->validated();

        $specialDpsPackageValue = SpecialDpsPackageValue::create($validated);

        return redirect()
            ->route('special-dps-package-values.edit', $specialDpsPackageValue)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackageValue $specialDpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        SpecialDpsPackageValue $specialDpsPackageValue
    ) {
        //$this->authorize('view', $specialDpsPackageValue);

        return view(
            'app.special_dps_package_values.show',
            compact('specialDpsPackageValue')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackageValue $specialDpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        SpecialDpsPackageValue $specialDpsPackageValue
    ) {
        //$this->authorize('update', $specialDpsPackageValue);

        $specialDpsPackages = SpecialDpsPackage::pluck('name', 'id');

        return view(
            'app.special_dps_package_values.edit',
            compact('specialDpsPackageValue', 'specialDpsPackages')
        );
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageValueUpdateRequest $request
     * @param \App\Models\SpecialDpsPackageValue $specialDpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialDpsPackageValueUpdateRequest $request,
        SpecialDpsPackageValue $specialDpsPackageValue
    ) {
        //$this->authorize('update', $specialDpsPackageValue);

        $validated = $request->validated();

        $specialDpsPackageValue->update($validated);

        return redirect()
            ->route('special-dps-package-values.edit', $specialDpsPackageValue)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackageValue $specialDpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SpecialDpsPackageValue $specialDpsPackageValue
    ) {
        //$this->authorize('delete', $specialDpsPackageValue);

        $specialDpsPackageValue->delete();

        return redirect()
            ->route('special-dps-package-values.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
