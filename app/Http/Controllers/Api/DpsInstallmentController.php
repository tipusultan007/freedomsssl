<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsInstallmentResource;
use App\Http\Resources\DpsInstallmentCollection;
use App\Http\Requests\DpsInstallmentStoreRequest;
use App\Http\Requests\DpsInstallmentUpdateRequest;

class DpsInstallmentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsInstallment::class);

        $search = $request->get('search', '');

        $dpsInstallments = DpsInstallment::search($search)
            ->latest()
            ->paginate();

        return new DpsInstallmentCollection($dpsInstallments);
    }

    /**
     * @param \App\Http\Requests\DpsInstallmentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsInstallmentStoreRequest $request)
    {
        $this->authorize('create', DpsInstallment::class);

        $validated = $request->validated();

        $dpsInstallment = DpsInstallment::create($validated);

        return new DpsInstallmentResource($dpsInstallment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('view', $dpsInstallment);

        return new DpsInstallmentResource($dpsInstallment);
    }

    /**
     * @param \App\Http\Requests\DpsInstallmentUpdateRequest $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsInstallmentUpdateRequest $request,
        DpsInstallment $dpsInstallment
    ) {
        $this->authorize('update', $dpsInstallment);

        $validated = $request->validated();

        $dpsInstallment->update($validated);

        return new DpsInstallmentResource($dpsInstallment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('delete', $dpsInstallment);

        $dpsInstallment->delete();

        return response()->noContent();
    }
}
