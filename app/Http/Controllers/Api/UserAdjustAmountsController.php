<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustAmountResource;
use App\Http\Resources\AdjustAmountCollection;

class UserAdjustAmountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $adjustAmounts = $user
            ->adjustAmounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdjustAmountCollection($adjustAmounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', AdjustAmount::class);

        $validated = $request->validate([
            'loan_id' => ['required'],
            'daily_loan_id' => ['required', 'exists:daily_loans,id'],
            'adjust_amount' => ['required', 'numeric'],
            'before_adjust' => ['required', 'numeric'],
            'after_adjust' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $adjustAmount = $user->adjustAmounts()->create($validated);

        return new AdjustAmountResource($adjustAmount);
    }
}
