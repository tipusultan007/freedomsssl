<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class UserExpensesController extends Controller
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

        $expenses = $user
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'expense_category_id' => [
                'required',
                'exists:expense_categories,id',
            ],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);

        $expense = $user->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
