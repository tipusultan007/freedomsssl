<?php

namespace App\Http\Controllers\Api;

use App\Models\TakenLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TakenLoanResource;
use App\Http\Resources\TakenLoanCollection;
use App\Http\Requests\TakenLoanStoreRequest;
use App\Http\Requests\TakenLoanUpdateRequest;

class TakenLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TakenLoan::class);

        $search = $request->get('search', '');

        $takenLoans = TakenLoan::search($search)
            ->latest()
            ->paginate();

        return new TakenLoanCollection($takenLoans);
    }

    /**
     * @param \App\Http\Requests\TakenLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TakenLoanStoreRequest $request)
    {
        $this->authorize('create', TakenLoan::class);

        $validated = $request->validated();

        $takenLoan = TakenLoan::create($validated);

        return new TakenLoanResource($takenLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('view', $takenLoan);

        return new TakenLoanResource($takenLoan);
    }

    /**
     * @param \App\Http\Requests\TakenLoanUpdateRequest $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function update(
        TakenLoanUpdateRequest $request,
        TakenLoan $takenLoan
    ) {
        $this->authorize('update', $takenLoan);

        $validated = $request->validated();

        $takenLoan->update($validated);

        return new TakenLoanResource($takenLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('delete', $takenLoan);

        $takenLoan->delete();

        return response()->noContent();
    }
}
