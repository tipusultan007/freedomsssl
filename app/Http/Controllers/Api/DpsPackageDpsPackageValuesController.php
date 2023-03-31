<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsPackageValueResource;
use App\Http\Resources\DpsPackageValueCollection;

class DpsPackageDpsPackageValuesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DpsPackage $dpsPackage)
    {
        $this->authorize('view', $dpsPackage);

        $search = $request->get('search', '');

        $dpsPackageValues = $dpsPackage
            ->dpsPackageValues()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsPackageValueCollection($dpsPackageValues);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DpsPackage $dpsPackage)
    {
        $this->authorize('create', DpsPackageValue::class);

        $validated = $request->validate([
            'year' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        $dpsPackageValue = $dpsPackage->dpsPackageValues()->create($validated);

        return new DpsPackageValueResource($dpsPackageValue);
    }
}
