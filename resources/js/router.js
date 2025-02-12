import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import Register from './components/auth/Register.vue';

const routes = [
    { 
        path: '/admin', 
        component: Dashboard 
    },
    {
        path: '/admin/register',
        component: Register,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
