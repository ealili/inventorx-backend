<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Invitations\StoreUserByInvitationRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\User\IUserRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResponseApi;

    public function __construct(
        private IUserRepository $userRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userRepository->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Move to repository
//        $invitation = $request->invitation_token;
//        $data = $request->validated();
//        $data['password'] = bcrypt($data['password']);
//        $avatarPath = env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg';
//        $data['avatar'] = $avatarPath;
//        $data['role_id'] = '3';
//
//
//        $user = User::create($data);
//
//        return response(new UserResource($user), 201);
    }

    public function storeByInvitation(StoreUserByInvitationRequest $request)
    {
        $user = $this->userRepository->createByInvitation($request->all());

        return $this->respondWithItem(UserResource::class, $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $user =  $this->userRepository->getUserById($id);
        return $this->respondWithItem(UserResource::class, $user);
//        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response('', 204);
    }

    public function getUsersWithWorkingHours(Request $request) {
        // TODO: Move to repo
        $teamId = Auth::user()->team_id;

        $month = $request->input('month', now()->format('Y-m'));

        $users = User::where('team_id', $teamId)->with(['workingHours' => function ($query) use ($teamId, $month) {
            $query->where('team_id', $teamId)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month]);
        }])->get();

        // For sqlite only
//        $users = User::with(['workingHours' => function ($query) use ($teamId, $month) {
//            $query->where('team_id', $teamId)
//                ->whereRaw("strftime('%Y-%m', date) = ?", [$month]);
//        }])->get();

        $users = $users->map(function ($user) {
            $totalWorkingHours = $user->workingHours->sum('working_hours');
            $user->working_hours = $user->workingHours;
            $user->total_working_hours_for_month = $totalWorkingHours;
            unset($user->workingHours);
            return $user;
        });

        return $users;
    }
}
