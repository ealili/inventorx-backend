<?php

namespace App\Http\Resources\UserInvitation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'invitation_token' => $this->invitation_token,
            'team' => $this->team,
            'role' => $this->role
        ];
    }
}
