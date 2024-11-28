@extends('front-end.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $profileData->image_url }}" class="profile-picture" alt="">
        </div>
        <div class="col-md-3 text-center">
            <h4>Posts</h4>
            <h2>{{ $profileData->post }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followers</h4>
            <h2>{{ $profileData->follower_count }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followings</h4>
            <h2>{{ $profileData->followings }}</h2>
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
                        <p id="like-count-{{ $post->id }}">{{ $post->likes_count }} Likes</p>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" id="delete-form-{{ $post->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn-dialog float-end btn btn-outline-danger editBtnForPost" data-post-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#deleteConfirmation"><i
                                    class="fa-solid fa-trash-can"></i></button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="float-end btn btn-outline-secondary editBtnForPost"><i
                                class="fa-regular fa-file"></i></a>
                        <i class="fa-solid fa-heart fa-lg me-2 likebtn  @if ($post->user_likes)
                            after-like
                        @endif" data-post-id="{{ $post->id }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- Modal For Delete Confirmation --}}
    <div class="modal fade" id="deleteConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-times-circle x-mark"></i>
                    <p class="delete-text">Are you Sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deletebtn">Delete</button>
                </div>  
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/likeFunctionality.js') }}"></script>
    @endsection
@push('js')
    <script>
        $(document).ready(function () {
            
        $('.delete-btn-dialog').click(function (e) { 
            e.preventDefault();
            let postId = $(this).data('post-id');
            console.log(postId);
            $('#deletebtn').data('post-id', postId);
        });

        $('#deletebtn').click(function (e) { 
            e.preventDefault();
            let formId = $(this).data('post-id');
            $(`#delete-form-${formId}`).submit();
            
        });
    });
    </script>
@endpush