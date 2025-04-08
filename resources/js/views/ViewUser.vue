<template>
    <form @submit.prevent="editUser(user)" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" placeholder="FirstName" v-model="user.firstName" disabled>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" placeholder="LastName" v-model="user.lastName" disabled>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" placeholder="Username" v-model="user.username" disabled>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Email" v-model="user.email" disabled>
            </div>
            <div class="mb-3 col-md-6">
                <label>Gender</label><br>
                <select class="form-select" v-model="user.gender" disabled>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Phone</label>
                <input type="number" class="form-control" placeholder="Phone" v-model="user.phone" disabled>
            </div>
            <div class="mb-3 col-md-6">
                <label>Verified</label>
                <select class="form-select" v-model="user.verified" disabled>
                    <option value="1">Verified</option>
                    <option value="2">Not Verified</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label>Bio</label>
                <textarea class="form-control" placeholder="Bio" v-model="user.bio" disabled></textarea>
            </div>
            <div class="mb-3 col-md-6">
                <label>Privacy</label>
                <select class="form-select" v-model="user.privacy" disabled>
                    <option value="1">Public</option>
                    <option value="2">Private</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <img :src="user.profilePicture" alt="Image Not Found" width="100px" height="100px">&nbsp;&nbsp;&nbsp;
            </div>
            <div class="mb-3 col-md-12">
                <button class="btn btn-primary" @click="router.push({name: 'UserManagement'})">Back</button>
            </div>
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import router from '../router'

const route = useRoute()
const userId = route.params.id

let user = ref({
    firstName:'',
    lastName:'',
    username:'',
    email:'',
    password:'',
    gender:'',
    phone:'',
    verified:'',
    bio:'',
    privacy:'',
    profilePicture:null,
    remove_dp:0,
    profilePictureFile:'',
})
onMounted( async () => {
    try {
        const res = await axios.get(`/api/admin/user/${userId}/edit`,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
        if(res.status == 200)
        {
            console.log(res);
            
            user.value = {
                firstName: res.data.user.first_name,
                lastName: res.data.user.last_name,
                username: res.data.user.username,
                email: res.data.user.email,
                gender: res.data.user.gender,
                phone: res.data.user.phone_no,
                verified: res.data.user.verified,
                bio: res.data.user.bio,
                privacy: res.data.user.privacy,
                profilePicture: res.data.user.image_url
            }
        }
    } catch (error) {
        console.log(error)
    }
})
</script>