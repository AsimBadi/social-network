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
            <h4 data-bs-toggle="modal" data-bs-target="#followers_modal" class="load_followers">Followers</h4>
            <h2 data-bs-toggle="modal" data-bs-target="#followers_modal" class="load_followers">{{ $profileData->follower_count }}</h2>
        </div>
        <div class="col-md-3 text-center">
            <h4 data-bs-toggle="modal" data-bs-target="#followings_modal" class="load_followings">Followings</h4>
            <h2 data-bs-toggle="modal" data-bs-target="#followings_modal" class="load_followings">{{ $profileData->followings }}</h2>
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
            <div class="col-md-4 mt-2" id="post-id-{{ $post->id }}">
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
                        @if (count($post->image) > 1)                            
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExample-{{ $post->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExample-{{ $post->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                        @endif
                    </div>
                    <div class="card-body text-light">
                        <p class="card-text">{{ $post->caption }}</p>
                        <p id="like-count-{{ $post->id }}">{{ $post->likes_count }} Likes</p>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            id="delete-form-{{ $post->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete_post_btn float-end btn btn-outline-danger editBtnForPost"
                                data-post-id="{{ $post->id }}"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="float-end btn btn-outline-secondary editBtnForPost"><i
                                class="fa-regular fa-file"></i></a>

                        <button class="btn btn-outline-info editBtnForPost ms-0 likebtn" data-post-id="{{ $post->id }}"><i class="fa-solid fa-heart like_icon  @if ($post->user_likes) after-like @endif"></i></button> 

                        <button class="btn btn-outline-secondary editBtnForPost comment_section_modal_class" data-bs-toggle="modal" data-bs-target="#commentSection" id="comment_section_modal_btn" data-post-id="{{ $post->id }}">
                            <i class="fa-solid fa-comment"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
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
    {{-- Modal For Showing Followers --}}
    <div class="modal fade" id="followers_modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Followers</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="followers_append_div">
                    {{-- append followers --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Modal For Showing Followings --}}
    <div class="modal fade" id="followings_modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Followings</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="followings_append_div">
                    {{-- append followings --}}
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
// Remove Post
$(document).on('click', '.delete_post_btn', function (e) { 
            e.preventDefault();
                Swal.fire({
                title: "Are Sure You Want to Delete?",
                icon: "error",
                showCancelButton: true,
                confirmButtonText: "Remove",
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let postId = $(this).data('post-id');
                    const url = "{{ route('posts.destroy', ':post_id') }}".replace(':post_id', postId);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response) {
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Post is Deleted!',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            });
                            $(`#post-id-${postId}`).empty();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                            }
                        }
                    });
                }else{
                    return;
                }
                
            });
        });
// remove followers
        $(document).on('click', '.remove_follower_btn', function (e) { 
            e.preventDefault();
                Swal.fire({
                title: "Are Sure You Want to Remove?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Remove",
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let followedById = $(this).data('followed-by-id');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('remove.follower') }}",
                        data: {
                            followed_by_id: followedById
                        },
                        success: function (response) {
                            if (response) {
                                $(`#follower-id-${followedById}`).empty();
                                Swal.fire("Removed!", "", "success");                   
                            }
                        }
                    });
                }else{
                    return;
                }
                
            });
        });
// load followers
        $('.load_followers').click(function (e) { 
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('load.followers') }}",
                success: function (response) {
                    $('#followers_append_div').empty();
                    response.forEach(element => {
                        let profileLink = "{{ route('goto.profile', ':username') }}".replace(':username', element.users.username);                        
                        html = `
                        <div id="follower-id-${element.users.id}">
                            <div class="d-flex justify-content-between align-items-center mt-1 border border-light bg-light p-2 mt-1 rounded-1">
                                <div class="d-flex align-items-center">
                                    <a href="${profileLink}">
                                        <img src="${element.users.image_url}" class="rounded-circle"
                                        width="50px" height="50px" alt="">    
                                    </a>
                                </div>
                                <div class="d-flex align-items-center flex-grow-1 justify-content-center">
                                    <a href="${profileLink}" style="text-decoration: none; color: inherit;">
                                        <span>${element.users.first_name} ${element.users.last_name}</span>    
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-danger remove_follower_btn" data-followed-by-id="${element.users.id}" data-user-first-name="${element.users.first_name}" data-user-last-name="${element.users.last_name}">Remove</button>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#followers_append_div').append(html);
                    });
                }
            });
        });

// load Followings
$('.load_followings').click(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: "{{ route('load.followings') }}",
        success: function (response) {
            $('#followings_append_div').empty();
            response.forEach(element => {
                let profileLink = "{{ route('goto.profile', ':username') }}".replace(':username', element.followings.username);
                html = `
                <div id="following-id-${element.followings.id}">
                    <div class="d-flex justify-content-between align-items-center mt-1 border border-light bg-light p-2 mt-1 rounded-1">
                        <div class="d-flex align-items-center">
                            <a href="${profileLink}">
                                <img src="${element.followings.image_url}" class="rounded-circle"
                                width="50px" height="50px" alt="">    
                            </a>
                        </div>
                        <div class="d-flex align-items-center flex-grow-1 justify-content-center">
                            <a href="${profileLink}" style="text-decoration: none; color: inherit;">
                                <span>${element.followings.first_name} ${element.followings.last_name}</span>    
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-light user_following" id="following-${element.followings.id}" data-following-by-id="${element.followings.id}" data-user-first-name="${element.followings.first_name}" data-user-last-name="${element.followings.last_name}">Following</button>
                        </div>
                    </div>
                </div>
                `;
                $('#followings_append_div').append(html);
            });
        }
    });
});

$(document).on('click', '.user_following', function (e) {
    e.preventDefault();
    const userId = $(this).data('following-by-id');
    $.ajax({
        type: "POST",
        url: "{{ route('search.follow') }}",
        data: {
            userId: userId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                $(`#following-${userId}`).removeClass('btn-primary');
                $(`#following-${userId}`).addClass('btn-light');
                $(`#following-${userId}`).text(response.message);
                if (response.message == 'Follow') {
                    $(`#following-${userId}`).addClass('btn-primary');
                    $(`#following-${userId}`).removeClass('btn-light');
                }
            }else if (response.status == 400) {
                $(`#following-${userId}`).removeClass('btn-primary');
                $(`#following-${userId}`).addClass('btn-light');
                $(`#following-${userId}`).text(response.message);
                if (response.message == 'Follow') {
                    $(`#following-${userId}`).addClass('btn-primary');
                    $(`#following-${userId}`).removeClass('btn-light');
                }
            }
        }
    });
});
</script>
@endpush
