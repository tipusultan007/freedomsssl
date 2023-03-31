<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashInUpdateRequest extends FormRequest
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
            'cashin_category_id' => ['required', 'exists:cashin_categories,id'],
            'account_no' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ];
    }
}
