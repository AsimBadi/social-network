@extends('front-end.layouts.app')
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

        $('.explor_btn').on('click', function() {
            const buttonValue = $(this).val();

            if (currentButton !== buttonValue) {
                currentButton = buttonValue;

                $('.explor_btn').removeClass('active');
                $(this).addClass('active');

                $('#append-posts').empty();
                currentPage = 1;

                if (currentButton === 'explore') {
                    publicPosts(currentPage);
                } else if (currentButton === 'followings') {
                    followingsPosts(currentPage);
                }
            }
        });

        function publicPosts(page) {
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
                    } else {
                        console.log('No more posts to load.');
                    }
                },
            });
        }

        function followingsPosts(page) {
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
                    } else {
                        console.log('No more posts to load.');
                    }
                },
            });
        }

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const scrollHeight = $(document).height();
            const windowHeight = $(this).height();

            if (scrollTop + windowHeight >= scrollHeight - 50) {
                if (currentButton === 'explore') {
                    publicPosts(currentPage);
                } else if (currentButton === 'followings') {
                    followingsPosts(currentPage);
                }
            }
        });
    </script>
@endpush
