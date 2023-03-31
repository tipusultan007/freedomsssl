<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClosingAccountStoreRequest extends FormRequest
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
            'type' => ['nullable', 'string'],
            'deposit' => ['nullable', 'numeric'],
            'Withdraw' => ['nullable', 'numeric'],
            'remain' => ['nullable', 'numeric'],
            'profit' => ['nullable', 'numeric'],
            'service_charge' => ['nullable', 'numeric'],
            'total' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'daily_savings_id' => ['nullable', 'exists:daily_savings,id'],
            'dps_id' => ['nullable', 'exists:dps,id'],
            'special_dps_id' => ['nullable', 'exists:special_dps,id'],
            'fdr_id' => ['nullable', 'exists:fdrs,id'],
        ];
    }
}
