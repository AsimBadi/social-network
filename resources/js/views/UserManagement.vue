<template>
        <table class="table table-bordered table-striped" id="usersTable">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Profile Picture</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Privacy</td>
                    <td>Gender</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{ user.id }}</td>
                    <td><img :src="user.profile_picture" width="50px" height="50px" class="rounded-circle" alt="Image Not Found"></td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.privacy }}</td>
                    <td>{{ user.gender }}</td>
                    <td>
                        <CBadge color="warning" v-if="user.is_suspended">Suspended</CBadge>
                        <CBadge color="danger" v-else-if="user.is_banned">Banned</CBadge>
                        <CBadge color="success" v-else>Active</CBadge>
                    </td>
                    <td>
                        <CDropdown>
                            <CDropdownToggle color="primary">Actions</CDropdownToggle>
                                <CDropdownMenu>
                                    <CDropdownItem @click="router.push({ name: 'EditUser', params: { id: user.id }})">Edit</CDropdownItem>
                                    <CDropdownItem href="#" @click="router.push({name: 'ViewUser',params: {id: user.id }})">View</CDropdownItem>
                                    <CDropdownItem href="#" @click="deleteUser(user.id, index)">Delete</CDropdownItem>
                                    <CDropdownItem href="#" @click="() => { visibleVerticallyCenteredDemo = true, suspendingUserId = user.id }" >Suspend</CDropdownItem>
                                    <CDropdownItem href="#" @click="banUser(user.id)">Ban</CDropdownItem>
                            </CDropdownMenu>
                        </CDropdown>
                    </td>
                    <!-- <td><button class="btn btn-warning">View</button></td>
                    <td><button class="btn btn-primary">Edit</button></td>
                    <td><button class="btn btn-danger">Delete</button></td> -->
                </tr>
            </tbody>
        </table>
    <CModal alignment="center" :visible="visibleVerticallyCenteredDemo" @close="() => { visibleVerticallyCenteredDemo = false }" aria-labelledby="VerticallyCenteredExample">
    <CModalHeader>
      <CModalTitle id="VerticallyCenteredExample">Suspend User</CModalTitle>
    </CModalHeader>
    <CModalBody>
        <div class="mb-3">
            <label>From</label>
            <input type="date" class="form-control" v-model="suspendUserDates.from">
            <span class="text-danger" v-if="errors.from">{{ errors.from[0] }}</span>
        </div>
        <div class="mb-3">
            <label>To</label>
            <input type="date" class="form-control" v-model="suspendUserDates.to">
            <span class="text-danger" v-if="errors.to">{{ errors.to[0] }}</span>
        </div>
    </CModalBody>
    <CModalFooter>
      <CButton color="secondary" @click="() => { visibleVerticallyCenteredDemo = false }">
        Close
      </CButton>
      <CButton color="primary" @click="() => { suspendUser(suspendingUserId) }">Save changes</CButton>
    </CModalFooter>
  </CModal>
</template>
<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import router from '../router'
import Swal from 'sweetalert2'

const visibleVerticallyCenteredDemo = ref(false)
const suspendUserDates = ref({
    from:null,
    to:null
})
const suspendingUserId = ref(0)
let users = ref([])
const errors = ref({})
const headers = [
    { text: "Id", name: 'id'},
    { text: "Username", name: 'username'},
    { text: "Email", name: 'email'},
    { text: "Privacy", name: 'privacy'},
    { text: "Gender", name: 'gender'},
]

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

const deleteUser = async (userId,index) => {
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
                const res = await axios.get(`/api/admin/user/${userId}/delete`,{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if(res.status == 200)
                {
                    users.value.splice(index, 1)
                    Swal.fire({
                        title: "Deleted!",
                        text: res.data,
                        icon: "success"
                    });
                }
            } catch (error) {
                console.log(error)
            }
        }
    });
}
const suspendUser = async (userId) => {
    console.log(userId);
    try {
        const res = await axios.post(`/api/admin/suspend/${userId}/user`,{
            user_id: userId,
            from: suspendUserDates.value.from,
            to: suspendUserDates.value.to
        },{
            headers:{
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
        if(res.status == 200)
        {
            suspendUserDates.value = {}
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: res.data,
                showConfirmButton: false,
                timer: 3000,
            })
        }
    } catch (error) {
        errors.value = error.response.data.errors
    }
}

const banUser = async (userId) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't ban this account!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Ban it!"
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.get(`/api/admin/ban/${userId}/user`,{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if(res.status == 200)
                {
                    Swal.fire({
                        title: "Banned!",
                        text: res.data,
                        icon: "success"
                    });
                }
            } catch (error) {
                
            }
        }
    });
}
</script>