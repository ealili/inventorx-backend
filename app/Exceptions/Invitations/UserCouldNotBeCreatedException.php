<?php

namespace App\Exceptions\Invitations;

use App\Exceptions\DataCouldNotBeCreatedException;
use JetBrains\PhpStorm\Pure;

class UserCouldNotBeCreatedException extends DataCouldNotBeCreatedException
{
    #[Pure] public static function withEmail(int $id): static
    {
        return new static("User with id `{id}` could not be created.");
    }
}
