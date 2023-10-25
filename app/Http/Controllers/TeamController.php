<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Repositories\Team\ITeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function __construct(
        private ITeamRepository $teamRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->teamRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return $this->teamRepository->get($team);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        return $this->teamRepository->update($request->all(), $team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if ($this->teamRepository->delete($team)) {
            return response([''], 204);
        }
        return response(['message' => 'Team could be deleted']);
    }
}
