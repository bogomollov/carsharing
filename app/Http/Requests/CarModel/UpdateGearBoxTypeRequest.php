<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGearBoxTypeRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    
    public function rules(): array
    {
        return [
            'gear_box' => 'required|string',
        ];
    }
}
