<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DailyLoanPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyLoanPackageResource;
use App\Http\Resources\DailyLoanPackageCollection;
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
            ->paginate();

        return new DailyLoanPackageCollection($dailyLoanPackages);
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

        return new DailyLoanPackageResource($dailyLoanPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailyLoanPackage $dailyLoanPackage)
    {
        $this->authorize('view', $dailyLoanPackage);

        return new DailyLoanPackageResource($dailyLoanPackage);
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

        return new DailyLoanPackageResource($dailyLoanPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoanPackage $dailyLoanPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailyLoanPackage $dailyLoanPackage
    ) {
        $this->authorize('delete', $dailyLoanPackage);

        $dailyLoanPackage->delete();

        return response()->noContent();
    }
}
