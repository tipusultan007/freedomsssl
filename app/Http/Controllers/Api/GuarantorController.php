<?php

namespace App\Http\Controllers\Api;

use App\Models\Guarantor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuarantorResource;
use App\Http\Resources\GuarantorCollection;
use App\Http\Requests\GuarantorStoreRequest;
use App\Http\Requests\GuarantorUpdateRequest;

class GuarantorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Guarantor::class);

        $search = $request->get('search', '');

        $guarantors = Guarantor::search($search)
            ->latest()
            ->paginate();

        return new GuarantorCollection($guarantors);
    }

    /**
     * @param \App\Http\Requests\GuarantorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuarantorStoreRequest $request)
    {
        $this->authorize('create', Guarantor::class);

        $validated = $request->validated();

        $guarantor = Guarantor::create($validated);

        return new GuarantorResource($guarantor);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Guarantor $guarantor)
    {
        $this->authorize('view', $guarantor);

        return new GuarantorResource($guarantor);
    }

    /**
     * @param \App\Http\Requests\GuarantorUpdateRequest $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function update(
        GuarantorUpdateRequest $request,
        Guarantor $guarantor
    ) {
        $this->authorize('update', $guarantor);

        $validated = $request->validated();

        $guarantor->update($validated);

        return new GuarantorResource($guarantor);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Guarantor $guarantor)
    {
        $this->authorize('delete', $guarantor);

        $guarantor->delete();

        return response()->noContent();
    }
}
