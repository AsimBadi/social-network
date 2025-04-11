<template>
<form @submit.prevent="editPost">
    <div class="row">
        <div class="col-md-12">
            <label>Caption</label>
            <input type="text" class="form-control" v-model="post.caption">
        </div>
        <div class="col-md-2 mt-3" v-for="(image) in post.images" :key="image.id">
            <div class="card bg-dark" style="width: 12rem;">
                <img :src="image.image" class="card-img-top delete-img">
                <div class="card-body">
                    <div class="form-check form-check-danger">
                        <label class="form-check-label text-light">
                        <input type="checkbox" class="form-check-input" name="remove_image" :value="image.id" v-model="imageIds">Remove Picture<i class="input-helper"></i><i class="input-helper"></i></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary">Save</button>
        <button class="btn btn-light ms-2" @click="router.push({ name: 'PostManagement' })" type="button">Back</button>
    </div>
</form>
</template>
<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import router from '../router';
import Swal from 'sweetalert2';
const route = useRoute()
const postId = route.params.id
let post = ref({
    caption:'',
    likes:0,
    images:[],
})
let imageIds = ref([])

const fetchPost = async () => {
    const res = await axios.get(`/api/admin/post/${postId}/edit`, {
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
    if(res.status == 200)
    {
        post.value = {
            caption:  res.data.data.caption,
            likes:  res.data.data.likes,
            images:  res.data.data.image,
        }
        
    }
}
onMounted(() => {
    fetchPost()
})

const editPost = async () => {
    const res = await axios.post(`/api/admin/post/${postId}/update`,{        
        caption: post.value.caption,
        image_ids: imageIds.value
    },{
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
    if(res.status == 200)
    {
        imageIds.value.forEach(id => {
            const idx = post.value.images.findIndex(image => image.id == id)
            if(idx != -1)
            {
                post.value.images.splice(idx, 1)
            }
        })
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: res.data,
            showConfirmButton: false,
            timer: 3000,
        })
    }
}
</script>
<style scoped>
.delete-img{
    width: 100%;
    height: 150px;
    object-fit: cover;
}
</style>