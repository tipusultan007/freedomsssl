<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsLoanResource;
use App\Http\Resources\DpsLoanCollection;
use App\Http\Requests\DpsLoanStoreRequest;
use App\Http\Requests\DpsLoanUpdateRequest;

class DpsLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsLoan::class);

        $search = $request->get('search', '');

        $dpsLoans = DpsLoan::search($search)
            ->latest()
            ->paginate();

        return new DpsLoanCollection($dpsLoans);
    }

    /**
     * @param \App\Http\Requests\DpsLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpsLoanStoreRequest $request)
    {
        $this->authorize('create', DpsLoan::class);

        $validated = $request->validated();

        $dpsLoan = DpsLoan::create($validated);

        return new DpsLoanResource($dpsLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('view', $dpsLoan);

        return new DpsLoanResource($dpsLoan);
    }

    /**
     * @param \App\Http\Requests\DpsLoanUpdateRequest $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function update(DpsLoanUpdateRequest $request, DpsLoan $dpsLoan)
    {
        $this->authorize('update', $dpsLoan);

        $validated = $request->validated();

        $dpsLoan->update($validated);

        return new DpsLoanResource($dpsLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsLoan $dpsLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsLoan $dpsLoan)
    {
        $this->authorize('delete', $dpsLoan);

        $dpsLoan->delete();

        return response()->noContent();
    }
}
