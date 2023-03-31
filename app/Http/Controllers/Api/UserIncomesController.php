<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;

class UserIncomesController extends Controller
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

        $incomes = $user
            ->incomes()
            ->search($search)
            ->latest()
            ->paginate();

        return new IncomeCollection($incomes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Income::class);

        $validated = $request->validate([
            'income_category_id' => ['required', 'exists:income_categories,id'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);

        $income = $user->incomes()->create($validated);

        return new IncomeResource($income);
    }
}
