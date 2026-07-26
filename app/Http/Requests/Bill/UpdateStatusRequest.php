<?php

namespace App\Http\Requests\Bill;

use App\Enums\BillsStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string',
        ];
    }
}
