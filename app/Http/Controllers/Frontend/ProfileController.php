<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPostsByUser = Post::where('user_id', Auth::user()->id)->count();
        $profileData = Profile::where('user_id', Auth::user()->id)->first();
        $posts = Post::with('image')->where('user_id', Auth::user()->id)->get();
        return view('front-end.profile-pages.profile', compact('profileData', 'posts', 'totalPostsByUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front-end.profile-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $profileData = Profile::findOrFail($id);
        return view('front-end.profile-pages.create', compact('profileData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, string $id)
    {
        $profile = Profile::findOrFail($id);
        
        if ($request->remove_dp == 1) {
            $profile->profile_picture =  'instagram_default.png';
            $profile->save();
        }
        
        if ($request->hasFile('profile_picture')) {
            $newImagePath = time() . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->file('profile_picture')->storeAs('images', $newImagePath);
        }else{
            $newImagePath = $profile->profile_picture;
        }

        $profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'bio' => $request->bio,
            'privacy' => $request->privacy,
            'profile_picture' => $newImagePath
        ]);

        return redirect()->route('profile.index')->with('success', 'Your Profile Has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
