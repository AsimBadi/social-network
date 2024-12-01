// Comment Functionality
// Pass Post-Id to Submit Button
$('.comment_section_modal_class').click(function (e) { 
    e.preventDefault();
    const postId = $(this).data('post-id');
    loadComments(postId);
    $('.submitbtn').data('post-id', postId);
});
// Submit Comment
$('.submitbtn').click(function (e) { 
    e.preventDefault();
    const postId = $(this).data('post-id');
    const commentInput = $('.comment_input_value').val();    
    $.ajax({
        type: "POST",
        url: window.appRoutes.submitComment,
        data: {
            comment_input: commentInput,
            post_id: postId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            loadComments(postId);
            $('.comment_input_value').val('');
        }
    });
});

// load comments
function loadComments(postId) {
    const userId = window.appRoutes.userId;     
    $.ajax({
        type: "GET",
        url: window.appRoutes.loadComments,
        data: {
            post_id: postId
        },
        success: function (response) {
          $('#append_comments_div').empty();
          response.forEach(element => {
            let profileLink = window.appRoutes.gotoProfile.replace(':username', element.user.username);
            let html = `
                <div id="comment_element_div_${element.id}" class="toast align-items-center mt-2 text-bg-dark border-0 custom-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="d-flex">
                        <div class="toast-body">
                            <a href="${profileLink}"><img src="${element.user.image_url}" width="30px" height="30px" class="rounded-circle" alt=""></a>
                            <span class="ms-2">${element.comment}</span>
                        </div>`;
                    if (element.user.id == userId) {
                        html += `<button type="button" class="btn btn-white me-2 m-auto remove_comment" data-user-id="${userId}" data-comment-id="${element.id}"><i class="fa-solid fa-trash-can"></i></button>`;
                    }
                    html += `</div>
                </div>`;

            $('#append_comments_div').append(html);
            $('.toast').toast('show');
        });          
        }
    });
}
// remove comment
$(document).on('click', '.remove_comment', function () {
    const userId = $(this).data('user-id');
    const commentId = $(this).data('comment-id');
    
    $.ajax({
        type: "POST",
        url: window.appRoutes.removeComment,
        data: {
            user_id: userId,
            comment_id: commentId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $(`#comment_element_div_${commentId}`).empty();
        }
    });
    
});