<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Auth\IAuthRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseApi;

    /**
     * AuthController constructor.
     *
     * @param IAuthRepository $authRepository
     */
    public function __construct(
        private readonly IAuthRepository $authRepository
    )
    {
    }

    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $this->authRepository->register($request->all());

        return $this->respondWithCustomData([
            'message' => 'Registration successful',
        ], 201);
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            // TODO: Throw exception
            return $this->respondWithCustomData([
                'message' => 'Provided email address or password is incorrect!'
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

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->tokens()->delete();

        return $this->respondWithCustomData([
            'message' => 'Log out successful'
        ]);
    }
}
