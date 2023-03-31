<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProfitUpdateRequest extends FormRequest
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
            'daily_savings_id' => ['required', 'exists:daily_savings,id'],
            'user_id' => ['required', 'exists:users,id'],
            'account_no' => ['required', 'string'],
            'profit' => ['required', 'numeric'],
            'before_profit' => ['required', 'numeric'],
            'after_profit' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'duration' => ['required', 'string'],
            'created_by' => ['required', 'exists:users,id'],
        ];
    }
}
