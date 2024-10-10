@extends('front-end.layouts.auth_frontend')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-12 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <h4>Register</h4>
                            <form class="pt-3" action="{{ route('register.save') }}" method="POST" id="register-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="first_name"
                                                id="exampleInputUsername1" placeholder="Enter First Name">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="last_name"
                                                id="exampleInputUsername1" placeholder="Enter Last Name">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="username"
                                                id="exampleInputEmail1" placeholder="Enter Username">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-lg" name="email"
                                                id="exampleInputPassword1" placeholder="Enter Email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" name="password"
                                                id="exampleInputPassword1" placeholder="Enter Password">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg"
                                                name="password_confirmation" id="exampleInputPassword1"
                                                placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-lg" name="phone_no"
                                                id="exampleInputPassword1" placeholder="Enter Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="gender" class="form-select text-dark">
                                                <option value="" hidden selected>Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 d-grid gap-2 d-flex justify-content-center">
                                        <button class="btn btn-block btn-primary auth-form-btn btn-sm w-50 fw-medium"
                                            type="submit">SIGN UP</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center mt-4 fw-light"> Already have an account? <a
                                            href="{{ route('login') }}" class="text-primary">Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! JsValidator::formRequest('App\Http\Requests\RegisterRequest', '#register-form') !!}
    @endsection