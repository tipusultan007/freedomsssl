<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SavingsCollectionResource;
use App\Http\Resources\SavingsCollectionCollection;

class UserSavingsCollectionsController extends Controller
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

        $savingsCollections = $user
            ->savingsCollections2()
            ->search($search)
            ->latest()
            ->paginate();

        return new SavingsCollectionCollection($savingsCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SavingsCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'daily_savings_id' => ['required', 'exists:daily_savings,id'],
            'saving_amount' => ['required', 'numeric'],
            'type' => ['required', 'string'],
            'date' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
        ]);

        $savingsCollection = $user->savingsCollections2()->create($validated);

        return new SavingsCollectionResource($savingsCollection);
    }
}
