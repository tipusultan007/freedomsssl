<?php

namespace App\Http\Controllers\Api;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Http\Resources\FdrResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FdrCollection;

class FdrPackageFdrsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('view', $fdrPackage);

        $search = $request->get('search', '');

        $fdrs = $fdrPackage
            ->fdrs()
            ->search($search)
            ->latest()
            ->paginate();

        return new FdrCollection($fdrs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FdrPackage $fdrPackage)
    {
        $this->authorize('create', Fdr::class);

        $validated = $request->validate([
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'duration' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'fdr_amount' => ['nullable', 'numeric'],
            'deposit_date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'note' => ['nullable', 'string'],
        ]);

        $fdr = $fdrPackage->fdrs()->create($validated);

        return new FdrResource($fdr);
    }
}
