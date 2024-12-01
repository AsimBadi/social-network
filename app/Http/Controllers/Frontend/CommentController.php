<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function submitComment(CommentRequest $request) {
        if ($request->ajax()) {
            Comment::create([
                'comment' => $request->comment_input,
                'post_id' => $request->post_id,
                'user_id' => Auth::user()->id
            ]);
            return response()->json(true, 200);
        }
    }

    public function loadComments(Request $request) {
        if ($request->ajax()) {
            $comments = Comment::with('user')->where('post_id', $request->post_id)->get();
            return response()->json($comments, 200);
        }
    }

    public function removeComment(Request $request) {
        if ($request->ajax()) {
            $comment = Comment::find($request->comment_id);
            abort_if($comment->user_id != $request->user_id, 403);
            $comment->delete();
            return response()->json(true, 200);
        }
    }
}
