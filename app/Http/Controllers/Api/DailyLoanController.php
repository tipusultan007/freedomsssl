<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanResource;
use App\Http\Resources\DailyLoanCollection;
use App\Http\Requests\DailyLoanStoreRequest;
use App\Http\Requests\DailyLoanUpdateRequest;

class DailyLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyLoan::class);

        $search = $request->get('search', '');

        $dailyLoans = DailyLoan::search($search)
            ->latest()
            ->paginate();

        return new DailyLoanCollection($dailyLoans);
    }

    /**
     * @param \App\Http\Requests\DailyLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyLoanStoreRequest $request)
    {
        $this->authorize('create', DailyLoan::class);

        $validated = $request->validated();

        $dailyLoan = DailyLoan::create($validated);

        return new DailyLoanResource($dailyLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('view', $dailyLoan);

        return new DailyLoanResource($dailyLoan);
    }

    /**
     * @param \App\Http\Requests\DailyLoanUpdateRequest $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyLoanUpdateRequest $request,
        DailyLoan $dailyLoan
    ) {
        $this->authorize('update', $dailyLoan);

        $validated = $request->validated();

        $dailyLoan->update($validated);

        return new DailyLoanResource($dailyLoan);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('delete', $dailyLoan);

        $dailyLoan->delete();

        return response()->noContent();
    }
}
