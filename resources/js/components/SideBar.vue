<template>
    <div class="relative">
        <button
            @click="toggleSidebar"
            class="lg:hidden p-2 fixed top-5 left-5 z-50 bg-brown-700 rounded-md text-white"
        >
            ☰
        </button>
        <div
            :class="[
                'fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden',
                { hidden: !isSidebarOpen }
            ]"
            @click="toggleSidebar"
        ></div>
        <div
            :class="[
                'bg-brown-700 w-[355px] h-screen p-5 text-white font-sans font-thin fixed lg:relative z-50 transition-transform duration-300',
                { '-translate-x-full': !isSidebarOpen, 'lg:translate-x-0': true }
            ]"
        >
            <div class="flex flex-col logo mb-10 items-center">
                <div class="flex justify-center">
                    <img src="../../images/logo.png" alt="LOGO" class="w-32 h-auto" />
                </div>
                <p class="text-sm mt-4">Welcome To Baile Apartment</p>
            </div>
            <nav>
                <ul class="list-none pr-5 pl-5">
                    <li class="my-5">
                        <router-link
                            to="/"
                            class="flex items-center p-2 rounded transition-colors duration-300 hover:bg-yellow-300 hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/',
                                'bg-[#BF9B44]': $route.path === '/',
                            }"
                        >
                            <i class="icon-home mr-2"></i> H O M E
                        </router-link>
                    </li>
                    <li class="my-5">
                        <router-link
                            to="/facilities"
                            class="flex items-center text-xl p-2 rounded transition-colors duration-300 hover:bg-[#BF9B44] hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/facilities',
                                'bg-[#BF9B44]': $route.path === '/facilities',
                            }"
                        >
                            <i class="icon-facilities mr-2"></i> F A C I L I T I E S
                        </router-link>
                    </li>
                    <li class="my-5">
                        <router-link
                            to="/room-type"
                            class="flex items-center text-xl p-2 rounded transition-colors duration-300 hover:bg-[#BF9B44] hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/room-type',
                                'bg-[#BF9B44]': $route.path === '/room-type',
                            }"
                        >
                            <i class="icon-room-type mr-2"></i> R O O M  T Y P E
                        </router-link>
                    </li>
                    <li class="my-5">
                        <router-link
                            to="/gallery"
                            class="flex items-center text-xl p-2 rounded transition-colors duration-300 hover:bg-[#BF9B44] hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/gallery',
                                'bg-[#BF9B44]': $route.path === '/gallery',
                            }"
                        >
                            <i class="icon-gallery mr-2"></i> G A L L E R Y
                        </router-link>
                    </li>
                    <li class="my-5">
                        <router-link
                            to="/contact"
                            class="flex items-center text-xl p-2 rounded transition-colors duration-300 hover:bg-[#BF9B44] hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/contact',
                                'bg-[#BF9B44]': $route.path === '/contact',
                            }"
                        >
                            <i class="icon-contact mr-2"></i> C O N T A C T
                        </router-link>
                    </li>
                    <li class="my-5">
                        <router-link
                            to="/enquire"
                            class="flex items-center text-xl p-2 rounded transition-colors duration-300 hover:bg-[#BF9B44] hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/enquire',
                                'bg-[#BF9B44]': $route.path === '/enquire',
                            }"
                        >
                            <i class="icon-enquire mr-2"></i> E N Q U I R E N O W
                        </router-link>
                    </li>
                </ul>
            </nav>

            <div class="mt-24 flex justify-center">
                <p class="text-sm font-sans font-normal">
                    &copy; Copyright The Baile 2024
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const isSidebarOpen = ref(false)

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}
</script>

<style scoped>
.bg-brown-700 {
    background-color: #5d4037;
}

.icon-home::before {
    content: url("../../icons/home.svg");
}

.icon-facilities::before {
    content: url("../../icons/facilities.svg");
}

.icon-room-type::before {
    content: url("../../icons/room-type.svg");
}

.icon-gallery::before {
    content: url("../../icons/gallery.svg");
}

.icon-contact::before {
    content: url("../../icons/contact.svg");
}

.icon-enquire::before {
    content: url("../../icons/enquire.svg");
}

.font-bold {
    font-weight: bold;
}

.hover\:bg-yellow-300:hover {
    background-color: #bf9b44;
}

.hover\:text-black:hover {
    color: #000000;
}
</style>
