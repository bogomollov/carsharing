<?php

namespace App\Http\Requests\Users;

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
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
            'car' => 'integer'
        ];
    }
}
