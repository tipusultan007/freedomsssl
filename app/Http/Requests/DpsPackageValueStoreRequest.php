<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DpsPackageValueStoreRequest extends FormRequest
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
            'dps_package_id' => ['nullable', 'exists:dps_packages,id'],
            'year' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
