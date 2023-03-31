<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsResource;
use App\Http\Resources\SpecialDpsCollection;

class SpecialDpsPackageAllSpecialDpsController extends Controller
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

        $allSpecialDps = $specialDpsPackage
            ->allSpecialDps()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsCollection($allSpecialDps);
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
        $this->authorize('create', SpecialDps::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'balance' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ]);

        $specialDps = $specialDpsPackage->allSpecialDps()->create($validated);

        return new SpecialDpsResource($specialDps);
    }
}
