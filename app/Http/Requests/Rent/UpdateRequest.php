<?php

namespace App\Http\Requests\Rent;

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
            'car_id' => 'exists:cars,id|required|uuid',
            'arendator_id' => 'exists:arendators,id|required|uuid',
            'status' => 'required|string',
            'start_datetime' => 'required|string',
            'end_datetime' => 'required|string',
            'rented_time' => 'required|integer',
            'total_price' => 'required|numeric',
        ];
    }
}
