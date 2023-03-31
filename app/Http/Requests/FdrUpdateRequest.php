<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FdrUpdateRequest extends FormRequest
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
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'duration' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'fdr_amount' => ['nullable', 'numeric'],
            'deposit_date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'note' => ['nullable', 'string'],
        ];
    }
}
