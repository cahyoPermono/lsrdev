<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $spv = @$this->supervisor ?: null;
        if($spv){
            $spv = "{$spv->first_name} {$spv->middle_name} {$spv->last_name}";
        }
        return [
            'person_id' => $this->person_id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'sex' => @$this->sex ?: '-',
            'nationality' => @$this->nationality ?: '-',
            'department' => $this->department_name,
            'company' => $this->company_name,
            'entity' => ":TODO",
            'person_status' => @$this->person_status ? : '-', 
            'position_name' => @$this->position_name ?: '-',
            'supervisor' => $spv,
            'qr_code' => "https://chart.googleapis.com/chart?chl={$this->person_id}&chs=500x500&cht=qr&chld=H%7C0"
        ];
    }
}
