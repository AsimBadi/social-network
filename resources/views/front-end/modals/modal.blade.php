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