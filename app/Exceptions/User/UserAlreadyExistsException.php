<?php

namespace App\Exceptions\User;

use App\Exceptions\DataExistsException;
use Exception;
use JetBrains\PhpStorm\Pure;

class UserAlreadyExistsException extends DataExistsException
{
    #[Pure] public static function withId(int $id): static
    {
        return new static("User with id `{$id}` already exists.");
    }

    #[Pure] public static function withEmail(string $email): static
    {
        return new static("User with email `{$email}` already exists.");
    }
}
