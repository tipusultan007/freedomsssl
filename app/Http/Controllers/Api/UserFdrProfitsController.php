<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrProfitResource;
use App\Http\Resources\FdrProfitCollection;

class UserFdrProfitsController extends Controller
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

        $fdrProfits = $user
            ->fdrProfits2()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrProfitCollection($fdrProfits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', FdrProfit::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'profit' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'trx_id' => ['required', 'string'],
            'month' => [
                'required',
                'in:january,february,march,april,may,june,july,august,september,october,november,december',
            ],
            'year' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrProfit = $user->fdrProfits2()->create($validated);

        return new FdrProfitResource($fdrProfit);
    }
}
