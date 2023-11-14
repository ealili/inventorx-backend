<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Invitations\UserInvitationRequest;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserInvitationController extends Controller
{
    private readonly IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->userRepository->indexInvitedUsers();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserInvitationRequest $request
     * @return JsonResponse
     */
    public function store(UserInvitationRequest $request)
    {
        return $this->userRepository->invite($request->all());
    }
}
