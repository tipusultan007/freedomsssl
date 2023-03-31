<?php

namespace App\Http\Controllers;

use App\Models\Dps;
use App\Models\Fdr;
use App\Models\User;
use App\Models\SpecialDps;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\ClosingAccount;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.closing_accounts.index',
            compact('closingAccounts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ClosingAccount::class);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $allSpecialDps = SpecialDps::pluck('account_no', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.closing_accounts.create',
            compact(
                'users',
                'users',
                'allDailySavings',
                'allDps',
                'allSpecialDps',
                'fdrs'
            )
        );
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

        return redirect()
            ->route('closing-accounts.edit', $closingAccount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingAccount $closingAccount)
    {
        $this->authorize('view', $closingAccount);

        return view('app.closing_accounts.show', compact('closingAccount'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingAccount $closingAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ClosingAccount $closingAccount)
    {
        $this->authorize('update', $closingAccount);

        $users = User::pluck('name', 'id');
        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $allSpecialDps = SpecialDps::pluck('account_no', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.closing_accounts.edit',
            compact(
                'closingAccount',
                'users',
                'users',
                'allDailySavings',
                'allDps',
                'allSpecialDps',
                'fdrs'
            )
        );
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

        return redirect()
            ->route('closing-accounts.edit', $closingAccount)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('closing-accounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
