<?php
namespace App\Actions\Hse;

use Illuminate\Http\Request;

class SubmitHseSafetyCardAction
{
     public function handle(Request $request, $user)
     {
          $request->validate([
               'position_id' => 'required',
               'category' => 'required',
               'date' => 'required',
               'block_function' => 'required',
               'location' => 'required',
               'observation_location' => 'required',
               'company' => 'required',
               'division' => 'required',
               'department' => 'required',
               'report_type' => 'required',
               'posibility_event' => 'required',
               'unsafe_behaivour' => 'required',
               'unsafe_condition' => 'required',
               'unsafe_reason' => 'required',
               'life_saving_rule' => 'required',
               'risk_rank' => 'required',
               'brief_description' => 'required',
               'recomendation_category' => 'required',
               'recomendation_finding' => 'required',
               'recomendation' => 'required',
               'recomendation_target_date' => 'required',
               'recomendation_position_id' => 'required',
               'recomendation_position_name' => 'required',
               'recomendation_position_payroll_name' => 'required',
               'recomendation_position_payroll_id' => 'required',
               'recomendation_priority' => 'required',
          ]);

          $recomendations = collect($request->recomendation_category)->map(function ($category, $index) use ($request) {
               $recomendation_finding = $request->recomendation_finding;
               $recomendation_target_date = $request->recomendation_target_date;
               $recomendation_position_name = $request->recomendation_position_name;
               $recomendation_position_payroll_name = $request->recomendation_position_payroll_name;
               $recomendation_position_id = $request->recomendation_position_id;
               $recomendation_priority = $request->recomendation_priority;
               $recomendation = $request->recomendation;
               return [
                    "finding" => @$recomendation_finding[$index] ?: '',
                    "recommendation" => @$recomendation[$index] ?: '',
                    "target_completed_date" => @$recomendation_target_date[$index] ?: '',
                    "recommendation_category" => $category,
                    "block" => null,
                    "location" => null,,
                    "resp_person_name" => @$recomendation_position_name[$index] ?: '',,
                    "resp_person_payroll" => @$recomendation_position_payroll_name[$index] ?: '',,
                    "resp_person_positionid" => @$recomendation_position_id[$index] ?: '',,
                    "priority" => @$recomendation_priority[$index] ?: '',,
                    "base64_attachments" => [
                         "att1" => null,
                         "att2" => null,
                         "att3" => null,
                         "att4" => null,
                    ]
               ];
          });


          $bodyParam = [
               "Header" => [
                    "email" => $user->email,
                    "position_id" => $request->position_id,
                    "category" => $request->category,
                    "date" => $request->date,
                    "block_or_func" => $request->block_function,
                    "location" => $request->location,
                    "obs_location" => $request->observation_location,
                    "obs_name" => null,
                    "company" => $request->company,
                    "division" => $request->division,
                    "department" => $request->department,
                    "pts_no" => null,
                    "report_type" => $request->report_type,
               ],
               "PossibilityEvent" => [
                    "poe" => $request->posibility_event,
                    // array pisahkan dengan tanda koma
                    "others_poe_text" => $request->other_posibility_event ?: ''
               ],
               "UnsafeBehaviour" => [
                    "ub" => $request->unsafe_behaivour, // array pisahkan dengan tanda koma
                    "others_ub_text" => $request->other_unsafe_behaivour ?: '',
               ],
               "UnsafeCondition" => [
                    "uc" => $request->unsafe_condition,
                    // array pisahkan dengan tanda koma
                    "others_uc_text" => $request->other_unsafe_condition ?: '',
               ],
               "UnsafeReason" => [
                    "ur" => $request->unsafe_reason,
                    "others_ur_text" => $request->other_unsafe_reason ?: '',
               ],
               "LifeSavingRule" => $request->life_saving_rule,
               // array pisahkan dengan tanda koma
               "Footer" => [
                    "risk_rank" => $request->risk_rank,
                    "brief_desc" => $request->brief_description,
                    "appreciation" => null,
               ],
               "Recommendations" => $recomendations->toArray()
          ];
     }
}