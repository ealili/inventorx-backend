<?php

namespace App\Exceptions\Invitations;

use App\Exceptions\DataNotFoundException;
use JetBrains\PhpStorm\Pure;

class UserInvitationNotFoundException extends DataNotFoundException
{
    #[Pure] public static function withToken(string $token = ""): static
    {
        return new static("User invitation with token `{$token}` does not exist.");
    }
}
