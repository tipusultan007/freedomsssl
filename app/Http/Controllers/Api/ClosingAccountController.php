<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingAccountResource;
use App\Http\Resources\ClosingAccountCollection;
use App\Http\Requests\ClosingAccountStoreRequest;
use App\Http\Requests\ClosingAccountUpdateRequest;

class ClosingAccountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ClosingAccount::class);

        $search = $request->get('search', '');

        $closingAccounts = ClosingAccount::search($search)
            ->latest()
            ->paginate();

        return new ClosingAccountCollection($closingAccounts);
    }

    /**
     * @param \App\Http\Requests\ClosingAccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClosingAccountStoreRequest $request)
    {
        $this->authorize('create', ClosingAccount::class);

        $validated = $request->validated();

        $closingAccount = ClosingAccount::create($validated);

        return new ClosingAccountResource($closingAccount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingAccount $closingAccount)
    {
        $this->authorize('view', $closingAccount);

        return new ClosingAccountResource($closingAccount);
    }

    /**
     * @param \App\Http\Requests\ClosingAccountUpdateRequest $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClosingAccountUpdateRequest $request,
        ClosingAccount $closingAccount
    ) {
        $this->authorize('update', $closingAccount);

        $validated = $request->validated();

        $closingAccount->update($validated);

        return new ClosingAccountResource($closingAccount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ClosingAccount $closingAccount)
    {
        $this->authorize('delete', $closingAccount);

        $closingAccount->delete();

        return response()->noContent();
    }
}
