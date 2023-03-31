<?php

namespace App\Http\Controllers\Api;

use App\Models\SpecialDps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsResource;
use App\Http\Resources\SpecialDpsCollection;
use App\Http\Requests\SpecialDpsStoreRequest;
use App\Http\Requests\SpecialDpsUpdateRequest;

class SpecialDpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SpecialDps::class);

        $search = $request->get('search', '');

        $allSpecialDps = SpecialDps::search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsCollection($allSpecialDps);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialDpsStoreRequest $request)
    {
        $this->authorize('create', SpecialDps::class);

        $validated = $request->validated();

        $specialDps = SpecialDps::create($validated);

        return new SpecialDpsResource($specialDps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SpecialDps $specialDps)
    {
        $this->authorize('view', $specialDps);

        return new SpecialDpsResource($specialDps);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsUpdateRequest $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialDpsUpdateRequest $request,
        SpecialDps $specialDps
    ) {
        $this->authorize('update', $specialDps);

        $validated = $request->validated();

        $specialDps->update($validated);

        return new SpecialDpsResource($specialDps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SpecialDps $specialDps)
    {
        $this->authorize('delete', $specialDps);

        $specialDps->delete();

        return response()->noContent();
    }
}
