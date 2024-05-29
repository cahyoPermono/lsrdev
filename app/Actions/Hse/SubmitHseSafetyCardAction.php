<?php
namespace App\Actions\Hse;

use App\Helpers\MedcoRestful;
use App\Services\Hse\SafetyCardService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class SubmitHseSafetyCardAction
{
     public function handle(Request $request, $user)
     {
         

          $recomendations = collect($request->recomendation_category)->map(function ($category, $index) use ($request) {
               $recomendation_finding = $request->recomendation_finding;
               $recomendation_target_date = $request->recomendation_target_date;
               $recomendation_position_payroll_name = $request->recomendation_position_payroll_name;
               $recomendation_position_payroll_id = $request->recomendation_position_payroll_id;
               $recomendation_position_id = $request->recomendation_position_id;
               $recomendation_priority = $request->recomendation_priority;
               $recomendation = $request->recomendation;

               $attachments = [];
               collect($request->recomendation_attachments[$index])->each(function ($file, $index) use(&$attachments) {
                    $number = $index + 1;
                    $attachments["att{$number}"]= [
                         "file_name" => $file->getClientOriginalName(),
                         "file_string" => base64_encode(file_get_contents($file))
                    ];
               });
     
               return [
                    "finding" => @$recomendation_finding[$index] ?: '',
                    "recommendation" => @$recomendation[$index] ?: '',
                    "target_completed_date" => @$recomendation_target_date[$index] ?: '',
                    "recommendation_category" => $category,
                    "block" => $request->block_function,
                    "location" => $request->location,
                    "resp_person_name" => @$recomendation_position_payroll_name[$index] ?: '',
                    "resp_person_payroll" => @$recomendation_position_payroll_id[$index] ?: '',
                    "resp_person_positionid" => @$recomendation_position_id[$index] ?: '',
                    "priority" => @$recomendation_priority[$index] ?: '',
                    "attachments" => $attachments
               ];
          });

          $attachment = $request->file('attachment');
          $bodyParam = [
               "Header" => [
                    "email" => $user->email,
                    "position_id" => $request->position_id,
                    "category" => $request->category,
                    "date" => $request->date,
                    "block_or_func" => $request->block_function,
                    "location" => $request->location,
                    "obs_location" => $request->observation_location,
                    "obs_name" => "",
                    "company" => $request->company,
                    "division" => $request->division,
                    "department" => $request->department,
                    "pts_no" => (string) $user?->person_id ?: '',
                    "report_type" => $request->report_type,
                    'main_attachment' => [
                         'file_name' => $attachment->getClientOriginalName(),
                         'file_string' => base64_encode(file_get_contents($attachment))
                    ]
               ],
               "PossibilityEvent" => [
                    "poe" => $request->posibility_event ?: '',
                    // array pisahkan dengan tanda koma
                    "others_poe_text" => $request->other_posibility_event ?: ''
               ],
               "UnsafeBehaviour" => [
                    "ub" => $request->unsafe_behaivour ?: '',
                    // array pisahkan dengan tanda koma
                    "others_ub_text" => $request->other_unsafe_behaivour ?: '',
               ],
               "UnsafeCondition" => [
                    "uc" => $request->unsafe_condition ?: '',
                    // array pisahkan dengan tanda koma
                    "others_uc_text" => $request->other_unsafe_condition ?: '',
               ],
               "UnsafeReason" => [
                    "ur" => $request->unsafe_reason ?: '',
                    "others_ur_text" => $request->other_unsafe_reason ?: '',
               ],
               "LifeSavingRule" => $request->life_saving_rule ?: '', // array pisahkan dengan tanda koma
               "Footer" => [
                    "risk_rank" => $request->risk_rank ?: '',
                    "brief_desc" => $request->brief_description ?: '',
                    "appreciation" => "",
               ],
               "Recommendations" => $recomendations->toArray()
          ];

          $result = (new SafetyCardService)->postSafetyCard($bodyParam);
          app('log')->channel('safety-card')->debug(json_encode($result));
          app('log')->channel('safety-card')->debug(json_encode($bodyParam));
          if(@$result['status_code']!=201){
               throw new BadRequestException(@$result['message']);
          }
     }
}