<template>
    <div class="dlabnav">
        <div class="dlabnav-scroll">
            <ul class="metismenu" id="menu">
                <li class="dropdown header-profile">
                    <a
                        class="nav-link"
                        href="javascript:void(0);"
                        role="button"
                        data-bs-toggle="dropdown"
                    >
                        <img
                            :src="`http://ui-avatars.com/api/?background=random&size=25&rounded=true&length=2&name=${user.name}`"
                            width="20"
                            alt=""
                        />
                        <div class="header-info ms-3">
                            <span class="font-w600"
                                ><b>{{ user.name }}</b></span
                            >
                            <small class="text-end font-w400">{{
                                user.email
                            }}</small>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a
                            href="app-profile.html"
                            class="dropdown-item ai-icon"
                        >
                            <svg
                                id="icon-user1"
                                xmlns="http://www.w3.org/2000/svg"
                                class="text-primary"
                                width="18"
                                height="18"
                                viewbox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                ></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span class="ms-2">Profile </span>
                        </a>
                        <a
                            href="#"
                            class="dropdown-item ai-icon"
                            @click="handleLogout"
                        >
                            <svg
                                id="icon-logout"
                                xmlns="http://www.w3.org/2000/svg"
                                class="text-danger"
                                width="18"
                                height="18"
                                viewbox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                                ></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span class="ms-2">Logout </span>
                        </a>
                    </div>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'dashboard.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Dashboard')"
                    >
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'home.facility.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Facilities')"
                    >
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Facilities</span>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'home.room.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Room Type')"
                    >
                        <i class="flaticon-046-home"></i>
                        <span class="nav-text">Room Type</span>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'home.gallery.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Gallery')"
                    >
                        <i class="flaticon-381-picture"></i>
                        <span class="nav-text">Gallery</span>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'home.contact.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Contact')"
                    >
                        <i class="flaticon-381-phone-call"></i>
                        <span class="nav-text">Contact</span>
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'home.enquire.index' }"
                        class="ai-icon"
                        aria-expanded="false"
                        @click="changeTitleBar('Enquire')"
                    >
                        <i class="flaticon-381-notebook"></i>
                        <span class="nav-text">Enquire</span>
                    </router-link>
                </li>
            </ul>
            <div class="copyright">
                <p>&copy; 2022 All Rights Reserved</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import jsCookie from "js-cookie";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const handleLogout = () => {
    jsCookie.remove("baile");
    window.location.replace("/auth/login");
};

const changeTitleBar = (text) => {
    $(".dashboard_bar").text(text);
    $(document).on("click", "#menu .ai-icon", function () {
        $("#menu li").removeClass("mm-active");

        $(this).parents("li").addClass("mm-active");
    });
};
</script>

<style></style>
