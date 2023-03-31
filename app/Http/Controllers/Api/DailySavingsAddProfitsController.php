<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddProfitResource;
use App\Http\Resources\AddProfitCollection;

class DailySavingsAddProfitsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('view', $dailySavings);

        $search = $request->get('search', '');

        $addProfits = $dailySavings
            ->addProfits()
            ->search($search)
            ->latest()
            ->paginate();

        return new AddProfitCollection($addProfits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailySavings $dailySavings)
    {
        $this->authorize('create', AddProfit::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'account_no' => ['required', 'string'],
            'profit' => ['required', 'numeric'],
            'before_profit' => ['required', 'numeric'],
            'after_profit' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'duration' => ['required', 'string'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $addProfit = $dailySavings->addProfits()->create($validated);

        return new AddProfitResource($addProfit);
    }
}
