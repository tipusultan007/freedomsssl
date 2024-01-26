<?php

namespace App\Http\Controllers;

use App\Models\SpecialDpsPackageValue;
use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Requests\SpecialDpsPackageStoreRequest;
use App\Http\Requests\SpecialDpsPackageUpdateRequest;

class SpecialDpsPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', SpecialDpsPackage::class);

        $search = $request->get('search', '');

        $dpsPackages = SpecialDpsPackage::orderBy('amount','asc')->get();

        return view(
            'app.special_dps_packages.index',
            compact('dpsPackages', )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', SpecialDpsPackage::class);

        return view('app.special_dps_packages.create');
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', SpecialDpsPackage::class);

        $data = $request->all();
        $years = $request->year;
        $principal_profits = $request->principal_profit;
        $dpsPackage = SpecialDpsPackage::create($data);
        foreach ($years as $key => $row)
        {
            $dpsPackageValue = new SpecialDpsPackageValue();
            $dpsPackageValue->special_dps_package_id = $dpsPackage->id;
            $dpsPackageValue->year = $row;
            $dpsPackageValue->amount = $principal_profits[$key];
            $dpsPackageValue->save();
        }

        return "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SpecialDpsPackage $specialDpsPackage)
    {
        //$this->authorize('view', $specialDpsPackage);

        return view(
            'app.special_dps_packages.show',
            compact('specialDpsPackage')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SpecialDpsPackage $specialDpsPackage)
    {
        //$this->authorize('update', $specialDpsPackage);

        return view(
            'app.special_dps_packages.edit',
            compact('specialDpsPackage')
        );
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageUpdateRequest $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialDpsPackageUpdateRequest $request,
        SpecialDpsPackage $specialDpsPackage
    ) {
        //$this->authorize('update', $specialDpsPackage);

        $validated = $request->validated();

        $specialDpsPackage->update($validated);

        return redirect()
            ->route('special-dps-packages.edit', $specialDpsPackage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SpecialDpsPackage $specialDpsPackage
    ) {
        //$this->authorize('delete', $specialDpsPackage);

        $specialDpsPackage->delete();

        return redirect()
            ->route('special-dps-packages.index')
            ->withSuccess(__('crud.common.removed'));
    }

}
