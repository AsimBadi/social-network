@extends('front-end.layouts.auth_frontend')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <h4>Change Password</h4>
                            </div>
                            <form class="pt-3" action="{{ route('change.password') }}" method="POST" id="forgot-password-form">
                                @csrf
                                <input type="hidden" name="user_token" value="{{ $verifyUser->token }}">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password"
                                        id="exampleInputPassword1" placeholder="New Password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password_confirmation"
                                        id="exampleInputPassword1" placeholder="Confirm New Password">
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn"
                                        type="submit">Change Password</button>
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" class="me-3">Login</a>
                                            <a href="{{ route('register') }}">Register</a>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#forgot-password-form') !!}
@endsection