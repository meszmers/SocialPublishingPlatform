<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostOwnershipException;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Structures\Post\PostCreationStructure;
use App\Structures\Post\PostRemovalStructure;
use App\Structures\Post\PostRetrievalStructure;
use App\Structures\Post\PostsRetrievalStructure;
use App\Structures\Post\PostUpdateStructure;

class PostService
{
    public function __construct(
        private readonly PostRepository $postsRepository,
    ) {
    }

    public function getPost(PostRetrievalStructure $structure): ?Post
    {
        return $this->postsRepository->getPost($structure->id);
    }

    public function getPosts(PostsRetrievalStructure $structure): array
    {
        return $this->postsRepository->getPosts($structure);
    }

    public function getUserPosts(User $user): array
    {
        return $this->postsRepository->getUserPosts($user);
    }

    public function createPost(PostCreationStructure $structure): Post
    {
        return $this->postsRepository->createPost($structure);
    }

    /**
     * @throws PostOwnershipException
     */
    public function editPost(PostUpdateStructure $structure): Post
    {
        $post = $this->postsRepository->getPost($structure->id);

        $this->validateOwnership($structure->user, $post);

        return $this->postsRepository->updatePost($structure);
    }

    /**
     * @throws PostOwnershipException
     */
    public function deletePost(PostRemovalStructure $structure): void
    {
        $post = $this->postsRepository->getPost($structure->id);

        $this->validateOwnership($structure->user, $post);

        $this->postsRepository->deletePost($post);
    }

    /**
     * @throws PostOwnershipException
     */
    private function validateOwnership(User $user, Post $post): void
    {
        if ($user->id !== $post->user_id) {
            throw new PostOwnershipException('User does not belong to this post.');
        }
    }
}
