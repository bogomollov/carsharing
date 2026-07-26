<?php

namespace App\Http\Requests\Transaction;

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
            'arendator_id' => 'exists:arendators,id|required|uuid',
            'bill_id' => 'exists:bills,id|required|uuid',
            'modification' => 'required|string',
        ];
    }
}
