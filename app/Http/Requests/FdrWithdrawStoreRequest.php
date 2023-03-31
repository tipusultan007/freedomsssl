<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FdrWithdrawStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_no' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'date' => ['required', 'date'],
            'fdr_deposit_id' => ['required', 'exists:fdr_deposits,id'],
            'withdraw_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ];
    }
}
