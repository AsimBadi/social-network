<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FollowUser;
use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followRequest(Request $request) {
       if ($request->ajax()) {
            $findUser = User::findOrFail($request->userId);
            $isUserAlreadyFollowed = FollowUser::where('user_id', $request->userId)->where('followed_by_id', Auth::user()->id)->first();

            if ($isUserAlreadyFollowed != null) {
                if ($isUserAlreadyFollowed->status == 2) {
                    FollowUser::where('user_id', $request->userId)->where('followed_by_id', Auth::user()->id)->delete();
                    return response()->json([
                        'status' => 400,
                        'message' => 'Follow'
                    ]);
                }elseif ($isUserAlreadyFollowed->status == 1) {
                    FollowUser::where('user_id', $request->userId)->where('followed_by_id', Auth::user()->id)->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Follow'
                    ]);
                }
            }

            if ($findUser->privacy == 2) {
                FollowUser::create([
                    'user_id' => $request->userId,
                    'followed_by_id' => Auth::user()->id,
                    'status' => 1
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Requested'
                ]);
            }elseif($findUser->privacy == 1) {
                FollowUser::create([
                    'user_id' => $request->userId,
                    'followed_by_id' => Auth::user()->id,
                    'status' => 2
                ]);
                $followedUser = User::find($request->userId);
                $userToFollow->notify(new UserFollowed($followedUser));
                return response()->json([
                    'status' => 400,
                    'message' => 'Following'
                ]);
            }
       }
    }

    public function followRequests() {
        $followRequests = FollowUser::with('users')->where('user_id', Auth::user()->id)->where('status', 1)->get();
        return view('front-end.requests.index', compact('followRequests'));        
    }

    public function actionOfRequest(Request $request) {
        if ($request->valueOfBtn == 0) {
            FollowUser::where('user_id', Auth::user()->id)->where('followed_by_id', $request->followedById)->delete();
            return response()->json([
                'status' => 400,
                'message' => 'User Removed Successfully'
            ]);
        }else{
            $acceptRequest = FollowUser::where('user_id', Auth::user()->id)->where('followed_by_id', $request->followedById)->first();
            $acceptRequest->update([
                'status' => 2
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'User Added Successfully'
            ]);
        }
    }
}
