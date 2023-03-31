<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingsCollectionStoreRequest extends FormRequest
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
            'saving_amount' => ['required', 'numeric'],
            'type' => ['required', 'string'],
            'collector_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
