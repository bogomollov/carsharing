<?php

namespace App\Http\Requests\Car;

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
            'model_id' => 'required|uuid',
            'status' => 'required|string',
            'mileage' => 'required|integer',
            'license_plate' => 'required|string',
            'year' => 'required|integer',
            'location' => 'required|string',
            'price_minute' => 'required|integer',
        ];
    }
}
