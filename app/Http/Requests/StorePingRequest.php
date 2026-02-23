<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'uuid'],
            'battery_percent' => ['required', 'integer', 'between:0,100'],
        ];
    }
}
