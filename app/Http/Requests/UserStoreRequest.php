<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'phone1' => ['required', 'string'],
            'password' => ['required'],
            'present_address' => ['nullable', 'string'],
            'permanent_address' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string'],
            'birth_id' => ['nullable', 'string'],
            'gender' => ['required', 'in:male,female,other'],
            'birthdate' => ['nullable', 'date'],
            'father_name' => ['nullable', 'string'],
            'mother_name' => ['nullable', 'string'],
            /*'status' => ['required', 'in:active,inactive'],*/
            'join_date' => ['required', 'date'],
            'roles' => 'array',
        ];
    }
}
