<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostlikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isUserAlreadyLiked = PostLike::where('post_id', $request->postId)->where('user_id', Auth::user()->id)->first();
        $likesCount = PostLike::where('post_id', $request->postId)->count();
        if ($isUserAlreadyLiked) {
            $isUserAlreadyLiked->delete();
            $countAfterDelete = PostLike::where('post_id', $request->postId)->count();
            return response()->json(['status' => 400, 'message' => $countAfterDelete]);
        }else{
        PostLike::create([
            'post_id' => $request->postId,
            'user_id' => Auth::user()->id
        ]);
        $reCount = PostLike::where('post_id', $request->postId)->count();
        return response()->json([
            'status' => 200,
            'message' => $reCount
        ]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
