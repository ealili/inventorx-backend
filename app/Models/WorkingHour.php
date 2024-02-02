<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'working_hours',
        'team_id',
        'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the total working hours for a specific user in a given month.
     *
     * @param int $userId
     * @param string $month (Format: 'YYYY-MM')
     * @return float
     */
    public static function getTotalWorkingHoursForUserInMonth($userId, $month)
    {
        return self::where('user_id', $userId)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month])
            ->sum('working_hours');
    }
}
