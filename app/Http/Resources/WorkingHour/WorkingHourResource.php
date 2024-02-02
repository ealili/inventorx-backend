<?php

namespace App\Http\Resources\WorkingHour;

use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = $this->user_id; // Assuming 'user_id' is the foreign key for the user relationship
        $month = now()->format('Y-m'); // Current month, you can replace it with any desired month

        $totalWorkingHours = WorkingHour::getTotalWorkingHoursForUserInMonth($userId, $month);

        return [
            'id' => $this->id,
            'working_hours' => $this->working_hours,
            'date' => $this->date,
            'user' => $this->user,
            'team' => $this->team,
            'total_working_hours_for_month' => $totalWorkingHours,
        ];
    }
}
