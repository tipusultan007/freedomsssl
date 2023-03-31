<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialLoanTakenUpdateRequest extends FormRequest
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
            'upto_amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'special_dps_loan_id' => [
                'required',
                'exists:special_dps_loans,id',
            ],
            'created_by' => ['required', 'exists:users,id'],
        ];
    }
}
