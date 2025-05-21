<?php

declare(strict_types=1);

namespace App\Structures\Post;

use App\Models\User;

class PostCreationStructure extends PostDefaultStructure
{
    public User $user;
}
