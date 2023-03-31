<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\DpsResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollection;

class UserAllDpsController extends Controller
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

        $allDps = $user
            ->allDps2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsCollection($allDps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Dps::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'dps_package_id' => ['required', 'exists:dps_packages,id'],
            'balance' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
        ]);

        $dps = $user->allDps2()->create($validated);

        return new DpsResource($dps);
    }
}
