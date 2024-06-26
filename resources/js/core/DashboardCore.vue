<template>
    <div id="preloader">
        <div class="waviy">
            <span style="--i: 1">L</span>
            <span style="--i: 2">o</span>
            <span style="--i: 3">a</span>
            <span style="--i: 4">d</span>
            <span style="--i: 5">i</span>
            <span style="--i: 6">n</span>
            <span style="--i: 7">g</span>
            <span style="--i: 8">.</span>
            <span style="--i: 9">.</span>
            <span style="--i: 10">.</span>
        </div>
    </div>

    <div id="main-wrapper">
        <NavHeader />
        <Header />
        <Sidebar :user="user" />
        <div class="content-body">
            <div class="container-fluid">
                <router-view></router-view>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { NavHeader, Header, Sidebar, Footer } from "../components/dashboard";
import { onMounted, ref } from "vue";
import { useStore } from "vuex";
import jsCookie from "js-cookie"

const $store = useStore();
const user = ref({});

onMounted(() => {
    checkAuthenticated();
});

const checkAuthenticated = async () => {
    try {
        let response = await $store.dispatch("postData", ["auth/check", {}]);
        let userSelected = {
            name: response.data.name,
            email: response.data.email,
        };

        user.value = userSelected;
        $store.state.user = userSelected;
    } catch (error) {
        jsCookie.remove('baile')
        window.location.replace("/");
    }
};
</script>
