<?php

namespace App\Http\Requests\Arendator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDefaultBillRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    
    public function rules(): array
    {
        return [
            'default_bill_id' => 'exists:bills,id|required|uuid',
        ];
    }
}
