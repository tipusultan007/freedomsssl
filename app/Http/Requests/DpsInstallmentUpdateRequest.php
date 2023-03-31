<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DpsInstallmentUpdateRequest extends FormRequest
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
            'dps_id' => ['nullable', 'exists:dps,id'],
            'collector_id' => ['required', 'exists:users,id'],
            'dps_loan_id' => ['nullable', 'exists:dps_loans,id'],
            'dps_amount' => ['nullable', 'numeric'],
            'dps_balance' => ['nullable', 'numeric'],
            'receipt_no' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'grace' => ['nullable', 'numeric'],
            'advance' => ['nullable', 'numeric'],
            'loan_installment' => ['nullable', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'trx_id' => ['required', 'string'],
            'loan_balance' => ['nullable', 'numeric'],
            'total' => ['required', 'numeric'],
            'due' => ['nullable', 'numeric'],
            'due_return' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
        ];
    }
}
