<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrProfit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrProfitResource;
use App\Http\Resources\FdrProfitCollection;
use App\Http\Requests\FdrProfitStoreRequest;
use App\Http\Requests\FdrProfitUpdateRequest;

class FdrProfitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FdrProfit::class);

        $search = $request->get('search', '');

        $fdrProfits = FdrProfit::search($search)
            ->latest()
            ->paginate();

        return new FdrProfitCollection($fdrProfits);
    }

    /**
     * @param \App\Http\Requests\FdrProfitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FdrProfitStoreRequest $request)
    {
        $this->authorize('create', FdrProfit::class);

        $validated = $request->validated();

        $fdrProfit = FdrProfit::create($validated);

        return new FdrProfitResource($fdrProfit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrProfit $fdrProfit)
    {
        $this->authorize('view', $fdrProfit);

        return new FdrProfitResource($fdrProfit);
    }

    /**
     * @param \App\Http\Requests\FdrProfitUpdateRequest $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function update(
        FdrProfitUpdateRequest $request,
        FdrProfit $fdrProfit
    ) {
        $this->authorize('update', $fdrProfit);

        $validated = $request->validated();

        $fdrProfit->update($validated);

        return new FdrProfitResource($fdrProfit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrProfit $fdrProfit)
    {
        $this->authorize('delete', $fdrProfit);

        $fdrProfit->delete();

        return response()->noContent();
    }
}
