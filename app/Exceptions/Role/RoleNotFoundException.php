<?php

namespace App\Exceptions\Role;

use App\Exceptions\DataNotFoundException;
use JetBrains\PhpStorm\Pure;

class RoleNotFoundException extends DataNotFoundException
{
    #[Pure] public static function withId(int $id): static
    {
        return new static("Role with id `$id` does not found.");
    }
}
