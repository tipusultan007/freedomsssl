<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guarantor;
use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Http\Requests\GuarantorStoreRequest;
use App\Http\Requests\GuarantorUpdateRequest;

class GuarantorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Guarantor::class);

        $search = $request->get('search', '');

        $guarantors = Guarantor::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.guarantors.index', compact('guarantors', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Guarantor::class);

        $users = User::pluck('name', 'id');
        $dailyLoans = DailyLoan::pluck('opening_date', 'id');

        return view('app.guarantors.create', compact('users', 'dailyLoans'));
    }

    /**
     * @param \App\Http\Requests\GuarantorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuarantorStoreRequest $request)
    {
        $this->authorize('create', Guarantor::class);

        $validated = $request->validated();

        $guarantor = Guarantor::create($validated);

        return redirect()
            ->route('guarantors.edit', $guarantor)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Guarantor $guarantor)
    {
        $this->authorize('view', $guarantor);

        return view('app.guarantors.show', compact('guarantor'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Guarantor $guarantor)
    {
        $this->authorize('update', $guarantor);

        $users = User::pluck('name', 'id');
        $dailyLoans = DailyLoan::pluck('opening_date', 'id');

        return view(
            'app.guarantors.edit',
            compact('guarantor', 'users', 'dailyLoans')
        );
    }

    /**
     * @param \App\Http\Requests\GuarantorUpdateRequest $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function update(
        GuarantorUpdateRequest $request,
        Guarantor $guarantor
    ) {
        $this->authorize('update', $guarantor);

        $validated = $request->validated();

        $guarantor->update($validated);

        return redirect()
            ->route('guarantors.edit', $guarantor)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Guarantor $guarantor)
    {
        $this->authorize('delete', $guarantor);

        $guarantor->delete();

        return redirect()
            ->route('guarantors.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
