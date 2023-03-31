<?php

namespace App\Http\Controllers\Api;

use App\Models\DpsPackage;
use Illuminate\Http\Request;
use App\Http\Resources\DpsResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollection;

class DpsPackageAllDpsController extends Controller
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

        $allDps = $dpsPackage
            ->allDps()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsCollection($allDps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DpsPackage $dpsPackage)
    {
        $this->authorize('create', Dps::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'balance' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $dps = $dpsPackage->allDps()->create($validated);

        return new DpsResource($dps);
    }
}
