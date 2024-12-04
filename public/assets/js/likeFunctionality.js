$(document).on('click', '.likebtn', function () {
    let postId = $(this).data('post-id');
    let button = $(this);
    $.ajax({
        type: "POST",
        url: window.appRoutes.likeRoute,
        data: {
            postId: postId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                button.find('.like_icon').addClass('after-like');
                $(`#like-count-${postId}`).html(response.message + ' Likes');

            }else if (response.status == 400) {
                button.find('.like_icon').removeClass('after-like');
                $(`#like-count-${postId}`).html(response.message + ' Likes');
            }
        }
    });
});