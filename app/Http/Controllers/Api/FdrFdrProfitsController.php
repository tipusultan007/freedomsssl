<?php

namespace App\Http\Controllers\Api;

use App\Models\Fdr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrProfitResource;
use App\Http\Resources\FdrProfitCollection;

class FdrFdrProfitsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Fdr $fdr)
    {
        $this->authorize('view', $fdr);

        $search = $request->get('search', '');

        $fdrProfits = $fdr
            ->fdrProfits()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrProfitCollection($fdrProfits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fdr $fdr
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fdr $fdr)
    {
        $this->authorize('create', FdrProfit::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'profit' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'trx_id' => ['required', 'string'],
            'month' => [
                'required',
                'in:january,february,march,april,may,june,july,august,september,october,november,december',
            ],
            'year' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ]);

        $fdrProfit = $fdr->fdrProfits()->create($validated);

        return new FdrProfitResource($fdrProfit);
    }
}
