<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Invitations\UserInvitationRequest;
use App\Models\UserInvitation;
use App\Repositories\User\IUserRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserInvitationController extends Controller
{
    use ResponseApi;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $invitationToken)
    {
        $userInvitation = UserInvitation::where('invitation_token', $invitationToken)->first();
        $userInvitation->delete();
        return $this->respondWithNoContent();
    }
}
