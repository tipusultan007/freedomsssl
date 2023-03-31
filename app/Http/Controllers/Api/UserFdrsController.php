<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\FdrResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrCollection;

class UserFdrsController extends Controller
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

        $fdrs = $user
            ->fdrs()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrCollection($fdrs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Fdr::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'duration' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'fdr_amount' => ['nullable', 'numeric'],
            'deposit_date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'note' => ['nullable', 'string'],
        ]);

        $fdr = $user->fdrs()->create($validated);

        return new FdrResource($fdr);
    }
}
