<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    
    public function rules(): array
    {
        return [
            'car_class' => 'required|string',
        ];
    }
}
