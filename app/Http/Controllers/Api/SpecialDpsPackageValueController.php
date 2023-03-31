<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecialDpsPackageValue;
use App\Http\Resources\SpecialDpsPackageValueResource;
use App\Http\Resources\SpecialDpsPackageValueCollection;
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
        $this->authorize('view-any', SpecialDpsPackageValue::class);

        $search = $request->get('search', '');

        $specialDpsPackageValues = SpecialDpsPackageValue::search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsPackageValueCollection($specialDpsPackageValues);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialDpsPackageValueStoreRequest $request)
    {
        $this->authorize('create', SpecialDpsPackageValue::class);

        $validated = $request->validated();

        $specialDpsPackageValue = SpecialDpsPackageValue::create($validated);

        return new SpecialDpsPackageValueResource($specialDpsPackageValue);
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
        $this->authorize('view', $specialDpsPackageValue);

        return new SpecialDpsPackageValueResource($specialDpsPackageValue);
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
        $this->authorize('update', $specialDpsPackageValue);

        $validated = $request->validated();

        $specialDpsPackageValue->update($validated);

        return new SpecialDpsPackageValueResource($specialDpsPackageValue);
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
        $this->authorize('delete', $specialDpsPackageValue);

        $specialDpsPackageValue->delete();

        return response()->noContent();
    }
}
