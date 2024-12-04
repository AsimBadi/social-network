<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use App\Models\FollowUser;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
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
        $posts = Post::withCount(['image', 'likes'])->where('user_id', Auth::user()->id)->get();
        $userFollowers = FollowUser::where('user_id', Auth::user()->id)->count();
        return view('front-end.profile-pages.profile', compact('posts', 'totalPostsByUser', 'userFollowers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front-end.profile-pages.edit');
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
        $profileData = User::findOrFail($id);
        abort_if($profileData->id != Auth::user()->id, 403);
        return view('front-end.profile-pages.edit', compact('profileData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, string $id)
    {
        $profile = User::findOrFail($id);
        
        if ($request->remove_dp == 1) {
            $profile->profile_picture =  null;
            $profile->save();
        }
        
        if ($request->hasFile('profile_picture')) {
            $newImagePath = uniqid() . '.' . $request->profile_picture->getClientOriginalExtension();
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

    public function showFollowers(Request $request) {
        if ($request->ajax()) {
            if ($request->other_user == 'not_author') {
                $isUserPrivate = User::find($request->user_id);
                $isUserFollowing = FollowUser::where('user_id', $request->user_id)->where('followed_by_id', Auth::user()->id)->exists();
                if ($isUserPrivate->privacy == 2 && !$isUserFollowing) {
                    return response()->json(true, 400);
                }else{
                $followers = FollowUser::with('users')->where('user_id', $request->user_id)->where('status', 2)->get();
                return response()->json($followers, 200);
                }
            }else{
                $followers = FollowUser::with('users')->where('user_id', Auth::user()->id)->where('status', 2)->get();
                return response()->json($followers, 200);
            }
        }
    }

    public function showFollowings(Request $request) {
        if ($request->ajax()) {
            if ($request->other_user == 'not_author') {
                $isUserPrivate = User::find($request->user_id);
                $isUserFollowing = FollowUser::where('user_id', $request->user_id)->where('followed_by_id', Auth::user()->id)->exists();
                if ($isUserPrivate->privacy == 2 && !$isUserFollowing) {
                    return response()->json(true, 400);
                }else{
                $followings = FollowUser::with('followings')->where('followed_by_id', $request->user_id)->where('status', 2)->get();
                return response()->json($followings, 200);
                }
            }else{
                $followings = FollowUser::with('followings')->where('followed_by_id', Auth::user()->id)->where('status', 2)->get();
                return response()->json($followings, 200);
            }
        }
    }

    public function removeFollower(Request $request) {
        if ($request->ajax()) {
            FollowUser::where('user_id', Auth::user()->id)->where('followed_by_id', $request->followed_by_id)->delete();
            return response()->json(true, 200);
        }
    }
}
