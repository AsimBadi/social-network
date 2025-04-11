<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function posts(Request $request)
    {
        $perPage = $request->input('perPage', 8);
        $posts = Post::with('image')
        ->when($request->search, function ($query) use ($request) {
            $query->where('caption', 'LIKE', "%$request->search%");
        })
        ->paginate($perPage);
        return response()->json([
            'data' => PostResource::collection($posts),
            'links' => [
                'first' => $posts->url(1),
                'last' => $posts->url($posts->lastPage()),
                'prev' => $posts->previousPageUrl(),
                'next' => $posts->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $posts->currentPage(),
                'from' => $posts->firstItem(),
                'last_page' => $posts->lastPage(),
                'path' => $posts->path(),
                'per_page' => $posts->perPage(),
                'to' => $posts->lastItem(),
                'total' => $posts->total(),
            ]
        ]);
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        PostImage::where('post_id', $id)->delete();
        return response()->json('Post Deleted', 200);
    }

    public function edit($id)
    {
        $post = Post::with('image')->find($id);
        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        Post::find($id)->update([
            'caption' => $request->caption
        ]);
        if(count($request->image_ids) > 0)
        {
            PostImage::whereIn('id', $request->image_ids)->delete();
        }
        return response()->json('Post Updated', 200);
    }

    public function comments($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        return response()->json($comments, 200);
    }

    public function deleteComments($id)
    {
        Comment::find($id)->delete();
        return response()->json('Comment Deleted', 200);
    }
}
