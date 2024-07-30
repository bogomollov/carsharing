<?php

namespace App\Http\Requests\Arendator;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'default_bill_id' => 'exists:bills,id|required|uuid',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'status' => 'required|string',
            'passport_series' => 'required|string',
            'passport_number' => 'required|string',
            'phone' => 'required|integer',
        ];
    }
}
