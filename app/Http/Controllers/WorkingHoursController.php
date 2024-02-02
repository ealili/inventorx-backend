<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingHour\WorkingHourCollection;
use App\Http\Resources\WorkingHour\WorkingHourResource;
use App\Models\User;
use App\Models\WorkingHour;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class WorkingHoursController extends Controller
{
    use ResponseApi;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function showEmployeeWorkingHour(Request $request, int $userId)
    {
        $workingHour = WorkingHour::where('user_id', $userId)->where('date', $request->date)->first();

        return $this->respondWithItem(WorkingHourResource::class, $workingHour);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkingHour $workingHours)
    {
        //
    }

    /**
     * Create the resource.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'team_id' => $user->team->id,
            'date' => $request->date,
            'working_hours' => $request->working_hours
        ];

        return WorkingHour::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkingHour $workingHours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkingHour $workingHours)
    {
        //
    }

    public function generatePDF(Request $request)
    {

        $teamId = Auth::user()->team->id;
        $month = $request->input('month', now()->format('Y-m'));

        $users = User::with(['workingHours' => function ($query) use ($teamId, $month) {
            $query->where('team_id', $teamId)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month]);
        }])->get();

        $users = $users->map(function ($user) {
            $totalWorkingHours = $user->workingHours->sum('working_hours');
            $user->working_hours = $user->workingHours;
            $user->total_working_hours_for_month = $totalWorkingHours;
            unset($user->workingHours);
            return $user;
        });

        $pdf = PDF::loadView('pdf.working-hours', compact('users'));

        return $pdf->download('working-hours.pdf');
    }
}
