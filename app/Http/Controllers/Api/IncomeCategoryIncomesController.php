<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;

class IncomeCategoryIncomesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, IncomeCategory $incomeCategory)
    {
        $this->authorize('view', $incomeCategory);

        $search = $request->get('search', '');

        $incomes = $incomeCategory
            ->incomes()
            ->search($search)
            ->latest()
            ->paginate();

        return new IncomeCollection($incomes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncomeCategory $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IncomeCategory $incomeCategory)
    {
        $this->authorize('create', Income::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $income = $incomeCategory->incomes()->create($validated);

        return new IncomeResource($income);
    }
}
