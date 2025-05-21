<?php

namespace App\Http\Controllers;

use App\Exceptions\PostOwnershipException;
use App\Models\Post;
use App\Models\PostComment;
use App\Services\PostService;
use App\Structures\Post\PostCreationStructure;
use App\Structures\Post\PostRemovalStructure;
use App\Structures\Post\PostRetrievalStructure;
use App\Structures\Post\PostsRetrievalStructure;
use App\Structures\Post\PostUpdateStructure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
    ) {
    }

    public function getPosts(Request $request): JsonResponse
    {
        $structure = new PostsRetrievalStructure();
        $structure->search = $request->input('search');

        $posts = $this->postService->getPosts($structure);

        return response()->json([
            'posts' => array_map([$this, 'formatPost'], $posts)
        ]);
    }

    public function getUserPosts(Request $request): JsonResponse
    {
        $posts = $this->postService->getUserPosts($request->user());

        return response()->json([
            'posts' => array_map([$this, 'formatPost'], $posts)
        ]);
    }

    public function getPost(Request $request, int $id): JsonResponse
    {
        $structure = new PostRetrievalStructure();
        $structure->id = $id;

        $post = $this->postService->getPost($structure);

        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        return response()->json($this->formatPost($post));
    }

    public function createPost(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'categories' => 'array'
        ]);

        $structure = new PostCreationStructure();
        $structure->user = $request->user();
        $structure->title = $request->input('title');
        $structure->content = $request->input('content');
        $structure->categories = $request->input('categories');

        $post = $this->postService->createPost($structure);

        return response()->json($this->formatPost($post));
    }

    /**
     * @throws PostOwnershipException
     */
    public function updatePost(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'categories' => 'array'
        ]);

        $structure = new PostUpdateStructure();
        $structure->id = $id;
        $structure->user = $request->user();
        $structure->title = $request->input('title');
        $structure->content = $request->input('content');
        $structure->categories = $request->input('categories');

        $post = $this->postService->editPost($structure);

        return response()->json($this->formatPost($post));
    }

    /**
     * @throws PostOwnershipException
     */
    public function deletePost(Request $request, int $id): void
    {
        $structure = new PostRemovalStructure();
        $structure->id = $id;
        $structure->user = $request->user();

        $this->postService->deletePost($structure);
    }

    private function formatPost(?Post $post): array
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user->id,
            'author' => $post->user->name,
            'title' => $post->title,
            'content' => $post->content,
            'categories' => $post->categories,
            'comments' => array_map([$this, 'formatComment'], $post->comments->all()),
        ];
    }

    private function formatComment(PostComment $postComment): array
    {
        return [
            'id' => $postComment->id,
            'author' => $postComment->user->name,
            'user_id' => $postComment->user_id,
            'comment' => $postComment->comment,
            'created_at' => $postComment->created_at
        ];
    }
}
