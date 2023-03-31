<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsPackageResource;
use App\Http\Resources\SpecialDpsPackageCollection;
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
        $this->authorize('view-any', SpecialDpsPackage::class);

        $search = $request->get('search', '');

        $specialDpsPackages = SpecialDpsPackage::search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsPackageCollection($specialDpsPackages);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialDpsPackageStoreRequest $request)
    {
        $this->authorize('create', SpecialDpsPackage::class);

        $validated = $request->validated();

        $specialDpsPackage = SpecialDpsPackage::create($validated);

        return new SpecialDpsPackageResource($specialDpsPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SpecialDpsPackage $specialDpsPackage)
    {
        $this->authorize('view', $specialDpsPackage);

        return new SpecialDpsPackageResource($specialDpsPackage);
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
        $this->authorize('update', $specialDpsPackage);

        $validated = $request->validated();

        $specialDpsPackage->update($validated);

        return new SpecialDpsPackageResource($specialDpsPackage);
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
        $this->authorize('delete', $specialDpsPackage);

        $specialDpsPackage->delete();

        return response()->noContent();
    }
}
