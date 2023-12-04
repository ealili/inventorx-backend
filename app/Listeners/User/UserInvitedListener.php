<?php

namespace App\Listeners\User;

use App\Events\User\UserInvited;
use App\Models\UserInvitation;
use App\Notifications\User\RegistrationNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class UserInvitedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserInvited $userInvited): void
    {
        Log::info("Successfully hit the listener");
        Notification::route('mail', $userInvited->userInvitation->email)->notify(new RegistrationNotification($userInvited->userInvitation->invitation_token));
    }

}
