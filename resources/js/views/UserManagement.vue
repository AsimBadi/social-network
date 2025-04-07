<template>
    <div class="my-2 px-2">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Profile Picture</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Privacy</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{ user.id }}</td>
                    <td><img :src="user.image_url" width="100px" height="100px" alt="Image Not Found"></td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.privacy }}</td>
                    <td>
                        <CDropdown>
                            <CDropdownToggle color="primary">Actions</CDropdownToggle>
                                <CDropdownMenu>
                                    <CDropdownItem href="#">Edit</CDropdownItem>
                                    <CDropdownItem href="#">View</CDropdownItem>
                                    <CDropdownItem href="#">Delete</CDropdownItem>
                                    <CDropdownItem href="#">Suspend</CDropdownItem>
                                    <CDropdownItem href="#">Ban</CDropdownItem>
                            </CDropdownMenu>
                        </CDropdown>
                    </td>
                    <!-- <td><button class="btn btn-warning">View</button></td>
                    <td><button class="btn btn-primary">Edit</button></td>
                    <td><button class="btn btn-danger">Delete</button></td> -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

let users = ref([])
onMounted( async () => {
    try {
        const res = await axios.get('/api/admin/users', {
            headers:{
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
        if(res.status == 200)
        {
            users.value = res.data.data
            console.log(users);
            
        }
    } catch (error) {
        console.log(error);
    }
})
</script>