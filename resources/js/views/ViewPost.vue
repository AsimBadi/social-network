<template>
    <div class="row">
        <div class="col-md-12">
            <label>Caption</label>
            <input type="text" class="form-control" v-model="post.caption" disabled>
        </div>
        <div class="col-md-2 mt-3" v-for="(image) in post.images" :key="image.id">
            <div class="card bg-dark" style="width: 12rem;">
                <img :src="image.image" class="card-img-top delete-img">
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-light ms-2" @click="router.push({ name: 'PostManagement' })" type="button">Back</button>
    </div>
</template>
<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import router from '../router'

const route = useRoute()
const postId = route.params.id 
const post = ref({
    caption:'',
    likes:'',
    images:[]
})
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
</script>
<style scoped>
.delete-img{
    width: 100%;
    height: 150px;
    object-fit: cover;
}
</style>