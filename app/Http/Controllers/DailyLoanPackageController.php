<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyLoanPackage;
use App\Http\Requests\DailyLoanPackageStoreRequest;
use App\Http\Requests\DailyLoanPackageUpdateRequest;

class DailyLoanPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailyLoanPackage::class);

        $search = $request->get('search', '');

        $dailyLoanPackages = DailyLoanPackage::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.daily_loan_packages.index',
            compact('dailyLoanPackages', 'search')
        );
    }

    public function dailyLoanPackageData(Request $request)
    {
        $packages = DailyLoanPackage::all();

        $data['data'] = $packages;

        return json_encode($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DailyLoanPackage::class);

        return view('app.daily_loan_packages.create');
    }

    /**
     * @param \App\Http\Requests\DailyLoanPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyLoanPackageStoreRequest $request)
    {
        $this->authorize('create', DailyLoanPackage::class);

        $validated = $request->validated();

        $dailyLoanPackage = DailyLoanPackage::create($validated);

       echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        $this->authorize('view', $dailyLoanPackage);

        return view(
            'app.daily_loan_packages.show',
            compact('dailyLoanPackage')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        $this->authorize('update', $dailyLoanPackage);

        return view(
            'app.daily_loan_packages.edit',
            compact('dailyLoanPackage')
        );
    }

    /**
     * @param \App\Http\Requests\DailyLoanPackageUpdateRequest $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailyLoanPackageUpdateRequest $request,
        DailyLoanPackage $dailyLoanPackage
    ) {
        $this->authorize('update', $dailyLoanPackage);

        $validated = $request->validated();

        $dailyLoanPackage->update($validated);

        return redirect()
            ->route('daily-loan-packages.edit', $dailyLoanPackage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $dailyLoanPackage = DailyLoanPackage::find($id);

        $this->authorize('delete', $dailyLoanPackage);

        $dailyLoanPackage->delete();

       echo "success";
    }

    public function getPackageInfo($id)
    {
        $package = DailyLoanPackage::find($id);

        return json_encode($package);
    }
}
