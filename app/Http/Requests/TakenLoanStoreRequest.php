<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakenLoanStoreRequest extends FormRequest
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
            'loan_amount' => ['required', 'numeric'],
            'before_loan' => ['required', 'numeric'],
            'after_loan' => ['required', 'numeric'],
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'upto_amount' => ['nullable', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'dps_loan_id' => ['required', 'exists:dps_loans,id'],
        ];
    }
}
