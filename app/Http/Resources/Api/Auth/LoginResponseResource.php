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
            'email' => Crypto::encrypt($this->email),
            'person_id' => Crypto::encrypt($this->person_id),
            'regid' => request()->header('regid'),
        ])->setExpired("+1 days")->build();

        return [
            'email' => $this->email,
            'authorization' => [
                // Todo : get List authorization from table
            ],
            'token' => $token
        ];
    }
}