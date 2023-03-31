<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialDpsResource;
use App\Http\Resources\SpecialDpsCollection;

class UserAllSpecialDpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $allSpecialDps = $user
            ->allSpecialDps2()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpecialDpsCollection($allSpecialDps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SpecialDps::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'special_dps_package_id' => [
                'required',
                'exists:special_dps_packages,id',
            ],
            'balance' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
        ]);

        $specialDps = $user->allSpecialDps2()->create($validated);

        return new SpecialDpsResource($specialDps);
    }
}
