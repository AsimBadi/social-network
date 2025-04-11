<template>
    <div class="d-flex justify-content-end align-items-center mb-2">
        <input type="text" class="form-control w-50 ms-auto" v-model="postSearch" placeholder="Search Post">
    </div>
    <div class="row mt-2">
        <div class="col-md-3 mb-2" v-for="post in posts" :key="post.id">
            <div class="card mt-2 bg-dark" style="width: 18rem">
                <CCarousel :controls="post.image.length > 1">
                    <CCarouselItem v-for="(image, i) in post.image" :key="i">
                        <img class="d-block w-100 post-images" :src="image.image" alt="slide 1"/>
                    </CCarouselItem>
                </CCarousel>

                <div class="card-body text-light">
                    <p class="card-text">{{ post.caption }}</p>
                    <p>{{ post.likes }} Likes</p>
                    <form>
                        <button type="button" class="float-end btn btn-outline-danger" @click="deletePost(post.id)">
                            <CIcon :icon="'cilTrash'"  />
                        </button>
                    </form>
                    <button class="btn btn-outline-primary me-2" @click="router.push({ name: 'EditPost', params: { id: post.id}})">
                        <i class="fa-regular fa-file"></i>
                        <CIcon :icon="'cilPencil'"  />
                    </button>
                    <button class="btn btn-outline-success me-2" @click="() => { visibleVerticallyCenteredDemo = true, loadComments(post.id)}">
                        <i class="fa-regular fa-file"></i>
                        <CIcon :icon="'cilCommentBubble'"/>
                    </button>
                    <button class="btn btn-outline-secondary" @click="router.push({name: 'ViewPost', params:{id: post.id}})">
                        <i class="fa-regular fa-file"></i>
                        <CIcon :icon="'cilFile'"  />
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <select class="form-select me-2 mb-3" v-model="itemsPerPage" style="width: 80px;">
            <option value="8">8</option>
            <option value="16">16</option>
            <option value="32">32</option>
            <option value="40">40</option>
        </select>
        <vue-awesome-paginate
            :total-items="totalItems"
            :items-per-page="Number(itemsPerPage)"
            :max-pages-shown="totalPages"
            v-model="currentPage"
            :show-breakpoint-buttons="false"
            :show-jump-buttons="true"
            @click="onClickHandler"
        />
    </div>
    <CModal alignment="center" :visible="visibleVerticallyCenteredDemo" @close="() => { visibleVerticallyCenteredDemo = false }" aria-labelledby="VerticallyCenteredExample">
    <CModalHeader>
      <CModalTitle id="VerticallyCenteredExample">Comments</CModalTitle>
    </CModalHeader>
    <CModalBody>
        <CToast :autohide="false" color="primary" v-for="comment in comments" :key="comment.id" class="text-white w-100 align-items-center mb-2" visible>
            <div class="d-flex">
                <CToastBody>{{ comment.comment }}</CToastBody>
                <!-- <CToastClose :icon="'cilTrash'" class="me-2 m-auto" white /> -->
                <CToastClose class="me-2 m-auto" white @click="deleteComment(comment.id)"/>
            </div>
        </CToast>
    </CModalBody>
    <CModalFooter>
      <CButton color="secondary" @click="() => { visibleVerticallyCenteredDemo = false }">
        Close
      </CButton>
      <!-- <CButton color="primary" >Save changes</CButton> -->
    </CModalFooter>
  </CModal>
</template>
<script setup>
import axios from 'axios';
import Swal from 'sweetalert2';
import { onMounted, ref, watch } from 'vue';
import router from '../router';

let posts = ref([])
const comments = ref([])
// Pagination Variable
const visibleVerticallyCenteredDemo = ref(false)
const totalItems = ref(0)
const itemsPerPage = ref(8)
const totalPages = ref(1)
const currentPage = ref(1)
const postSearch = ref('')
// // // // // //
const onClickHandler = (page) => {
    fetchPosts(page)
}

const fetchPosts = async (page) => {
    try {
        const res = await axios.get(`/api/admin/posts?perPage=${itemsPerPage.value}&page=${page}&search=${postSearch.value}`,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
        if(res.status == 200)
        {
            console.log(res);
            posts.value = res.data.data
            totalItems.value = res.data.meta.total
            totalPages.value = res.data.meta.last_page
        }
    } catch (error) {
        console.log(error);
    }
}
watch(itemsPerPage, () => {
    fetchPosts(1)
})
watch(postSearch, () => {
    fetchPosts(1)
})
onMounted( () => {
    fetchPosts()
})

const deletePost = async (postId) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.get(`/api/admin/post/${postId}/delete`, {
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if(res.status == 200)
                {
                    Swal.fire({
                        title: "Deleted!",
                        text: res.data,
                        icon: "success"
                    });
                    const idx = posts.value.findIndex( post => post.id === postId)
                    if(idx != -1)
                    {
                        posts.value.splice(idx, 1)
                    }
                }
            } catch (error) {
                
            }
        }
    });
}

const loadComments = async (postId) => {
    const res = await axios.get(`/api/admin/comments/${postId}`,{
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    });
    if(res.status == 200)
    {
        comments.value = res.data
    }
}

const deleteComment = async (commentId) => {
    console.log(commentId);
    const res = await axios.get(`/api/admin/comments/${commentId}/delete`,{
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}
</script>
<style scoped>
.post-images{
    width: 200px;
    height: 200px;
    object-fit: cover;
}
</style>
<style>
    @import '../styles/pagination.css';
</style>