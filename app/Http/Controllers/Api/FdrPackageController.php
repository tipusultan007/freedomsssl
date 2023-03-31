<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrPackageResource;
use App\Http\Resources\FdrPackageCollection;
use App\Http\Requests\FdrPackageStoreRequest;
use App\Http\Requests\FdrPackageUpdateRequest;

class FdrPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrPackage::class);

        $search = $request->get('search', '');

        $fdrPackages = FdrPackage::search($search)
            ->latest()
            ->paginate();

        return new FdrPackageCollection($fdrPackages);
    }

    /**
     * @param \App\Http\Requests\FdrPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrPackageStoreRequest $request)
    {
        $this->authorize('create', FdrPackage::class);

        $validated = $request->validated();

        $fdrPackage = FdrPackage::create($validated);

        return new FdrPackageResource($fdrPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('view', $fdrPackage);

        return new FdrPackageResource($fdrPackage);
    }

    /**
     * @param \App\Http\Requests\FdrPackageUpdateRequest $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrPackageUpdateRequest $request,
        FdrPackage $fdrPackage
    ) {
        $this->authorize('update', $fdrPackage);

        $validated = $request->validated();

        $fdrPackage->update($validated);

        return new FdrPackageResource($fdrPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('delete', $fdrPackage);

        $fdrPackage->delete();

        return response()->noContent();
    }
}
