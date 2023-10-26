<?php

namespace App\Exceptions\User;

use App\Exceptions\DataCouldNotBeCreatedException;
use Exception;
use JetBrains\PhpStorm\Pure;

class UserCouldNotBeInvitedException extends DataCouldNotBeCreatedException
{
    #[Pure] public static function withEmail(string $email): static
    {
        return new static("User with email `{$email}` could not be invited.");
    }
}
