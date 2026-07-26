<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'model_id' => 'exists:carsmodels,id|required|uuid',
            'status' => 'required|string',
            'mileage' => 'required|integer',
            'license_plate' => 'required|string',
            'vin' => 'required|string',
            'location' => 'required|string',
            'price_minute' => 'required|numeric',
        ];
    }
}
