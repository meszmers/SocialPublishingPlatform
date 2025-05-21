<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use App\Structures\Post\PostCreationStructure;
use App\Structures\Post\PostsRetrievalStructure;
use App\Structures\Post\PostUpdateStructure;

class PostRepository
{
    public function getPosts(PostsRetrievalStructure $structure): array
    {
        return Post::query()
            ->with(['user', 'categories', 'comments.user'])
            ->where([
                ['title', 'like', '%' . $structure->search . '%'],
                ['content', 'like', '%' . $structure->search . '%'],
            ])
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    public function getUserPosts(User $user): array
    {
        return Post::query()
            ->with(['user', 'categories', 'comments.user'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    public function getPost(int $id): ?Post
    {
        return Post::query()->with(['user', 'categories', 'comments.user'])->find($id);
    }

    public function createPost(PostCreationStructure $structure): Post
    {
        $post = Post::create([
            'user_id' => $structure->user->id,
            'title' => $structure->title,
            'content' => $structure->content,
        ]);

        $post->categories()->sync($structure->categories);

        return $post;
    }

    public function updatePost(PostUpdateStructure $structure): Post
    {
        $post = $this->getPost($structure->id);

        $post->update([
            'title' => $structure->title,
            'content' => $structure->content,
        ]);

        $post->categories()->sync($structure->categories);

        $post->refresh();

        return $post;
    }

    public function deletePost(Post $post): void
    {
        $post->delete();
    }
}
