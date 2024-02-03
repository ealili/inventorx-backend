<?php

namespace App\Exceptions\Invitations;

use App\Exceptions\DataCouldNotBeCreatedException;
use JetBrains\PhpStorm\Pure;

class UserCouldNotBeCreatedException extends DataCouldNotBeCreatedException
{
    #[Pure] public static function withEmail(string $email): static
    {
        return new static("User with email `{$email}` could not be created.");
    }
}
