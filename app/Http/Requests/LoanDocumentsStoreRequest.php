<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanDocumentsStoreRequest extends FormRequest
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
            'document_name' => ['required', 'string'],
            'document_location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'taken_loan_id' => ['required', 'exists:taken_loans,id'],
            'collect_by' => ['required', 'exists:users,id'],
        ];
    }
}
