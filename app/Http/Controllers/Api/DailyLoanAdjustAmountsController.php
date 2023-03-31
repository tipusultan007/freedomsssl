<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustAmountResource;
use App\Http\Resources\AdjustAmountCollection;

class DailyLoanAdjustAmountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('view', $dailyLoan);

        $search = $request->get('search', '');

        $adjustAmounts = $dailyLoan
            ->adjustAmounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdjustAmountCollection($adjustAmounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('create', AdjustAmount::class);

        $validated = $request->validate([
            'loan_id' => ['required'],
            'adjust_amount' => ['required', 'numeric'],
            'before_adjust' => ['required', 'numeric'],
            'after_adjust' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'added_by' => ['required', 'exists:users,id'],
        ]);

        $adjustAmount = $dailyLoan->adjustAmounts()->create($validated);

        return new AdjustAmountResource($adjustAmount);
    }
}
