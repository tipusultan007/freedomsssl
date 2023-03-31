<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialLoanTakenResource;
use App\Http\Resources\SpecialLoanTakenCollection;

class UserSpecialLoanTakensController extends Controller
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

        $specialLoanTakens = $user
            ->specialLoanTakens2()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialLoanTakenCollection($specialLoanTakens);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SpecialLoanTaken::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'loan_amount' => ['required', 'numeric'],
            'before_loan' => ['required', 'numeric'],
            'after_loan' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'special_dps_loan_id' => [
                'required',
                'exists:special_dps_loans,id',
            ],
        ]);

        $specialLoanTaken = $user->specialLoanTakens2()->create($validated);

        return new SpecialLoanTakenResource($specialLoanTaken);
    }
}
