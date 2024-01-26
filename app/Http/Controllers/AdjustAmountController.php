<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyLoan;
use App\Models\AdjustAmount;
use Illuminate\Http\Request;
use App\Http\Requests\AdjustAmountStoreRequest;
use App\Http\Requests\AdjustAmountUpdateRequest;

class AdjustAmountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $search = $request->get('search', '');

        $adjustAmounts = AdjustAmount::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.adjust_amounts.index',
            compact('adjustAmounts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $dailyLoans = DailyLoan::pluck('opening_date', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.adjust_amounts.create',
            compact('dailyLoans', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\AdjustAmountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdjustAmountStoreRequest $request)
    {


        $validated = $request->validated();

        $adjustAmount = AdjustAmount::create($validated);

        return redirect()
            ->route('adjust-amounts.edit', $adjustAmount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AdjustAmount $adjustAmount)
    {


        return view('app.adjust_amounts.show', compact('adjustAmount'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AdjustAmount $adjustAmount)
    {


        $dailyLoans = DailyLoan::pluck('opening_date', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.adjust_amounts.edit',
            compact('adjustAmount', 'dailyLoans', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\AdjustAmountUpdateRequest $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function update(
        AdjustAmountUpdateRequest $request,
        AdjustAmount $adjustAmount
    ) {


        $validated = $request->validated();

        $adjustAmount->update($validated);

        return redirect()
            ->route('adjust-amounts.edit', $adjustAmount)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdjustAmount $adjustAmount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdjustAmount $adjustAmount)
    {


        $adjustAmount->delete();

        return redirect()
            ->route('adjust-amounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
