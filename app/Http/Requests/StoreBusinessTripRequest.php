<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('PEGAWAI') ?? false;
    }

    public function rules(): array
    {
        return [
            'origin_city_id' => ['required', 'exists:cities,id'],
            'destination_city_id' => ['required', 'exists:cities,id', 'different:origin_city_id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'purpose' => ['required', 'string', 'min:10'],
        ];
    }
}
