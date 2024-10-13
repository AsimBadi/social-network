@extends('front-end.layouts.auth_frontend')
@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <h4>Login</h4>
                        </div>
                        <form class="pt-3" action="{{ route('login.check') }}" method="POST" id="login-form">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="exampleInputEmail1" placeholder="Email">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="exampleInputPassword1" placeholder="Password">
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn"
                                    type="submit">SIGN IN</button>
                            </div>
                            <div class="text-center mt-2">
                                <a href="{{ route('user.mail.page') }}" class="text-primary">Forgot Password?</a>
                            </div>
                            <div class="text-center mt-2 fw-light"> Don't have an account? <a
                                    href="{{ route('register') }}" class="text-primary">Create</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\Frontend\LoginRequest', '#login-form') !!}
@endsection
    