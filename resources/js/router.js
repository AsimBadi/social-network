import { createRouter, createWebHistory  } from 'vue-router'

import DefaultLayout from './layout/DefaultLayout.vue'
import { useAuthStore } from './store/auth'
import { storeToRefs } from 'pinia'
import { ref, watch } from 'vue'

const routes = [
    {
        path: '/admin/login',
        name: 'login',
        component: () => import('./views/Login.vue'),
        meta: { guest: true}
    },
    {
        path: '/admin',
        component: DefaultLayout,
        meta: { auth: true },
        children: [
          {
            path: 'dashboard',
            name: 'Dashboard',
            component: () => import('./views/Dashboard.vue')
          },
          {
            path: 'user-management',
            name: 'UserManagement',
            component: () => import('./views/UserManagement.vue'),
          },
          {
            path: 'user-management/:id/edit',
            name: 'EditUser',
            component: () => import('./views/EditUser.vue')
          },
          {
            path: 'user-management/:id/view',
            name: 'ViewUser',
            component: () => import('./views/ViewUser.vue')
          },
          {
            path: 'post-management',
            name: 'PostManagement',
            component: () => import('./views/PostManagement.vue')
          },
          {
            path: 'post-management/:id/edit',
            name: 'EditPost',
            component: () => import('./views/EditPost.vue')
          },
          {
            path: 'post-management/:id/view',
            name: 'ViewPost',
            component: () => import('./views/ViewPost.vue')
          },
        ]
      },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: () => import('./views/Page404.vue'),
    }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})

router.beforeEach(async (to, from) => {
    const auth = useAuthStore()
    const { user } = storeToRefs(auth)

    if (localStorage.getItem('token') && !user.value) {
      await auth.getUser()
    }
  
    if (!localStorage.getItem('token') && to.meta.auth) {
      return { name: 'login' }
    }
  
    if (localStorage.getItem('token') && to.meta.guest) {
      return { name: 'Dashboard' }
    }
})
export default router
