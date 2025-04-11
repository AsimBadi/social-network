<template>
    <div class="col-md-4 mt-2" id="post-id-34">
        <div class="card mt-2 bg-dark" style="width: 18rem">
            <div id="carouselExample-34" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="http://127.0.0.1:8000/storage/images/67f7477ce5cd0.jpg" class="d-block w-100 post-images" alt=""/>
                    </div>
                </div>
            </div>
            <div class="card-body text-light">
                <p class="card-text">Post 1</p>
                <p id="like-count-34">0 Likes</p>
                <form>
                    <button type="button" class="delete_post_btn float-end btn btn-outline-danger editBtnForPost">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
                <a class="float-end btn btn-outline-secondary editBtnForPost">
                    <i class="fa-regular fa-file"></i>
                </a>
                <button class="btn btn-outline-info editBtnForPost ms-0 likebtn">
                    <i class="fa-solid fa-heart like_icon"></i>
                    <font-awesome-icon :icon="['fas', 'heart']" />

                </button>
                <button class="btn btn-outline-secondary editBtnForPost comment_section_modal_class">
                    <i class="fa-solid fa-comment"></i>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup></script>
