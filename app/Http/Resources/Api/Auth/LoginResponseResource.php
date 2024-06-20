<?php

namespace App\Http\Resources\Api\Auth;

use App\Helpers\Crypto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laililmahfud\Adminportal\Api\JwtToken;

class LoginResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = JwtToken::setData([
            'session_id' => @$this?->user_id,
            'email' => @$this?->email,
            'name' => @$this?->name,
            'person_id' => @$this?->person_id,
            'regid' => request()->header('regid'),
            'authorization' => []
        ])->setExpired("+1 days")->build();

        return [
            'email' => @$this?->email,
            'token' => $token
        ];
    }
}