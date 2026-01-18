<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Package selection (from choose-package step)
            'cityId' => ['required', 'uuid', 'exists:cities,id'],
            'momentId' => ['required', 'uuid', 'exists:moments,id'],
            'packageId' => ['required', 'uuid', 'exists:packages,id'],

            // Photoshoot details (from photoshoot-details step)
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required', 'string', 'regex:/^\d{2}:\d{2}$/'],
            'pax' => ['required', 'integer', 'min:1', 'max:20'],
            'location' => ['required', 'string', 'in:hotel,airport,landmark,other'],
            'locationDetails' => ['nullable', 'string', 'max:500'],
            'additionalInfo' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cityId.exists' => 'The selected city is invalid.',
            'momentId.exists' => 'The selected moment is invalid.',
            'packageId.exists' => 'The selected package is invalid.',
            'date.after' => 'The photoshoot date must be in the future.',
            'time.regex' => 'The time format is invalid (expected HH:MM).',
            'pax.max' => 'Maximum 20 people per photoshoot.',
            'location.in' => 'Please select a valid location type.',
        ];
    }

    /**
     * Get custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'cityId' => 'city',
            'momentId' => 'moment',
            'packageId' => 'package',
            'pax' => 'number of people',
            'locationDetails' => 'location details',
            'additionalInfo' => 'additional information',
        ];
    }
}
