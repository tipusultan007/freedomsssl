<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddProfitResource;
use App\Http\Resources\AddProfitCollection;

class UserAddProfitsController extends Controller
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

        $addProfits = $user
            ->addProfits2()
            ->search($search)
            ->latest()
            ->paginate();

        return new AddProfitCollection($addProfits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', AddProfit::class);

        $validated = $request->validate([
            'daily_savings_id' => ['required', 'exists:daily_savings,id'],
            'account_no' => ['required', 'string'],
            'profit' => ['required', 'numeric'],
            'before_profit' => ['required', 'numeric'],
            'after_profit' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'duration' => ['required', 'string'],
        ]);

        $addProfit = $user->addProfits2()->create($validated);

        return new AddProfitResource($addProfit);
    }
}
