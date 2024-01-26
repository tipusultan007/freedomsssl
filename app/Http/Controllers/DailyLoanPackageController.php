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

        $dailyLoanPackages = DailyLoanPackage::all();

        return view(
            'app.daily_loan_packages.index',
            compact('dailyLoanPackages')
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
        //$this->authorize('create', DailyLoanPackage::class);

        return view('app.daily_loan_packages.create');
    }

    /**
     * @param \App\Http\Requests\DailyLoanPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', DailyLoanPackage::class);

        $validated = $request->all();

        $dailyLoanPackage = DailyLoanPackage::create($validated);

      return redirect()->back()->withSuccess(__('প্যাকেজ তৈরি করা হয়েছে!'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        //$this->authorize('view', $dailyLoanPackage);

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
        //$this->authorize('update', $dailyLoanPackage);

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
    public function update(Request $request,
        DailyLoanPackage $dailyLoanPackage
    ) {
        //$this->authorize('update', $dailyLoanPackage);

        $validated = $request->all();

        $dailyLoanPackage->update($validated);

        return redirect()->back()->withSuccess(__('প্যাকেজ আপডেট করা হয়েছে!'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $dailyLoanPackage = DailyLoanPackage::find($id);

        //$this->authorize('delete', $dailyLoanPackage);

        $dailyLoanPackage->delete();

      return redirect()->back()->withSuccess(__('প্যাকেজ ডিলেট করা হয়েছে!'));
    }

    public function getPackageInfo($id)
    {
        $package = DailyLoanPackage::find($id);

        return json_encode($package);
    }
}
