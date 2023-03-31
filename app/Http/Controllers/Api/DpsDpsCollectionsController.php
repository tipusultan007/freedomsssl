<?php

namespace App\Http\Controllers\Api;

use App\Models\Dps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DpsCollectionResource;
use App\Http\Resources\DpsCollectionCollection;

class DpsDpsCollectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Dps $dps)
    {
        $this->authorize('view', $dps);

        $search = $request->get('search', '');

        $dpsCollections = $dps
            ->dpsCollections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DpsCollectionCollection($dpsCollections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dps $dps)
    {
        $this->authorize('create', DpsCollection::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
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
            'collector_id' => ['required', 'exists:users,id'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
        ]);

        $dpsCollection = $dps->dpsCollections()->create($validated);

        return new DpsCollectionResource($dpsCollection);
    }
}
