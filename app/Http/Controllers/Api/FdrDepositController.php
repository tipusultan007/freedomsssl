<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrDeposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrDepositResource;
use App\Http\Resources\FdrDepositCollection;
use App\Http\Requests\FdrDepositStoreRequest;
use App\Http\Requests\FdrDepositUpdateRequest;

class FdrDepositController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrDeposit::class);

        $search = $request->get('search', '');

        $fdrDeposits = FdrDeposit::search($search)
            ->latest()
            ->paginate();

        return new FdrDepositCollection($fdrDeposits);
    }

    /**
     * @param \App\Http\Requests\FdrDepositStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrDepositStoreRequest $request)
    {
        $this->authorize('create', FdrDeposit::class);

        $validated = $request->validated();

        $fdrDeposit = FdrDeposit::create($validated);

        return new FdrDepositResource($fdrDeposit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('view', $fdrDeposit);

        return new FdrDepositResource($fdrDeposit);
    }

    /**
     * @param \App\Http\Requests\FdrDepositUpdateRequest $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrDepositUpdateRequest $request,
        FdrDeposit $fdrDeposit
    ) {
        $this->authorize('update', $fdrDeposit);

        $validated = $request->validated();

        $fdrDeposit->update($validated);

        return new FdrDepositResource($fdrDeposit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrDeposit $fdrDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrDeposit $fdrDeposit)
    {
        $this->authorize('delete', $fdrDeposit);

        $fdrDeposit->delete();

        return response()->noContent();
    }
}
