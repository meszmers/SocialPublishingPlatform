<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\PostCommentException;
use App\Services\PostCommentService;
use App\Structures\PostComment\PostCommentCreationStructure;
use App\Structures\PostComment\PostCommentDeletionStructure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct(
        private readonly PostCommentService $postCommentService,
    ) {
    }

    public function addComment(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'comment' => 'required|max:255',
        ]);

        $structure = new PostCommentCreationStructure();
        $structure->postId = $id;
        $structure->comment = $request->get('comment');
        $structure->user = $request->user();

        return response()->json($this->postCommentService->createPostComment($structure));
    }

    /**
     * @throws PostCommentException
     */
    public function deleteComment(Request $request, int $id, int $commentId): JsonResponse
    {
        $structure = new PostCommentDeletionStructure();
        $structure->postId = $id;
        $structure->commentId = $commentId;
        $structure->user = $request->user();

        $this->postCommentService->deletePostComment($structure);

        return response()->json('Comment deleted successfully.');
    }
}
