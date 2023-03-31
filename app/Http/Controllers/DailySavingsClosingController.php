<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Models\DailySavingsClosing;
use App\Http\Requests\DailySavingsClosingStoreRequest;
use App\Http\Requests\DailySavingsClosingUpdateRequest;

class DailySavingsClosingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailySavingsClosing::class);

        $search = $request->get('search', '');

        $dailySavingsClosings = DailySavingsClosing::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.daily_savings_closings.index',
            compact('dailySavingsClosings', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DailySavingsClosing::class);

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.daily_savings_closings.create',
            compact('allDailySavings', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailySavingsClosingStoreRequest $request)
    {
        $this->authorize('create', DailySavingsClosing::class);

        $validated = $request->validated();

        $dailySavingsClosing = DailySavingsClosing::create($validated);

        return redirect()
            ->route('daily-savings-closings.edit', $dailySavingsClosing)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('view', $dailySavingsClosing);

        return view(
            'app.daily_savings_closings.show',
            compact('dailySavingsClosing')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('update', $dailySavingsClosing);

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.daily_savings_closings.edit',
            compact('dailySavingsClosing', 'allDailySavings', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsClosingUpdateRequest $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySavingsClosingUpdateRequest $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('update', $dailySavingsClosing);

        $validated = $request->validated();

        $dailySavingsClosing->update($validated);

        return redirect()
            ->route('daily-savings-closings.edit', $dailySavingsClosing)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavingsClosing $dailySavingsClosing
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailySavingsClosing $dailySavingsClosing
    ) {
        $this->authorize('delete', $dailySavingsClosing);

        $dailySavingsClosing->delete();

        return redirect()
            ->route('daily-savings-closings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
