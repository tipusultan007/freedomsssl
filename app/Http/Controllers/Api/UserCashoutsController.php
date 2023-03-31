<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashoutResource;
use App\Http\Resources\CashoutCollection;

class UserCashoutsController extends Controller
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

        $cashouts = $user
            ->cashouts2()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashoutCollection($cashouts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Cashout::class);

        $validated = $request->validate([
            'cashout_category_id' => [
                'required',
                'exists:cashout_categories,id',
            ],
            'account_no' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
        ]);

        $cashout = $user->cashouts2()->create($validated);

        return new CashoutResource($cashout);
    }
}
