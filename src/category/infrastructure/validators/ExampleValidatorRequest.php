<?php

namespace Src\category\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class ExampleValidatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'field' => 'nullable|max:255',
        ];
    }
}