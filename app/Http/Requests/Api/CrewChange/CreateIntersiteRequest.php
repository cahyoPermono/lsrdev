<?php

namespace App\Http\Requests\Api\CrewChange;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateIntersiteRequest extends FormRequest
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
            'subject_request' => 'required|in:scheduled_intersite,unscheduled_intersite',
            'pts_id' => 'required',
            'pts_company_id' => 'required',
            'department_name' => 'required', // Mechanical, IT
            'position_id' => 'required',
            'departure_date_time' => 'required|date',
            'purpose_of_visit_id' => 'required',
            'schedule' => 'required_if:subject_request,scheduled_intersite',
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            // 'to_location_field_site_id' => 'required',
            // 'transit_point' => 'required',
            'cost_center_id' => 'nullable',
            'approver_id' => 'required_if:subject_request,unscheduled_intersite',
	        'approver_email' => 'required_if:subject_request,unscheduled_intersite',
            'justification' => 'required_if:subject_request,unscheduled_intersite',
        ];
    }
}
