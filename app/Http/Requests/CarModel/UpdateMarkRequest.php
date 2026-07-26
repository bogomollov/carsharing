<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarkRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    
    public function rules(): array
    {
        return [
            'mark_id' => 'exists:carsmarks,id|required|uuid',
        ];
    }
}
