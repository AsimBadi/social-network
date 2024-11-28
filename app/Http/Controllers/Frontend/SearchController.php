<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FollowUser;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function searchView() {
        return view('front-end.search_users.index');
    }

    public function searchUser(Request $request) {
        if ($request->ajax()) {
            $users = User::where('username', 'like', "%$request->searchData%")->get();

            foreach ($users as $user) {
                $isUserFollowing = FollowUser::where('user_id', $user->id)->where('followed_by_id', Auth::user()->id)->get();
            }

            if ($users->isNotEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => $users,
                    // 'isUserFollowing' => $isUserFollowing
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'User not Found',
                ]);
            }
        }
    }

    public function goToProfile($username) {
        $user = User::where('username', $username)->first();
        $isUserFollowing = FollowUser::where('user_id', $user->id)->where('followed_by_id', Auth::user()->id)->first();
        // $posts = Post::withCount(['likes'])->where('user_id', Auth::user()->id)->get();

        if ($user->id == Auth::user()->id) {
            return redirect()->route('profile.index');
        }

        $totalPostsByUser = Post::where('user_id', $user->id)->count();
        $posts = Post::withCount(['image', 'likes'])->where('user_id', $user->id)->get();
        return view('front-end.profile-pages.show', compact('user', 'totalPostsByUser', 'posts', 'isUserFollowing'));
    }
}
