// stores/counter.js
import axios from 'axios'
import { defineStore } from 'pinia'
import router from '../router'

export const useAuthStore = defineStore('auth', {
  state: () => {
    return { 
        errors: {},
        user: null
     }
  },

  actions: {
    async login(formData)
    {
        try {
            const res = await axios.post('/api/admin/login',{
                email: formData.email,
                password: formData.password
            })
            if(res.status == 200)
            {
                this.errors = {}
                localStorage.setItem('token', res.data.token)
                this.user = res.data.user
                router.push({name: 'Dashboard'})
            }
        } catch (error) {
            if (error.status == 422) {
                this.errors = error.response.data.errors
            }
        }
    },

    async getUser()
    {
        try {
            const res = await axios.get('/api/admin/user',{
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
            if(res.status == 200)
            {
                this.user = res.data.user
            }
        } catch (error) {
            console.log(error)
        }
    },

    async logout()
    {
        try {
            if(localStorage.getItem('token'))
            {
                const res = await axios.get('/api/admin/logout',{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if(res.status == 200)
                {
                    localStorage.removeItem('token')
                    this.user = null
                    return router.push({ name: 'login' })
                }
            }
        } catch (error) {
            
        }
    }
  },
})
