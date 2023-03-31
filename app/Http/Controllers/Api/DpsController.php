<?php

namespace App\Http\Controllers\Api;

use App\Models\Dps;
use Illuminate\Http\Request;
use App\Http\Resources\DpsResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollection;
use App\Http\Requests\DpsStoreRequest;
use App\Http\Requests\DpsUpdateRequest;

class DpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Dps::class);

        $search = $request->get('search', '');

        $allDps = Dps::search($search)
            ->latest()
            ->paginate();

        return new DpsCollection($allDps);
    }

    /**
     * @param \App\Http\Requests\DpsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsStoreRequest $request)
    {
        $this->authorize('create', Dps::class);

        $validated = $request->validated();

        $dps = Dps::create($validated);

        return new DpsResource($dps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Dps $dps)
    {
        $this->authorize('view', $dps);

        return new DpsResource($dps);
    }

    /**
     * @param \App\Http\Requests\DpsUpdateRequest $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function update(DpsUpdateRequest $request, Dps $dps)
    {
        $this->authorize('update', $dps);

        $validated = $request->validated();

        $dps->update($validated);

        return new DpsResource($dps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Dps $dps)
    {
        $this->authorize('delete', $dps);

        $dps->delete();

        return response()->noContent();
    }
}
