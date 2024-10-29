<?php

namespace App\Http\Requests\Api\CrewChange;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateCrewChangeRequest extends FormRequest
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
            'pts_company_id' => 'required',
            'departure_date' => 'required',
            // 'return_date' => 'required',
            'purpose_of_visit_id' => 'required',
            'status' => 'required',
            'schedule' => 'required',
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            // 'to_location_field_site_id' => 'required',
            'transit_point' => 'required',
            'coast_center_id' => 'required',
            'position_id' => 'required',
        ];
    }
}
