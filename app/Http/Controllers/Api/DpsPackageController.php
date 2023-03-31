<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsPackageResource;
use App\Http\Resources\DpsPackageCollection;
use App\Http\Requests\DpsPackageStoreRequest;
use App\Http\Requests\DpsPackageUpdateRequest;

class DpsPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsPackage::class);

        $search = $request->get('search', '');

        $dpsPackages = DpsPackage::search($search)
            ->latest()
            ->paginate();

        return new DpsPackageCollection($dpsPackages);
    }

    /**
     * @param \App\Http\Requests\DpsPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsPackageStoreRequest $request)
    {
        $this->authorize('create', DpsPackage::class);

        $validated = $request->validated();

        $dpsPackage = DpsPackage::create($validated);

        return new DpsPackageResource($dpsPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsPackage $dpsPackage)
    {
        $this->authorize('view', $dpsPackage);

        return new DpsPackageResource($dpsPackage);
    }

    /**
     * @param \App\Http\Requests\DpsPackageUpdateRequest $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsPackageUpdateRequest $request,
        DpsPackage $dpsPackage
    ) {
        $this->authorize('update', $dpsPackage);

        $validated = $request->validated();

        $dpsPackage->update($validated);

        return new DpsPackageResource($dpsPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsPackage $dpsPackage)
    {
        $this->authorize('delete', $dpsPackage);

        $dpsPackage->delete();

        return response()->noContent();
    }
}
