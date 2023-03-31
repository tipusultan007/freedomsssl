<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FdrDepositUpdateRequest extends FormRequest
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
            'fdr_id' => ['required', 'exists:fdrs,id'],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'fdr_package_id' => ['required', 'exists:fdr_packages,id'],
            'date' => ['required', 'date'],
            'commencement' => ['required', 'date'],
            'balance' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
            'created_by' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ];
    }
}
