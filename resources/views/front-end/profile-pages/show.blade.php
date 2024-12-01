@extends('front-end.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $user->image_url }}" class="profile-picture" alt="">
        </div>
        <div class="col-md-3 text-center">
            <h4>Posts</h4>
            <h2>{{ $user->post }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followers</h4>
            <h2>{{ $user->follower_count }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4>Followings</h4>
            <h2>{{ $user->followings }}</h2>
        </div>
    </div>
    <div class="row mt-2">
        <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
        <h4>{!! nl2br(e($user->bio)) !!}</h4>
        <div class="ms-2 mt-2 follow-btn-div">
            <button class="btn follow-btn w-100
                @if ($isUserFollowing == null)
                btn-primary
                @else
                btn-light
                @endif"
                data-user-id="{{ $user->id }}">
                @if ($isUserFollowing == null)
                    Follow
                @elseif ($isUserFollowing->status == 1 && $user->privacy == 2 && $isUserFollowing)
                    Requested
                @elseif (($isUserFollowing && $isUserFollowing->status == 2) || $user->privacy == 1)
                    Following
                @endif
            </button>
        </div>
    </div>

    @if ($user->privacy == 2 && $isUserFollowing == null)
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/images/instagram_default/private_account.png') }}" width="50%"
                style="object-fit: cover;" height="" alt="">
        </div>
    @endif

    @if ($user->privacy == 2 && $isUserFollowing && $isUserFollowing->status == 1)
    <div class="d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/images/instagram_default/private_account.png') }}" width="50%"
            style="object-fit: cover;" height="" alt="">
    </div>
    @endif
    @if ($user->privacy == 1 || ($isUserFollowing && $isUserFollowing->status == 2))
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
                            {{-- @dd($post) --}}
                            <p class="card-text">{{ $post->caption }}</p>
                            <p id="like-count-{{ $post->id }}">{{ $post->likes_count }} Likes</p>
                            <button class="btn btn-outline-info editBtnForPost ms-0 likebtn" data-post-id="{{ $post->id }}"><i class="fa-solid fa-heart like_icon  @if ($post->user_likes) after-like @endif"></i></button>
                            <button class="btn btn-outline-secondary editBtnForPost comment_section_modal_class" data-bs-toggle="modal" data-bs-target="#commentSection" id="comment_section_modal_btn" data-post-id="{{ $post->id }}">
                                <i class="fa-solid fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
    @endif
    {{-- Modal For Showing Comments --}}
    <div class="modal fade" id="commentSection" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Comments</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body append_comments" id="append_comments_div">
                    {{-- append comments --}}                  
                </div>
                <div class="modal-footer d-flex align-items-center">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control append_post_id comment_input_value" name="comment_input" id="comment_input_area" placeholder="Type here...">
                        <button class="btn btn-primary submitbtn" type="button" id="comment_submit"><i class="fa-solid fa-arrow-up"></i></button>
                      </div>
                </div>                
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/likeFunctionality.js') }}"></script>
    <script src="{{ asset('assets/js/commentFunctionality.js') }}"></script>
@endsection
@push('js')
    <script>
        window.appRoutes = {
            loadComments: "{{ route('load.comments') }}",
            submitComment: "{{ route('submit.comment') }}",
            gotoProfile: "{{ route('goto.profile', ':username') }}",
            userId: @json(Auth::user()->id),
            removeComment: "{{ route('remove.comment') }}"
        }
        $(document).ready(function () {
            $('.follow-btn').click(function (e) { 
                e.preventDefault();
                let userId = $(this).data('user-id');
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('search.follow') }}",
                    data: {
                        userId: userId
                    },
                    success: function (response) {
                        if (response.status == 200) {
                            $('.follow-btn').removeClass('btn-primary');
                            $('.follow-btn').addClass('btn-light');
                            $('.follow-btn').text(response.message);
                            if (response.message == 'Follow') {
                                $('.follow-btn').addClass('btn-primary');
                                $('.follow-btn').removeClass('btn-light');
                            }
                        }else if (response.status == 400) {
                            $('.follow-btn').removeClass('btn-primary');
                            $('.follow-btn').addClass('btn-light');
                            $('.follow-btn').text(response.message);
                            if (response.message == 'Follow') {
                                $('.follow-btn').addClass('btn-primary');
                                $('.follow-btn').removeClass('btn-light');
                            }
                        }
                    }
                });
            });
        });
    </script>

@endpush