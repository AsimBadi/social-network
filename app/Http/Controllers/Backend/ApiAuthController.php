<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\JwtAuthMiddleware;
use App\Http\Requests\Backend\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthController extends Controller
{
    public function register()
    {

    }

    public function login(LoginRequest $request)
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        try {
            $token = JWTAuth::attempt($credentials);
            if(!$token)
            {
                return response()->json('Invalid Credentials', 422);
            }
            
            $user = auth()->user();
            return response()->json(['token' => $token, 'user' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getuser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json('Logout Successful', 200);   
    }

    public function dashboard()
    {
        $totalPosts = Post::count();
        $totalLikes = PostLike::count();
        $totalUsers = User::count();
        $totalComments = Comment::count();
        return response()->json([
            'posts' => $totalPosts,
            'likes' => $totalLikes,
            'users' => $totalUsers,
            'comments' => $totalComments
        ], 200);
    }

    public function users()
    {
        $users = User::all();
        return UserResource::collection($users);
    }
}
