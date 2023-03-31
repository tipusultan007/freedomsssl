<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FdrPackageValueStoreRequest extends FormRequest
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
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'year' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
