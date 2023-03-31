<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LoanDocuments;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanDocumentsResource;
use App\Http\Resources\LoanDocumentsCollection;
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
        $this->authorize('view-any', LoanDocuments::class);

        $search = $request->get('search', '');

        $allLoanDocuments = LoanDocuments::search($search)
            ->latest()
            ->paginate();

        return new LoanDocumentsCollection($allLoanDocuments);
    }

    /**
     * @param \App\Http\Requests\LoanDocumentsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanDocumentsStoreRequest $request)
    {
        $this->authorize('create', LoanDocuments::class);

        $validated = $request->validated();

        $loanDocuments = LoanDocuments::create($validated);

        return new LoanDocumentsResource($loanDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LoanDocuments $loanDocuments)
    {
        $this->authorize('view', $loanDocuments);

        return new LoanDocumentsResource($loanDocuments);
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
        $this->authorize('update', $loanDocuments);

        $validated = $request->validated();

        $loanDocuments->update($validated);

        return new LoanDocumentsResource($loanDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoanDocuments $loanDocuments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LoanDocuments $loanDocuments)
    {
        $this->authorize('delete', $loanDocuments);

        $loanDocuments->delete();

        return response()->noContent();
    }
}
