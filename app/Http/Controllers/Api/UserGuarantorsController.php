<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuarantorResource;
use App\Http\Resources\GuarantorCollection;

class UserGuarantorsController extends Controller
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

        $guarantors = $user
            ->guarantors()
            ->search($search)
            ->latest()
            ->paginate();

        return new GuarantorCollection($guarantors);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Guarantor::class);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'exist_ac_no' => ['nullable', 'string'],
            'daily_loan_id' => ['required', 'exists:daily_loans,id'],
        ]);

        $guarantor = $user->guarantors()->create($validated);

        return new GuarantorResource($guarantor);
    }
}
