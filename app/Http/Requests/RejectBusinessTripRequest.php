<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectBusinessTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('SDM') ?? false;
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => ['required', 'string', 'min:10'],
        ];
    }
}
