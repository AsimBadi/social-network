@extends('front-end.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <img src="{{ asset('storage/images/' . $profileData->profile_picture) }}" class="profile-picture" alt="">
        </div>
        <div class="col-md-3 text-center">
            <h4>Posts</h4>
            <h2>{{ $totalPostsByUser }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followers</h4>
            <h2>235</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followings</h4>
            <h2>457</h2>
        </div>
    </div>
    <div class="row mt-2">
        <h4>{{ $profileData->first_name }} {{ $profileData->last_name }}</h4>
        <h4>{!! nl2br(e($profileData->bio)) !!}</h4>
    </div>
    <div>
        <a href="{{ route('profile.edit', $profileData->id) }}" class="btn btn-dark mt-2 editbtn">Edit Profile</a>
    </div>
    <hr>

    <div class="row">
        @foreach ($posts as $i => $post)
            <div class="col-md-4 mt-2">
                <div class="card mt-2 bg-dark" style="width: 18rem;">
                    <div id="carouselExample-{{ $post->id }}" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach ($post->image as $i => $image)
                                <div class="carousel-item @if ($i == 0) active @endif">
                                    <img src="{{ asset('storage/images/' . $image->image) }}"
                                        class="d-block w-100 post-images" alt="">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExample-{{ $post->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExample-{{ $post->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="card-body text-light">
                        <p class="card-text">{{ $post->caption }}</p>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="float-end btn btn-outline-danger editBtnForPost"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteConfirmation"><i
                                    class="fa-solid fa-trash-can"></i></button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="float-end btn btn-outline-secondary editBtnForPost"><i
                                class="fa-regular fa-file"></i></a>
                        <i class="fa-solid fa-heart fa-lg me-2"></i>
                        <i class="fa-regular fa-comment fa-lg me-2"></i>
                        <i class="fa-solid fa-share fa-lg"></i>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('#deletebtn').click(function (e) { 
                e.preventDefault();
                $('#delete-form').submit();
            });
        });
    </script>
@endpush