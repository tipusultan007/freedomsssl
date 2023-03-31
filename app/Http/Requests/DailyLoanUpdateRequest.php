<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyLoanUpdateRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'package_id' => ['required', 'exists:daily_loan_packages,id'],
            'per_installment' => ['nullable', 'numeric'],
            'opening_date' => ['required', 'date'],
            'interest' => ['required', 'numeric'],
            'adjusted_amount' => ['nullable', 'numeric'],
            'commencement' => ['required', 'date'],
            'loan_amount' => ['required', 'numeric'],
            'application_date' => ['nullable', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'approved_by' => ['required', 'exists:users,id'],
            'status' => ['required', 'max:255', 'string'],
        ];
    }
}
