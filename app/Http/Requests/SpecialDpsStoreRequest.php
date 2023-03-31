<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialDpsStoreRequest extends FormRequest
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
            'special_dps_package_id' => [
                'required',
                'exists:special_dps_packages,id',
            ],
            'balance' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'opening_date' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
        ];
    }
}
