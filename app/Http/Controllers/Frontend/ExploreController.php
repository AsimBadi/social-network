<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FollowUser;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller
{
    public function explorePosts(Request $request) {
        $page = $request->input('page', 1);
        $publicPrivacyUser = User::where('privacy', 1)->pluck('id')->toArray();
        $publicUserPosts = Post::with(['image', 'likes'])->whereIn('user_id', $publicPrivacyUser)->paginate(10, ['*'], 'page', $page);
        $usersFollowingList = FollowUser::where('followed_by_id', Auth::user()->id)->where('status', 2)->pluck('user_id')->toArray();
        
        if ($request->ajax()) {
            if ($request->btn_val == 'explore') {
                return view('front-end.explore.load', compact('publicUserPosts'))->render();
            }elseif($request->btn_val == 'followings') {
                $publicUserPosts = Post::with(['image', 'likes'])->whereIn('user_id', $usersFollowingList)->paginate(10, ['*'], 'page', $page);
                return view('front-end.explore.load', compact('publicUserPosts'))->render();
            }
        }
        return view('front-end.explore.index', compact('publicUserPosts'));
    }
}
