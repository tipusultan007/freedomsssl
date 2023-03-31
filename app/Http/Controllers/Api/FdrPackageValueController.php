<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FdrPackageValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrPackageValueResource;
use App\Http\Resources\FdrPackageValueCollection;
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
        $this->authorize('view-any', FdrPackageValue::class);

        $search = $request->get('search', '');

        $fdrPackageValues = FdrPackageValue::search($search)
            ->latest()
            ->paginate();

        return new FdrPackageValueCollection($fdrPackageValues);
    }

    /**
     * @param \App\Http\Requests\FdrPackageValueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrPackageValueStoreRequest $request)
    {
        $this->authorize('create', FdrPackageValue::class);

        $validated = $request->validated();

        $fdrPackageValue = FdrPackageValue::create($validated);

        return new FdrPackageValueResource($fdrPackageValue);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrPackageValue $fdrPackageValue)
    {
        $this->authorize('view', $fdrPackageValue);

        return new FdrPackageValueResource($fdrPackageValue);
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
        $this->authorize('update', $fdrPackageValue);

        $validated = $request->validated();

        $fdrPackageValue->update($validated);

        return new FdrPackageValueResource($fdrPackageValue);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackageValue $fdrPackageValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrPackageValue $fdrPackageValue)
    {
        $this->authorize('delete', $fdrPackageValue);

        $fdrPackageValue->delete();

        return response()->noContent();
    }
}
