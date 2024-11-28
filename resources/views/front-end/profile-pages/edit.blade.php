@extends('front-end.layouts.app')
@section('content')
<form action="{{ route('profile.update', $profileData->id) }}" method="POST" enctype="multipart/form-data">
    <div class="container-fluid row">
    @csrf
    @method('PUT')
    <div class="col-md-6">
        <label for="">Your First Name:</label>
        <input type="text" name="first_name" class="form-control" value="{{ $profileData->first_name }}" id="">
    </div>
    <div class="col-md-6">
        <label for="">Your Last Name:</label>
        <input type="text" name="last_name" class="form-control" value="{{ $profileData->last_name }}" id="">
    </div>
    <div class="col-md-12 mt-3">
        <label class="mb-2">Bio:</label>
        <textarea name="bio" class="form-control">{{ $profileData->bio }}</textarea>
    </div>
    <div class="col-md-12 mt-3">
        <label class="mb-2">Privacy:</label>
        <select name="privacy" class="form-select text-dark">
            <option value="1" selected @selected($profileData->privacy == '1')>Public</option>
            <option value="2" @selected($profileData->privacy == '2')>Private</option>
        </select>
    </div>
    <div class="col-md-12 mt-3">
        <label class="mb-2">Upload Your Profile Picture:</label>
        <input type="file" name="profile_picture" class="form-control">
    </div>
    <div class="row">
        <div class="col-md-4 mt-3">
            <button class="btn btn-primary" type="submit">Submit</button>
            <a href="{{ route('profile.index') }}" class="btn btn-dark">Back</a>
        </div>
        <input type="hidden" name="remove_dp" value="0" id="remove-dp">
    </div>
</div>
</form>
<div class="col-md-3 mt-3 d-flex justify-content-center @if ($profileData->profile_picture == null) d-none @endif">
    <div class="card bg-dark" style="width: 12rem;">
            <img src="{{ $profileData->image_url }}" class="card-img-top delete-img" alt="" style="">
            <div class="card-body">
                <div class="form-check form-check-danger">
                    <label class="form-check-label text-light">
                      <input type="checkbox" class="form-check-input" id="dp-checkbox">Remove Picture<i class="input-helper"></i></label>
                  </div>
            </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('#dp-checkbox').change(function (e) { 
                e.preventDefault();
                if ($(this).is(':checked')) {
                    $('#remove-dp').val('1');
                }else{
                    $('#remove-dp').val('0');
                }                
            });
        });
    </script>
@endpush