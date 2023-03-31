<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NomineesResource;
use App\Http\Resources\NomineesCollection;

class UserAllNomineesController extends Controller
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

        $allNominees = $user
            ->allNominees()
            ->search($search)
            ->latest()
            ->paginate();

        return new NomineesCollection($allNominees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Nominees::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'relation' => ['required', 'string'],
            'address' => ['required', 'string'],
            'percentage' => ['required', 'numeric'],
        ]);

        $nominees = $user->allNominees()->create($validated);

        return new NomineesResource($nominees);
    }
}
