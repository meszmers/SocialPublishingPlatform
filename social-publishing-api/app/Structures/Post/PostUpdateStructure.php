<?php

declare(strict_types=1);

namespace App\Structures\Post;

use App\Models\User;

class PostUpdateStructure extends PostDefaultStructure
{
    public int $id;
    public User $user;
}
