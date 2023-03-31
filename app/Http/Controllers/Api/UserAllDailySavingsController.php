<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySavingsResource;
use App\Http\Resources\DailySavingsCollection;

class UserAllDailySavingsController extends Controller
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

        $allDailySavings = $user
            ->allDailySavings2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySavingsCollection($allDailySavings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailySavings::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
            'status' => ['required', 'string'],
        ]);

        $dailySavings = $user->allDailySavings2()->create($validated);

        return new DailySavingsResource($dailySavings);
    }
}
