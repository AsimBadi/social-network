@extends('front-end.layouts.app')
@section('content')
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <label>Caption <span class="text-danger">*</span></label>
                <input type="text" name="caption" class="form-control mt-2">
                @error('caption')
                    <spa class="text-danger">{{ $message }}</spa>
                @enderror
            </div>
            <div class="col-md-12 mt-3">
                <label>Images <span class="text-danger">*</span></label>
                <input type="file" name="images[]" class="form-control mt-2" multiple>
                @error('images')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4 mt-3">
                <button class="btn btn-primary" type="submit">Post</button>
            </div>
        </div>
    </form>
{!! JsValidator::formRequest('App\Http\Requests\Frontend\PostRequest', '#post-form') !!}
@endsection