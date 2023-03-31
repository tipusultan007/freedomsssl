<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyLoan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuarantorResource;
use App\Http\Resources\GuarantorCollection;

class DailyLoanGuarantorsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('view', $dailyLoan);

        $search = $request->get('search', '');

        $guarantors = $dailyLoan
            ->guarantors()
            ->search($search)
            ->latest()
            ->paginate();

        return new GuarantorCollection($guarantors);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailyLoan $dailyLoan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DailyLoan $dailyLoan)
    {
        $this->authorize('create', Guarantor::class);

        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'exist_ac_no' => ['nullable', 'string'],
        ]);

        $guarantor = $dailyLoan->guarantors()->create($validated);

        return new GuarantorResource($guarantor);
    }
}
