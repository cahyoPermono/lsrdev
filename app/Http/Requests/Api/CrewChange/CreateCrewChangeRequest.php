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
            'subject_request' => 'required|in:scheduled_crew_change,unscheduled_crew_change',
            'pts_company_id' => 'required',
            'position_id' => 'required',
            'home_base' => 'required',
            'personnel_category_name' => 'required',
            'department_name' => 'required',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date|after:date',
            'purpose_of_visit_id' => 'required',
            'status' => 'required',
            'schedule' => 'required',
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            // 'to_location_field_site_id' => 'required',
            'justification' => 'required_if:subject_request,unscheduled_crew_change',
            'flight_status' => 'required',
            'cost_center_id' => 'nullable',
            'accomodation' => 'nullable|boolean',
        ];
    }
}
