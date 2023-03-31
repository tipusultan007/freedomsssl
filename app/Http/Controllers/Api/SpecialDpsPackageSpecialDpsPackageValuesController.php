<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsPackageValueResource;
use App\Http\Resources\SpecialDpsPackageValueCollection;

class SpecialDpsPackageSpecialDpsPackageValuesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        SpecialDpsPackage $specialDpsPackage
    ) {
        $this->authorize('view', $specialDpsPackage);

        $search = $request->get('search', '');

        $specialDpsPackageValues = $specialDpsPackage
            ->specialDpsPackageValues()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsPackageValueCollection($specialDpsPackageValues);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDpsPackage $specialDpsPackage
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SpecialDpsPackage $specialDpsPackage
    ) {
        $this->authorize('create', SpecialDpsPackageValue::class);

        $validated = $request->validate([
            'year' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        $specialDpsPackageValue = $specialDpsPackage
            ->specialDpsPackageValues()
            ->create($validated);

        return new SpecialDpsPackageValueResource($specialDpsPackageValue);
    }
}
