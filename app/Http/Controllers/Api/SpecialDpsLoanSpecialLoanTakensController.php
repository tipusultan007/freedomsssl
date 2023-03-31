<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialDpsLoan;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialLoanTakenResource;
use App\Http\Resources\SpecialLoanTakenCollection;

class SpecialDpsLoanSpecialLoanTakensController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsLoan $specialDpsLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SpecialDpsLoan $specialDpsLoan)
    {
        $this->authorize('view', $specialDpsLoan);

        $search = $request->get('search', '');

        $specialLoanTakens = $specialDpsLoan
            ->specialLoanTakens()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialLoanTakenCollection($specialLoanTakens);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsLoan $specialDpsLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SpecialDpsLoan $specialDpsLoan)
    {
        $this->authorize('create', SpecialLoanTaken::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'loan_amount' => ['required', 'numeric'],
            'before_loan' => ['required', 'numeric'],
            'after_loan' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $specialLoanTaken = $specialDpsLoan
            ->specialLoanTakens()
            ->create($validated);

        return new SpecialLoanTakenResource($specialLoanTaken);
    }
}
