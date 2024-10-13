@extends('front-end.layouts.app')
@section('content')
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="edit-post-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <label class="mb-2">Caption <span class="text-danger">*</span></label>
                <input type="text" name="caption" class="form-control" value="{{ $post->caption }}">
            </div>
            <div class="col-md-12 mt-3">
                <label class="mb-2">Image <span class="text-danger">*</span></label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            <div class="col-md-4 mt-3">
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="{{ route('profile.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
    <div class="row">
        @foreach ($post->image as $image)
            <div class="col-md-3 mt-3">
                <div class="card bg-dark" style="width: 12rem;">
                        <img src="{{ asset('storage/images/' . $image->image) }}" class="card-img-top delete-img" alt="" style="">
                        <div class="card-body">
                            <div class="form-check form-check-danger">
                                <label class="form-check-label text-light">
                                <input type="checkbox" class="form-check-input" name="remove_image[]" id="remove-post-array" value="{{ $image->id }}">Remove Picture<i class="input-helper"></i></label>
                              </div>
                        </div>
                </div>
            </div>
        @endforeach
    </div>
</form>
@endsection