<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserMailRequest;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerifyUserMail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register() {
        return view('front-end.auth-pages.register');
    }

    public function login() {
        return view('front-end.auth-pages.login');
    }

    public function registerSave(RegisterRequest $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'gender' => $request->gender,
            'phone_no' => $request->phone_no,
        ]);

        VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);
        Mail::to($user->email)->send(new VerifyUserMail($user));
        return redirect()->back()->with('success', 'Please Check Your MailBox');
    }

    public function verifyUser($token) {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if ($verifyUser->user->verified == 0) {
            $verifyUser->user->verified = 1;
            $verifyUser->user->save();
            return redirect()->route('login')->with('success', 'Your Mail Is Verified');
        }elseif($verifyUser->user->verified == 1) {
            return redirect()->route('login')->with('success', 'Your Mail is Already Verified');
        }
    }

    public function loginCheck(LoginRequest $request) {
        $crenditials = $request->only('email', 'password');
            if(Auth::attempt($crenditials)) {
                return redirect()->route('profile.index');
            }else{
                return redirect()->route('login')->with('error', 'Either Mail or Password is Incorrect');
            }
    }

    public function userMailPage() {
        return view('front-end.forgot-password.user_mail');
    }

    public function sendMailForForgotPassword(UserMailRequest $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->route('user.mail.page')->with('success', 'Please Check your MailBox');
        }else{
            return redirect()->route('user.mail.page')->with('error', "You Are Not a Member");
        }
    }

    public function forgotPassword($token) {
        $verifyUser = verifyUser::where('token', $token)->first();
        if ($verifyUser) {
            return view('front-end.forgot-password.forgot_password', compact('verifyUser'));
        }else{
            return redirect()->route('login')->with('error', 'your mail is not found');
        }
    }

    public function newPassword(ForgotPasswordRequest $request) {
        $verifiedUser = VerifyUser::where('token', $request->user_token)->first();
        $findUser = User::where('id', $verifiedUser->user_id)->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('login')->with('success', 'Your Password Has Been Changed');
    }

}