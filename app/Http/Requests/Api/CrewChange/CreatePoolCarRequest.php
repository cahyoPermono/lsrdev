<?php

namespace App\Http\Requests\Api\CrewChange;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreatePoolCarRequest extends FormRequest
{
    use FailedValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'pts_id' => 'required',
            'date_time' => 'required',
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'transportation_type_id' => 'required',
            'justification' => 'required',
        ];
    }
}
