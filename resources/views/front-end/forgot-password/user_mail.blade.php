@extends('front-end.layouts.auth_frontend')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <h4>Forgot Password</h4>
                            </div>
                            <form class="pt-3" action="{{ route('send.mail.verify') }}" method="POST" id="verify-email">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        id="exampleInputPassword1" placeholder="Enter Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn"
                                        type="submit">Submit</button>
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
{!! JsValidator::formRequest('App\Http\Requests\Frontend\UsermailRequest', '#verify-email') !!}
@endsection