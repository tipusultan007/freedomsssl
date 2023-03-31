<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrPackageValueResource;
use App\Http\Resources\FdrPackageValueCollection;

class FdrPackageFdrPackageValuesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('view', $fdrPackage);

        $search = $request->get('search', '');

        $fdrPackageValues = $fdrPackage
            ->fdrPackageValues()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrPackageValueCollection($fdrPackageValues);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('create', FdrPackageValue::class);

        $validated = $request->validate([
            'year' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        $fdrPackageValue = $fdrPackage->fdrPackageValues()->create($validated);

        return new FdrPackageValueResource($fdrPackageValue);
    }
}
