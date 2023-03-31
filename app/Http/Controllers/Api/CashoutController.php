<?php

namespace App\Http\Controllers\Api;

use App\Models\Cashout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashoutResource;
use App\Http\Resources\CashoutCollection;
use App\Http\Requests\CashoutStoreRequest;
use App\Http\Requests\CashoutUpdateRequest;

class CashoutController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Cashout::class);

        $search = $request->get('search', '');

        $cashouts = Cashout::search($search)
            ->latest()
            ->paginate();

        return new CashoutCollection($cashouts);
    }

    /**
     * @param \App\Http\Requests\CashoutStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashoutStoreRequest $request)
    {
        $this->authorize('create', Cashout::class);

        $validated = $request->validated();

        $cashout = Cashout::create($validated);

        return new CashoutResource($cashout);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cashout $cashout)
    {
        $this->authorize('view', $cashout);

        return new CashoutResource($cashout);
    }

    /**
     * @param \App\Http\Requests\CashoutUpdateRequest $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function update(CashoutUpdateRequest $request, Cashout $cashout)
    {
        $this->authorize('update', $cashout);

        $validated = $request->validated();

        $cashout->update($validated);

        return new CashoutResource($cashout);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cashout $cashout)
    {
        $this->authorize('delete', $cashout);

        $cashout->delete();

        return response()->noContent();
    }
}
