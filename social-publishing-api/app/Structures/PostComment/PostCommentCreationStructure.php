<?php

declare(strict_types=1);

namespace App\Structures\PostComment;

use App\Models\User;

class PostCommentCreationStructure
{
    public int $postId;
    public User $user;
    public string $comment;
}
