<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyCollectionUpdateRequest extends FormRequest
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
            'collector_id' => ['required', 'exists:users,id'],
            'saving_amount' => ['nullable', 'numeric'],
            'saving_type' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'loan_installment' => ['nullable', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'saving_note' => ['nullable', 'string'],
            'loan_note' => ['nullable', 'string'],
            'daily_savings_id' => ['nullable', 'exists:daily_savings,id'],
            'daily_loan_id' => ['nullable', 'exists:daily_loans,id'],
            'savings_balance' => ['nullable', 'numeric'],
            'loan_balance' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
        ];
    }
}
