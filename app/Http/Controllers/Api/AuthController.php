<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Signuprequest;
use App\Http\Resources\UserResource;
use App\Models\Team;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseApi;

    public function signup(Signuprequest $request)
    {
        // TODO: Move business logic to repository
        $data = $request->validated();

        $team = Team::create(['name' => $request->team_name]);

        $avatarPath = env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg';

        /** @var User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => $avatarPath,
            'role_id' => 1,
            'team_id' => $team->id
        ]);

        $user = new UserResource($user);

        $access_token = $user->createToken('main')->plainTextToken;

        return $this->respondWithCustomData([
            'user' => $user,
            'access_token' => $access_token
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email address or password is incorrect!',
            ], 400);
        }

        /** @var User $user */
        $user = Auth::user();
        $user = new UserResource($user);

        $access_token = $user->createToken('main')->plainTextToken;

        return $this->respondWithCustomData([
            'user' => $user,
            'access_token' => $access_token
        ]);
    }


    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

//        $user->currentAccessToken()->delete();

        $user->tokens()->delete();

        return response([''], 200);
    }
}
