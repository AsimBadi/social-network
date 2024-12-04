@extends('front-end.layouts.app')
@section('title', 'Explore')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-secondary explor_btn active" id="first_btn"
                    style="height: 30px; line-height: 30px; padding: 0 15px; width: 200px;" value="explore">Explore</button>
                <button type="button" class="btn btn-outline-secondary explor_btn" id="second_btn"
                    style="height: 30px; line-height: 30px; padding: 0 15px; width: 200px;"
                    value="followings">Followings</button>
            </div>
        </div>
    </div>
    <div class="main-div container-fluid mt-4 row" id="append-posts">
        @include('front-end.explore.load')
    </div>
    <div id="loader" style="text-align: center; display: none;">
        <p>Loading...</p>
    </div>
    <script src="{{ asset('assets/js/likeFunctionality.js') }}"></script>
@endsection
@push('js')
    <script>
        let currentPage = 1;
        let currentButton = 'explore';
        let isLoading = false;

        $('.explor_btn').on('click', function() {
            const buttonValue = $(this).val();

            if (currentButton !== buttonValue) {
                currentButton = buttonValue;

                $('.explor_btn').removeClass('active');
                $(this).addClass('active');

                $('#append-posts').empty();
                currentPage = 1;
                isLoading = false;

                if (currentButton === 'explore') {
                    publicPosts(currentPage);
                } else if (currentButton === 'followings') {
                    followingsPosts(currentPage);
                }
            }
        });

        function publicPosts(page) {
            if (isLoading) return;
            isLoading = true;

            $.ajax({
                url: "{{ route('explore.posts') }}",
                type: 'GET',
                data: {
                    page: page,
                    btn_val: 'explore'
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        $('#append-posts').append(response);
                        currentPage++;
                    }
                },
                complete: function() {
                    isLoading = false;
                },
                error: function(error) {
                    isLoading = false;
                }
            });
        }

        function followingsPosts(page) {
            if (isLoading) return;
            isLoading = true;

            $.ajax({
                url: "{{ route('explore.posts') }}",
                type: 'GET',
                data: {
                    page: page,
                    btn_val: 'followings'
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        $('#append-posts').append(response);
                        currentPage++;
                    }
                },
                complete: function() {
                    isLoading = false;
                },
                error: function(error) {
                    isLoading = false;
                }
            });
        }

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const scrollHeight = $(document).height();
            const windowHeight = $(this).height();

            if (scrollTop + windowHeight >= scrollHeight - 50 && !isLoading) {
                if (currentButton === 'explore') {
                    publicPosts(currentPage);
                } else if (currentButton === 'followings') {
                    followingsPosts(currentPage);
                }
            }
        });
        // Follow
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
                $(`#explore-${userId}`).removeClass('btn-dark');
                $(`#explore-${userId}`).addClass('btn-light');
                $(`#explore-${userId}`).text(response.message);
                if (response.message == 'Follow') {
                    $(`#explore-${userId}`).addClass('btn-dark');
                    $(`#explore-${userId}`).removeClass('btn-light');
                }
            }else if (response.status == 400) {
                $(`#explore-${userId}`).removeClass('btn-dark');
                $(`#explore-${userId}`).addClass('btn-light');
                $(`#explore-${userId}`).text(response.message);
                if (response.message == 'Follow') {
                    $(`#explore-${userId}`).addClass('btn-dark');
                    $(`#explore-${userId}`).removeClass('btn-light');
                }
            }
        }
    });
});

    </script>
@endpush
