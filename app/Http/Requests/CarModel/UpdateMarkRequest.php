<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarkRequest extends FormRequest
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
            'mark_id' => 'exists:carsmarks,id|required|uuid',
        ];
    }
}
