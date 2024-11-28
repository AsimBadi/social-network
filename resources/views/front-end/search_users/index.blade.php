@extends('front-end.layouts.app')
@section('content')
    <div class="row">
        <div class="input-group">
            <div class="input-group-text"><i class="fa fa-search"></i></div>
            <input type="text" class="form-control" id="search-user" name="search_user" placeholder="Search User">
        </div>
    </div>
    <div id="append-html">

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let timeOut = null;

            $('#search-user').keyup(function(e) {
                clearTimeout(timeOut);
                let searchData = $(this).val();

                if (e.key === "Enter" || e.keyCode === 13) {
                    return;
                }
                if (searchData.trim() === "") {
                    $('#append-html').html('');
                    return;
                }

                timeOut = setTimeout(() => {
                    if (searchData.length > 1) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('search.user') }}",
                            data: {
                                searchData: searchData
                            },
                            success: function(response) {
                                $('#append-html').html(''); 
                                if (response.status == 200) {
                                    response.message.forEach(element => {
                                        let imageUrl = `{{ asset('storage/images/${element.profile_picture}') }}`
                                        let profileLink = `search/user/${element.username}`;
                                        
                                        $('#append-html').append(`
                                            <div class="row mt-4 bg-dark p-3 d-flex justify-content-center align-items-center rounded-3">
                                                <div class="col-md-3">
                                                    <a href="${profileLink}" style="text-decoration: none; color: inherit;"><img src="${element.image_url}" width="100px" height="100px"
                                                        style="border-radius: 50px" alt=""></a>
                                                </div>
                                                <div class="col-md-6 text-light">
                                                    <a href="${profileLink}" style="text-decoration: none; color: inherit;"><h3>${element.first_name} ${element.last_name}</h3></a>
                                                    <h5>@${element.username}</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-primary">Follow</button>
                                                </div>
                                            </div>
                                        `);
                                    });
                                }else if (response.status == 404) {
                                    let imageUrl = `{{ asset('assets/images/instagram_default/404.png') }}`;
                                    let image = `<img src="${imageUrl}" class="mt-3 d-block mx-auto"></img>`;
                                    $('#append-html').html(image);
                                }
                            }
                        });
                    }
                }, 200);
            });
        });
    </script>
@endpush
