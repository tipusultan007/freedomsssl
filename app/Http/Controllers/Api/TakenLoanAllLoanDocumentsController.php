<?php

namespace App\Http\Controllers\Api;

use App\Models\TakenLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanDocumentsResource;
use App\Http\Resources\LoanDocumentsCollection;

class TakenLoanAllLoanDocumentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('view', $takenLoan);

        $search = $request->get('search', '');

        $allLoanDocuments = $takenLoan
            ->allLoanDocuments()
            ->search($search)
            ->latest()
            ->paginate();

        return new LoanDocumentsCollection($allLoanDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TakenLoan $takenLoan)
    {
        $this->authorize('create', LoanDocuments::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'document_name' => ['required', 'string'],
            'document_location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'collect_by' => ['required', 'exists:users,id'],
        ]);

        $loanDocuments = $takenLoan->allLoanDocuments()->create($validated);

        return new LoanDocumentsResource($loanDocuments);
    }
}
