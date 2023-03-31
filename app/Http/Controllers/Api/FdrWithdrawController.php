<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrWithdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrWithdrawResource;
use App\Http\Resources\FdrWithdrawCollection;
use App\Http\Requests\FdrWithdrawStoreRequest;
use App\Http\Requests\FdrWithdrawUpdateRequest;

class FdrWithdrawController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrWithdraw::class);

        $search = $request->get('search', '');

        $fdrWithdraws = FdrWithdraw::search($search)
            ->latest()
            ->paginate();

        return new FdrWithdrawCollection($fdrWithdraws);
    }

    /**
     * @param \App\Http\Requests\FdrWithdrawStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrWithdrawStoreRequest $request)
    {
        $this->authorize('create', FdrWithdraw::class);

        $validated = $request->validated();

        $fdrWithdraw = FdrWithdraw::create($validated);

        return new FdrWithdrawResource($fdrWithdraw);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrWithdraw $fdrWithdraw)
    {
        $this->authorize('view', $fdrWithdraw);

        return new FdrWithdrawResource($fdrWithdraw);
    }

    /**
     * @param \App\Http\Requests\FdrWithdrawUpdateRequest $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrWithdrawUpdateRequest $request,
        FdrWithdraw $fdrWithdraw
    ) {
        $this->authorize('update', $fdrWithdraw);

        $validated = $request->validated();

        $fdrWithdraw->update($validated);

        return new FdrWithdrawResource($fdrWithdraw);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrWithdraw $fdrWithdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrWithdraw $fdrWithdraw)
    {
        $this->authorize('delete', $fdrWithdraw);

        $fdrWithdraw->delete();

        return response()->noContent();
    }
}
