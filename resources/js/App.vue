<template>
    <div>
        <Header></Header>
        <Sidebar></Sidebar>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid m-2">
                    <RouterView></RouterView>
                </div>
            </section>
        </div>
    </div>
    <!-- <Register></Register> -->
</template>
<script>
import { useRoute } from 'vue-router';
import Register from './components/auth/Register.vue';
import Header from './components/Header.vue';
import Sidebar from './components/Sidebar.vue';
import { computed } from 'vue';
export default{
    components:{
        Header,
        Sidebar,
        Register
    },
    setup() {
        const route = useRoute();
        const isAuthPage = () => {
            return route.path === '/admin/register'
        }
    }
}
</script>