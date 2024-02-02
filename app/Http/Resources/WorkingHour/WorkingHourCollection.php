<?php

namespace App\Http\Resources\WorkingHour;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkingHourCollection extends ResourceCollection
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
            'data' => WorkingHourResource::collection($this->collection),
        ];
    }
}
