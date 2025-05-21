<?php

declare(strict_types=1);

namespace App\Structures\PostComment;

use App\Models\User;

class PostCommentDeletionStructure
{
    public int $postId;
    public User $user;
    public int $commentId;
}
