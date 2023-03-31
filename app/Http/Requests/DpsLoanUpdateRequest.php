<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DpsLoanUpdateRequest extends FormRequest
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
            'interest1' => ['required', 'numeric'],
            'interest2' => ['nullable', 'numeric'],
            'application_date' => ['required', 'date'],
            'approved_by' => ['required', 'exists:users,id'],
            'opening_date' => ['nullable', 'date'],
            'commencement' => ['required', 'date'],
            'status' => ['required', 'string'],
            'created_by' => ['required', 'exists:users,id'],
            'total_paid' => ['nullable', 'numeric'],
            'remain_loan' => ['nullable', 'numeric'],
        ];
    }
}
