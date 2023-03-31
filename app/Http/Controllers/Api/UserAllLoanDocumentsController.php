<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanDocumentsResource;
use App\Http\Resources\LoanDocumentsCollection;

class UserAllLoanDocumentsController extends Controller
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

        $allLoanDocuments = $user
            ->allLoanDocuments()
            ->search($search)
            ->latest()
            ->paginate();

        return new LoanDocumentsCollection($allLoanDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', LoanDocuments::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'document_name' => ['required', 'string'],
            'document_location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'taken_loan_id' => ['required', 'exists:taken_loans,id'],
        ]);

        $loanDocuments = $user->allLoanDocuments()->create($validated);

        return new LoanDocumentsResource($loanDocuments);
    }
}
