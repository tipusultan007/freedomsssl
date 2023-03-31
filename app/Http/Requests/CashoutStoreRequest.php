<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashoutStoreRequest extends FormRequest
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
            'cashout_category_id' => [
                'required',
                'exists:cashout_categories,id',
            ],
            'account_no' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'trx_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
