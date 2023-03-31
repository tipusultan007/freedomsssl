<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NomineesUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'relation' => ['required', 'string'],
            'address' => ['required', 'string'],
            'percentage' => ['required', 'numeric'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
