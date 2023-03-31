<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustAmountStoreRequest extends FormRequest
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
            'loan_id' => ['required'],
            'daily_loan_id' => ['required', 'exists:daily_loans,id'],
            'adjust_amount' => ['required', 'numeric'],
            'before_adjust' => ['required', 'numeric'],
            'after_adjust' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'added_by' => ['required', 'exists:users,id'],
        ];
    }
}
