<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostCommentException;
use App\Models\PostComment;
use App\Repositories\PostCommentRepository;
use App\Structures\PostComment\PostCommentCreationStructure;
use App\Structures\PostComment\PostCommentDeletionStructure;

class PostCommentService
{
    public function __construct(
        private readonly PostCommentRepository $postCommentRepository,
    ) {
    }

    public function createPostComment(PostCommentCreationStructure $structure): PostComment
    {
        return $this->postCommentRepository->createPostComment($structure);
    }

    /**
     * @throws PostCommentException
     */
    public function deletePostComment(PostCommentDeletionStructure $structure): void
    {
        $postComment = $this->postCommentRepository->getCommentByPostCommentDeletionStructure($structure);

        if (!$postComment) {
            throw new PostCommentException('Valid post cannot be found for deletion.');
        }

        $this->postCommentRepository->deletePostComment($postComment);
    }
}
