<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PostComment;
use App\Structures\PostComment\PostCommentCreationStructure;
use App\Structures\PostComment\PostCommentDeletionStructure;

class PostCommentRepository
{
    public function getCommentByPostCommentDeletionStructure(PostCommentDeletionStructure $structure): PostComment
    {
        return PostComment::query()
            ->where([
                ['id', '=', $structure->commentId],
                ['post_id', '=', $structure->postId],
                ['user_id', '=', $structure->user->id],
            ])->first();
    }

    public function createPostComment(PostCommentCreationStructure $structure): PostComment
    {
        return PostComment::create([
            'post_id' => $structure->postId,
            'user_id' => $structure->user->id,
            'comment' => $structure->comment,
        ]);
    }

    public function deletePostComment(PostComment $postComment): void
    {
        $postComment->delete();
    }
}
