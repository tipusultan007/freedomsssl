<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailySavingsStoreRequest extends FormRequest
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
            'opening_date' => ['required', 'date'],
            'status' => ['required', 'string'],
            'created_by' => ['required', 'numeric', 'exists:users,id'],
        ];
    }
}
