<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailySavingsClosingStoreRequest extends FormRequest
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
            'daily_savings_id' => ['required', 'exists:daily_savings,id'],
            'total_deposit' => ['required', 'numeric'],
            'total_withdraw' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'closing_by' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'closing_fee' => ['required', 'numeric'],
        ];
    }
}
