<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialDpsLoan;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsLoanResource;
use App\Http\Resources\SpecialDpsLoanCollection;
use App\Http\Requests\SpecialDpsLoanStoreRequest;
use App\Http\Requests\SpecialDpsLoanUpdateRequest;

class SpecialDpsLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SpecialDpsLoan::class);

        $search = $request->get('search', '');

        $specialDpsLoans = SpecialDpsLoan::search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsLoanCollection($specialDpsLoans);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialDpsLoanStoreRequest $request)
    {
        $this->authorize('create', SpecialDpsLoan::class);

        $validated = $request->validated();

        $specialDpsLoan = SpecialDpsLoan::create($validated);

        return new SpecialDpsLoanResource($specialDpsLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsLoan $specialDpsLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SpecialDpsLoan $specialDpsLoan)
    {
        $this->authorize('view', $specialDpsLoan);

        return new SpecialDpsLoanResource($specialDpsLoan);
    }

    /**
     * @param \App\Http\Requests\SpecialDpsLoanUpdateRequest $request
     * @param \App\Models\SpecialDpsLoan $specialDpsLoan
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialDpsLoanUpdateRequest $request,
        SpecialDpsLoan $specialDpsLoan
    ) {
        $this->authorize('update', $specialDpsLoan);

        $validated = $request->validated();

        $specialDpsLoan->update($validated);

        return new SpecialDpsLoanResource($specialDpsLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsLoan $specialDpsLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SpecialDpsLoan $specialDpsLoan)
    {
        $this->authorize('delete', $specialDpsLoan);

        $specialDpsLoan->delete();

        return response()->noContent();
    }
}
