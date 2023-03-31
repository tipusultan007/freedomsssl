<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FdrProfitUpdateRequest extends FormRequest
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
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'profit' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'trx_id' => ['required', 'string'],
            'month' => [
                'required',
                'in:january,february,march,april,may,june,july,august,september,october,november,december',
            ],
            'year' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }
}
