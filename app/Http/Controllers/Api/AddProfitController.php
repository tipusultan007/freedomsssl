<?php

namespace App\Http\Controllers\Api;

use App\Models\AddProfit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddProfitResource;
use App\Http\Resources\AddProfitCollection;
use App\Http\Requests\AddProfitStoreRequest;
use App\Http\Requests\AddProfitUpdateRequest;

class AddProfitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AddProfit::class);

        $search = $request->get('search', '');

        $addProfits = AddProfit::search($search)
            ->latest()
            ->paginate();

        return new AddProfitCollection($addProfits);
    }

    /**
     * @param \App\Http\Requests\AddProfitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProfitStoreRequest $request)
    {
        $this->authorize('create', AddProfit::class);

        $validated = $request->validated();

        $addProfit = AddProfit::create($validated);

        return new AddProfitResource($addProfit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AddProfit $addProfit)
    {
        $this->authorize('view', $addProfit);

        return new AddProfitResource($addProfit);
    }

    /**
     * @param \App\Http\Requests\AddProfitUpdateRequest $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function update(
        AddProfitUpdateRequest $request,
        AddProfit $addProfit
    ) {
        $this->authorize('update', $addProfit);

        $validated = $request->validated();

        $addProfit->update($validated);

        return new AddProfitResource($addProfit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AddProfit $addProfit)
    {
        $this->authorize('delete', $addProfit);

        $addProfit->delete();

        return response()->noContent();
    }
}
