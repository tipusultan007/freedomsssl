<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DpsCollectionUpdateRequest extends FormRequest
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
            'dps_id' => ['required', 'exists:dps,id'],
            'dps_amount' => ['required', 'numeric'],
            'balance' => ['required', 'numeric'],
            'receipt_no' => ['nullable', 'string'],
            'late_fee' => ['nullable', 'numeric'],
            'other_fee' => ['nullable', 'numeric'],
            'advance' => ['nullable', 'numeric'],
            'month' => [
                'required',
                'in:january,february,march,april,may,june,july,august,september,october,november,december',
            ],
            'year' => ['required', 'numeric'],
            'trx_id' => ['required', 'string'],
            'date' => ['required', 'date'],
            'collector_id' => ['required', 'exists:users,id'],
            'dps_installment_id' => ['required', 'exists:dps_installments,id'],
        ];
    }
}
