<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollectionResource;
use App\Http\Resources\DpsCollectionCollection;

class UserDpsCollectionsController extends Controller
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

        $dpsCollections = $user
            ->dpsCollections2()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsCollectionCollection($dpsCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DpsCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'dps_id' => ['required', 'exists:dps,id'],
            'dps_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'receipt_no' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'advance' => ['nullable', 'numeric'],
            'month' => [
                'required',
                'in:january,february,march,april,may,june,july,august,september,october,november,december',
            ],
            'year' => ['required', 'numeric'],
            'trx_id' => ['required', 'string'],
            'date' => ['required', 'date'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
        ]);

        $dpsCollection = $user->dpsCollections2()->create($validated);

        return new DpsCollectionResource($dpsCollection);
    }
}
