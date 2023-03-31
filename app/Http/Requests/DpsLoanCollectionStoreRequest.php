<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DpsLoanCollectionStoreRequest extends FormRequest
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
            'dps_loan_id' => ['required', 'exists:dps_loans,id'],
            'collector_id' => ['required', 'exists:users,id'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
            'trx_id' => ['required', 'string'],
            'loan_installment' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'interest' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'receipt_no' => ['nullable', 'string'],
        ];
    }
}
