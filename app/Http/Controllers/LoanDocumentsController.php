<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TakenLoan;
use Illuminate\Http\Request;
use App\Models\LoanDocuments;
use App\Http\Requests\LoanDocumentsStoreRequest;
use App\Http\Requests\LoanDocumentsUpdateRequest;

class LoanDocumentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', LoanDocuments::class);

        $search = $request->get('search', '');

        $allLoanDocuments = LoanDocuments::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.all_loan_documents.index',
            compact('allLoanDocuments', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', LoanDocuments::class);

        $takenLoans = TakenLoan::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.all_loan_documents.create',
            compact('takenLoans', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\LoanDocumentsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanDocumentsStoreRequest $request)
    {
        //$this->authorize('create', LoanDocuments::class);

        $validated = $request->validated();

        $loanDocuments = LoanDocuments::create($validated);

        return redirect()
            ->route('all-loan-documents.edit', $loanDocuments)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LoanDocuments $loanDocuments)
    {
        //$this->authorize('view', $loanDocuments);

        return view('app.all_loan_documents.show', compact('loanDocuments'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, LoanDocuments $loanDocuments)
    {
        //$this->authorize('update', $loanDocuments);

        $takenLoans = TakenLoan::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.all_loan_documents.edit',
            compact('loanDocuments', 'takenLoans', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\LoanDocumentsUpdateRequest $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function update(
        LoanDocumentsUpdateRequest $request,
        LoanDocuments $loanDocuments
    ) {
        //$this->authorize('update', $loanDocuments);

        $validated = $request->validated();

        $loanDocuments->update($validated);

        return redirect()
            ->route('all-loan-documents.edit', $loanDocuments)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LoanDocuments $loanDocuments)
    {
        //$this->authorize('delete', $loanDocuments);

        $loanDocuments->delete();

        return redirect()
            ->route('all-loan-documents.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
