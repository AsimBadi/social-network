@extends('front-end.layouts.app')
@section('content')
@forelse ($followRequests as $request)

<div id="user-{{ $request->followed_by_id }}">
    <div class="row mt-4 bg-dark p-3 d-flex justify-content-center align-items-center rounded-3">
        <div class="col-md-3">
            <a href="{{ route('goto.profile', $request->users->username) }}" style="text-decoration: none; color: inherit;"><img src="{{ $request->users->image_url }}" width="50px" height="50px"
                style="border-radius: 50px; object-fit: cover;" alt=""></a>
        </div>
        <div class="col-md-6 text-light">
            <a href="{{ route('goto.profile', $request->users->username) }}" style="text-decoration: none; color: inherit;"><h5>{{ $request->users->first_name }} {{ $request->users->last_name }}</h5></a>
            <h5>{{ $request->users->username }}</h5>
        </div>
        <div class="col-md-3">
            <button class="btn btn-danger btn-action" value="0" data-followed-by-id="{{ $request->followed_by_id }}"><i class="fa-solid fa-xmark"></i></button>
            <button class="btn btn-success btn-action" value="1" data-followed-by-id="{{ $request->followed_by_id }}"><i class="fa-solid fa-check"></i></button>
        </div>
    </div>
</div>
@empty
    <h2 class="text-center">No Requests Available</h2>
@endforelse
@endsection
@push('js')
    <script>
        $('.btn-action').click(function (e) { 
            e.preventDefault();
            let valueOfbtn = $(this).val();
            let followedById = $(this).data('followed-by-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "action/request",
                data: {
                    valueOfBtn: valueOfbtn,
                    followedById: followedById
                },
                success: function (response) {
                    if (response.status == 200) {
                        $(`#user-${followedById}`).empty();
                    }else if (response.status == 400) {
                        $(`#user-${followedById}`).empty();
                    }
                }
            });
        });
    </script>
@endpush