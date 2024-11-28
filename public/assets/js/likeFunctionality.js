document.querySelectorAll('.likebtn').forEach(element => {
    $(element).click(function (e) { 
        e.preventDefault();
        let postId = $(element).data('post-id');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/likes/",
            data: {
                postId: postId
            },
            success: function (response) {
                if (response.status == 200) {
                    $(element).addClass('after-like');
                    $(`#like-count-${postId}`).html(response.message + ' Likes');

                }else if (response.status == 400) {
                    $(element).removeClass('after-like');
                    $(`#like-count-${postId}`).html(response.message + ' Likes');
                }
            }
        });
    });
});