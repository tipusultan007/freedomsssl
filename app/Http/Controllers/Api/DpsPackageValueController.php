<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DpsPackageValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsPackageValueResource;
use App\Http\Resources\DpsPackageValueCollection;
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
        $this->authorize('view-any', DpsPackageValue::class);

        $search = $request->get('search', '');

        $dpsPackageValues = DpsPackageValue::search($search)
            ->latest()
            ->paginate();

        return new DpsPackageValueCollection($dpsPackageValues);
    }

    /**
     * @param \App\Http\Requests\DpsPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsPackageValueStoreRequest $request)
    {
        $this->authorize('create', DpsPackageValue::class);

        $validated = $request->validated();

        $dpsPackageValue = DpsPackageValue::create($validated);

        return new DpsPackageValueResource($dpsPackageValue);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsPackageValue $dpsPackageValue)
    {
        $this->authorize('view', $dpsPackageValue);

        return new DpsPackageValueResource($dpsPackageValue);
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
        $this->authorize('update', $dpsPackageValue);

        $validated = $request->validated();

        $dpsPackageValue->update($validated);

        return new DpsPackageValueResource($dpsPackageValue);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackageValue $dpsPackageValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsPackageValue $dpsPackageValue)
    {
        $this->authorize('delete', $dpsPackageValue);

        $dpsPackageValue->delete();

        return response()->noContent();
    }
}
