<?php

namespace App\Http\Requests\CarMark;

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
            'name' => 'required|string',
        ];
    }
}
