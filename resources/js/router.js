import { createRouter, createWebHistory  } from 'vue-router'

import DefaultLayout from './layout/DefaultLayout.vue'
import { useAuthStore } from './store/auth'
import { storeToRefs } from 'pinia'

const routes = [
    {
        path: '/admin/login',
        name: 'login',
        component: () => import('./views/Login.vue'),
        meta: { guest: true}
    },
    {
        path: '/admin',
        component: DefaultLayout, // wrapper layout
        meta: { auth: true },
        children: [
          {
            path: 'dashboard', // ✅ becomes /admin/dashboard
            name: 'Dashboard',
            component: () => import('./views/Dashboard.vue')
          },
          {
            path: 'user-management', // ✅ becomes /admin/user/management
            name: 'UserManagement',
            component: () => import('./views/Layout.vue')
          }
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
  
    // Try to get user if token exists but user is not yet set
    if (localStorage.getItem('token') && !user.value) {
      await auth.getUser() // Make sure this updates user in the store
    }
  
    // Redirect to login if the route needs auth but no user is logged in
    if (!user.value && to.meta.auth) {
      return { name: 'login' }
    }
  
    // Redirect to home if logged in and trying to access guest-only page
    if (user.value && to.meta.guest) {
      return { name: 'Dashboard' }
    }
})
export default router
