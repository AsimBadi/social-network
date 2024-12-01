<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PostRequest;
use App\Http\Requests\Frontend\UpdatepostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front-end.posts.create');
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
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'caption' => $request->caption,
            'user_id' => Auth::user()->id
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newImagePath = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images', $newImagePath);

                PostImage::create([
                    'image' => $newImagePath,
                    'post_id' => $post->id
                ]);
            }
        }
        return redirect()->route('profile.index')->with('success', 'Your post has been created');
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
        $post = Post::with('image')->findOrFail($id);
        abort_if($post->user_id != Auth::user()->id, 403);
        // $images = PostImage::where('post_id', $id)->where('user_id')->get();
        return view('front-end.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        abort_if($post->user_id != Auth::user()->id, 403);
        $countPostImages = PostImage::where('post_id', $id)->count();
        
        if ($request->remove_image) {
            $remainingImages = $countPostImages - count($request->remove_image);
            $imagesToDelete = PostImage::whereIn('id', $request->remove_image)->get();
        
            foreach ($imagesToDelete as $deleteImage) {
                $imagePath = storage_path('app/public/images/' . $deleteImage); 
                // if (file_exists($imagePath)) {
                //     unlink($imagePath);
                // }
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            if ($remainingImages > 0) {
                PostImage::whereIn('id', $request->remove_image)->delete();
            }else{
                return redirect()->back()->with('error', 'You have to keep one Image');
            }
        }
        
        $post->update([
            'caption' => $request->caption,
        ]);

        if ($request->images !== null) {
            foreach ($request->images as $image) {
                $newImagePath = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images', $newImagePath);

                PostImage::create([
                    'image' => $newImagePath,
                    'post_id' => $id
                ]);
            }
        }
        return redirect()->route('profile.index')-> with('success', 'Your post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (request()->ajax()) {
            Post::findOrFail($id)->delete();
            PostImage::where('post_id', $id)->delete();
            Comment::where('post_id', $id)->delete();
            PostLike::where('post_id', $id)->delete();
            return response()->json(true, 200);
        }
    }
}
