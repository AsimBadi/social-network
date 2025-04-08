<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserManagementRequest;
use App\Http\Resources\UserResource;
use App\Models\SuspendedUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function users(Request $request)
    {
        $perPage = $request->input('perPage');
        $todayDate = Carbon::today()->toDateString();
        $users = User::with(['suspendedUser' => function ($query) use ($todayDate) {
            $query->whereDate('from', $todayDate)->whereDate('to', '>=', $todayDate);
        }])->paginate($perPage);

        return UserResource::collection($users);
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return response()->json(['user' => $user], 200);
    }

    public function updateUser(UserManagementRequest $request, $id)
    {
        // dd($request->all());
        $user = User::find($id);
        if($request->remove_dp == 1)
        {
            $user->profile_picture = null;
            $user->save();   
        }

        if($request->has('profile_picture'))
        {
            $file = $request->profile_picture;
            $newImagePath = uniqid() . '.' . $file->getClientOriginalExtension();
            $request->file('profile_picture')->storeAs('images', $newImagePath);
        }else{
            $newImagePath = $user->profile_picture;
        }

        $user->update([
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name' => $request->last_name ?? $user->last_name,
            'username' => $request->username ?? $user->username,
            'email' => $request->email ?? $user->email,
            'password' => Hash::make($request->password) ?? $user->password,
            'gender' => $request->gender ?? $user->gender,
            'phone_no' => $request->phone_no ?? null,
            'verified' => $request->verified ?? $user->verified,
            'bio' => $request->bio ?? null,
            'privacy' => $request->privacy ?? $user->privacy,
            'profile_picture' => $newImagePath,
        ]);
        return response()->json('User Updated', 200);
    }

    public function deleteUser($id)
    {
        User::find($id)->delete();
        return response()->json('User Deleted');
    }

    public function suspendUser(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'from' => 'required',
            'to' => 'required'
        ]);
        $user = User::find($id);
        $user->is_suspended = 1;
        $user->is_banned = 0;
        $user->save();
        $isUserAlreadySuspended = SuspendedUser::where('user_id', $id)->first();
        if($isUserAlreadySuspended){
            SuspendedUser::find($isUserAlreadySuspended->id)->update([
                'user_id' => $user->id,
                'from' => $request->from,
                'to' => $request->to,
            ]);
            return response()->json('User Suspended', 200);    
        }else{
            SuspendedUser::create([
                'user_id' => $user->id,
                'from' => $request->from,
                'to' => $request->to,
            ]);
            return response()->json('User Suspended', 200);
        }
    }

    public function banUser($id)
    {
        User::find($id)->update([
            'is_banned' => '1' 
        ]);
        SuspendedUser::where('user_id', $id)->delete();
        return response()->json('User is Banned', 200);
    }
}
