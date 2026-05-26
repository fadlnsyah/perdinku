<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('ADMIN') ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'is_foreign' => ['required', 'boolean'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];

        if (! $this->boolean('is_foreign')) {
            $rules['province'] = ['required', 'string', 'max:255'];
            $rules['island'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}
