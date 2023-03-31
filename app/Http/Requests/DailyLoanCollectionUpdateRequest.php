<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyLoanCollectionUpdateRequest extends FormRequest
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
            'daily_loan_id' => ['required', 'exists:daily_loans,id'],
            'loan_installment' => ['required', 'numeric'],
            'loan_late_fee' => ['nullable', 'numeric'],
            'loan_other_fee' => ['nullable', 'numeric'],
            'loan_note' => ['nullable', 'string'],
            'loan_balance' => ['required', 'numeric'],
            'collector_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
