<?php

namespace App\Http\Controllers\Api;

use App\Models\Nominees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NomineesResource;
use App\Http\Resources\NomineesCollection;
use App\Http\Requests\NomineesStoreRequest;
use App\Http\Requests\NomineesUpdateRequest;

class NomineesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Nominees::class);

        $search = $request->get('search', '');

        $allNominees = Nominees::search($search)
            ->latest()
            ->paginate();

        return new NomineesCollection($allNominees);
    }

    /**
     * @param \App\Http\Requests\NomineesStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NomineesStoreRequest $request)
    {
        $this->authorize('create', Nominees::class);

        $validated = $request->validated();

        $nominees = Nominees::create($validated);

        return new NomineesResource($nominees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Nominees $nominees)
    {
        $this->authorize('view', $nominees);

        return new NomineesResource($nominees);
    }

    /**
     * @param \App\Http\Requests\NomineesUpdateRequest $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function update(NomineesUpdateRequest $request, Nominees $nominees)
    {
        $this->authorize('update', $nominees);

        $validated = $request->validated();

        $nominees->update($validated);

        return new NomineesResource($nominees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Nominees $nominees)
    {
        $this->authorize('delete', $nominees);

        $nominees->delete();

        return response()->noContent();
    }
}
