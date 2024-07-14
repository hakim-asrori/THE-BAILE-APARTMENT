<template>
    <div class="relative">
        <button
            @click="toggleSidebar"
            class="fixed top-5 left-5 z-50 p-2 text-white rounded-md lg:hidden bg-brown-700"
        >
            ☰
        </button>
        <div
            :class="[
                'fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden',
                { hidden: !isSidebarOpen },
            ]"
            @click="toggleSidebar"
        ></div>
        <div
            :class="[
                'bg-brown-700 w-[355px] h-screen p-5 text-white font-sans font-thin fixed lg:relative z-50 transition-transform duration-300',
                {
                    '-translate-x-full': !isSidebarOpen,
                    'lg:translate-x-0': true,
                },
            ]"
        >
            <div
                id="collapse-sidebar"
                class="lg:hidden absolute top-5 right-5 cursor-pointer"
                @click="toggleSidebar"
            >
                <svg
                    fill="#ffffff"
                    height="30px"
                    width="30px"
                    version="1.1"
                    id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 460.775 460.775"
                    xml:space="preserve"
                >
                    <path
                        d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
	c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
	c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
	c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
	l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
	c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"
                    />
                </svg>
            </div>
            <div class="flex flex-col items-center mb-10 logo">
                <div class="flex justify-center">
                    <img
                        src="../../images/logo.png"
                        alt="LOGO"
                        class="w-32 h-auto"
                    />
                </div>
                <p class="mt-4 text-sm">Welcome To The Baile Apartment</p>
            </div>
            <nav>
                <ul class="pr-5 pl-5 list-none">
                    <li class="my-5">
                        <router-link
                            to="/"
                            class="flex items-center p-2 text-xl rounded transition-colors duration-300 hover:bg-yellow-300 hover:text-white"
                            :class="{
                                'font-bold': $route.path === '/',
                                'bg-[#BF9B44]': $route.path === '/',
                            }"
                        >
                            <i class="mr-2 icon-home"></i> H O M E
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
                            <i class="mr-2 icon-facilities"></i> F A C I L I T I
                            E S
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
                            <i class="mr-2 icon-room-type"></i> R O O M T Y P E
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
                            <i class="mr-2 icon-gallery"></i> G A L L E R Y
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
                            <i class="mr-2 icon-contact"></i> C O N T A C T
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
                            <i class="mr-2 icon-enquire"></i> E N Q U I R E N O
                            W
                        </router-link>
                    </li>
                </ul>
            </nav>

            <div class="flex justify-center mt-24">
                <p class="font-sans text-sm font-normal">
                    &copy; Copyright The Baile 2024
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
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
