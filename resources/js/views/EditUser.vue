<template>
    <form @submit.prevent="editUser(user)" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" placeholder="FirstName" v-model="user.firstName">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" placeholder="LastName" v-model="user.lastName">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" placeholder="Username" v-model="user.username">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Email" v-model="user.email">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="New Password" v-model="user.password">
            </div>
            <div class="mb-3 col-md-6">
                <label>Gender</label><br>
                <select class="form-select" v-model="user.gender">
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Phone</label>
                <input type="number" class="form-control" placeholder="Phone" v-model="user.phone">
            </div>
            <div class="mb-3 col-md-6">
                <label>Verified</label>
                <select class="form-select" v-model="user.verified">
                    <option value="1">Verified</option>
                    <option value="2">Not Verified</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label>Bio</label>
                <textarea class="form-control" placeholder="Bio" v-model="user.bio"></textarea>
            </div>
            <div class="mb-3 col-md-6">
                <label>Privacy</label>
                <select class="form-select" v-model="user.privacy">
                    <option value="1">Public</option>
                    <option value="2">Private</option>
                </select>
            </div>
            <div class="mb-3 col-md-12">
                <label>Profile Picture</label>
                <input type="file" class="form-control" @change="onFileChange">
            </div>
            <div class="mb-3 col-md-6">
                <button class="btn btn-primary">Submit</button>
                <button class="btn btn-light ms-2" type="button" @click="router.push({ name: 'UserManagement' })">Back</button>
            </div>
            <div class="mb-3 col-md-6">
                <img :src="user.profilePicture" alt="Image Not Found" width="100px" height="100px">&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="form-check-input" value="1" v-model="user.remove_dp">
                <label class="text-danger">Remove Profile Picture</label>
            </div>
        </div>
    </form>
</template>
<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import Swal from 'sweetalert2';
import router from '../router';

const route = useRoute()
const userId = route.params.id
const onFileChange = (e) => {
    const file = e.target.files[0]
    if(file)
    {
        user.value.profilePictureFile = file
        user.value.profilePicture = URL.createObjectURL(file)
    }
    
}
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
    remove_dp:'',
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

const editUser = async (user) => {
    let formData = new FormData()
        formData.append('first_name', user.firstName)
        formData.append('last_name', user.lastName)
        formData.append('username', user.username)
        formData.append('email', user.email)
        formData.append('password', user.password)
        formData.append('gender', user.gender)
        formData.append('phone_no', user.phone ?? '')
        formData.append('verified', user.verified)
        formData.append('bio', user.bio ?? '')
        formData.append('privacy', user.privacy)
        formData.append('remove_dp', user.remove_dp ? '1' : '0')
        if (user.profilePictureFile) {
            formData.append('profile_picture', user.profilePictureFile)
        }

    const res = await axios.post(`/api/admin/user/${userId}/update`,
        // first_name: user.firstName,
        // last_name: user.lastName,
        // username: user.username,
        // email: user.email,
        // password: user.password,
        // gender: user.gender,
        // phone_no: user.phone,
        // verified: user.verified,
        // bio: user.bio,
        // privacy: user.privacy,
        // profile_picture: user.profilePicture,
        // remove_dp: user.remove_dp
        formData
    ,{
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
    if(res.status == 200)
    {
        console.log(res);
        
        Swal.fire({
            title: 'Success!',
            text: res.data,
            icon: 'success',
            confirmButtonText: 'OK'
        })
    }
}

</script>