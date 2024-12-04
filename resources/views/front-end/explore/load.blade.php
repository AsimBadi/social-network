@foreach ($publicUserPosts as $post)
<div class="col-md-12 d-flex justify-content-center mb-4"> <!-- Ensure each post is inside a grid column -->
    <div class="card bg-dark" style="width: 100%; max-width: 50rem;"> <!-- Width set to 100% to fill the column -->
        <div class="d-flex p-2 align-items-center">
            <a href="{{ route('goto.profile', $post->user->username) }}" style="text-decoration: none; color: ingerit;"><img src="{{ $post->user->image_url }}" style="object-fit: cover; width: 50px; height: 50px" class="rounded-circle ms-3"></a>
            <a href="{{ route('goto.profile', $post->user->username) }}" style="text-decoration: none; color: ingerit;"><h4 class="text-white ms-2">{{ $post->user->username }}</h4></a>
            @if (count($post->user->is_user_following) == 0)
            {{-- @endif --}}
            <button class="btn btn-dark ms-auto me-2 follow-btn user_following" id="explore-{{ $post->user->id }}" data-following-by-id="{{ $post->user->id }}">Follow</button>
            @endif
            @foreach ($post->user->is_user_following as $alreadyFollowed)
            @if ($alreadyFollowed->status == 2)
            <button class="btn btn-light ms-auto me-2 follow-btn user_following" id="explore-{{ $post->user->id }}" data-following-by-id="{{ $post->user->id }}">Following</button>
            @endif
            @endforeach
        </div>
        <!-- Carousel inside card -->
        <div id="carouselExample-{{ $post->id }}" class="carousel slide" style="height: 350px;">
            <div class="carousel-inner" style="height: 100%;">
                @foreach ($post->image as $i => $images)
                <div class="carousel-item @if ($i == 0) active @endif" style="height: 100%;">
                    <img src="{{ asset('storage/images/' . $images->image) }}" class="d-block w-100"
                        alt="" style="object-fit: cover; width: 100%; height: 100%;"> <!-- Ensure images fill the carousel -->
                </div>
                @endforeach
            </div>
            @if (count($post->image) > 1)                
            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample-{{ $post->id }}"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample-{{ $post->id }}"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
        <!-- Card Body for caption and other content -->
        <div class="card-body text-light bg-dark rounded-bottom">
            <p class="card-text">{{ $post->caption }}</p>
            <p id="like-count-{{ $post->id }}">{{ $post->likes_count }} Likes</p>
            <i class="fa-solid fa-heart fa-lg me-2 likebtn @if ($post->user_likes) after-like @endif" data-post-id="{{ $post->id }}"></i>
        </div>
    </div>
</div>
@endforeach