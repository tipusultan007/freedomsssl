<?php

namespace App\Http\Controllers;

use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\Fdr;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
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
        //$this->authorize('view-any', Guarantor::class);

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
        //$this->authorize('create', Guarantor::class);

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
        //$this->authorize('create', Guarantor::class);

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
        //$this->authorize('view', $guarantor);

        return view('app.guarantors.show', compact('guarantor'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guarantor $guarantor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Guarantor $guarantor)
    {
        //$this->authorize('update', $guarantor);

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
        //$this->authorize('update', $guarantor);

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
        //$this->authorize('delete', $guarantor);

        $guarantor->delete();

        return redirect()
            ->route('guarantors.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function getDetails($id)
    {
        $user = User::find($id);
        $savings = Dps::where('user_id', $id)->first();
        $dps = Dps::where('user_id', $id)->where('status','active')->sum('balance');
        $daily_savings = DailySavings::where('user_id', $id)->sum('total');
        $special_dps = SpecialDps::where('user_id', $id)->where('status','active')->sum('balance');
        $daily_loans = DailyLoan::where('user_id', $id)->where('status','active')->sum('balance');
        $fdr = Fdr::where('user_id', $id)->where('status','active')->sum('balance');
        $dps_loans = DpsLoan::where('user_id', $id)->where('status','active')->sum('remain_loan');
        $special_dps_loans = SpecialDpsLoan::where('user_id', $id)->where('status','active')->sum('remain_loan');

        $guarantors = array();
        $guarantorOff = Guarantor::where('user_id',$id)->get();
        if ($guarantorOff)
        {
            foreach ($guarantorOff as $item)
            {
                $guarantors[] = $item->account_no;
            }
        }
        $data['user'] = $user;
        $data['guarantors'] = $guarantors;
        $data['dps'] = $dps.' Tk.';
        $data['fdr'] = $fdr.' Tk.';
        $data['daily_savings'] = $daily_savings.' Tk.';
        $data['special_dps'] = $special_dps.' Tk.';
        $data['daily_loans'] = $daily_loans.' Tk.';
        $data['dps_loans'] = $dps_loans.' Tk.';
        $data['special_dps_loans'] = $special_dps_loans.' Tk.';
        return json_encode($data);
    }
}
