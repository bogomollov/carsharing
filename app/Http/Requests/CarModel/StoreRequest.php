<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    
    public function rules(): array
    {
        return [
            'mark_id' => 'exists:carsmarks,id|required|uuid',
            'name' => 'required|string',
            'car_class' => 'required|string',
            'car_type' => 'required|string',
            'fuel_type' => 'required|string',
            'door_count' => 'required|integer',
            'seat_count' => 'required|integer',
            'gear_box' => 'required|string',
            'drive_type' => 'required|string',
            'engine_power' => 'required|integer',
            'year' => 'required|integer',
        ];
    }
}
