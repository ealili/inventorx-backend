<?php

namespace App\Http\Resources\UserInvitation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserInvitationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => UserInvitationResource::collection($this->collection),
        ];
    }
}
