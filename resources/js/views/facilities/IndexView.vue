<template>
    <div class="h-full carousel carousel-vertical w-full">
        <div
            class="carousel-item flex h-full relative bg-no-repeat bg-cover"
            style="
                background-image: url('https://raw.githubusercontent.com/dzikrifazahk/image-thebaile/main/img16.webp');
            "
        >
            <div class="absolute inset-0 bg-gradient-to-br p-10">
                <div class="h-full relative">
                    <h1 class="font-spectral font-thin text-4xl text-white">
                        THE BAILE PUBLIC FACILITIES
                    </h1>
                    <div class="absolute left-5 bottom-0">
                        <div
                            class="custom-width hover:bg-gray-200 lg:w-1/2 transition duration-300 ease-in-out cursor-pointer"
                            @click="setActiveDescription(-1)"
                        >
                            <h1 class="font-sans text-2xl text-white">
                                THE BAILE PUBLIC FACILITIES
                            </h1>
                            <p
                                class="text-white font-thin p-2 description"
                                v-show="activeDescription === -1"
                            >
                                The Baile Apartment provides a modern public
                                kitchen complete with the latest cooking
                                equipment. Here, you can enjoy a home-like
                                cooking experience, while socializing with
                                fellow residents.
                            </p>
                        </div>
                        <div
                            class="custom-width hover:bg-gray-200 lg:w-1/2 transition duration-300 ease-in-out cursor-pointer"
                            v-for="(facility, index) in facilities"
                            :key="index"
                            @click="setActiveDescription(index)"
                        >
                            <h1 class="font-sans text-2xl text-white">
                                {{ facility.title }}
                            </h1>
                            <p
                                class="text-white font-thin p-2 description"
                                v-show="activeDescription === index"
                            >
                                {{ facility.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- public kitchen -->
        <div
            class="carousel-item h-full gap-2"
            v-if="facilities.length > 0"
            v-for="(facility, index) in facilities"
            :key="index"
        >
            <div class="flex flex-col lg:flex-row w-full" v-if="index % 2 == 0">
                <div class="w-full lg:w-1/2 h-1/2 lg:h-auto">
                    <img
                        :src="facility.thumbnail"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-full lg:w-1/2 flex lg:flex-col">
                    <div class="w-full lg:p-5 p-2">
                        <p
                            class="font-spectral text-xl lg:text-2xl text-primaryColor pt-5"
                        >
                            {{ facility.title }}
                        </p>
                        <span class="text-primaryColor text-xs lg:text-base">
                            {{ facility.description }}
                        </span>
                    </div>
                    <div class="lg:w-full w-1/2 flex">
                        <div class="text-[#5b3a29] font-sans lg:p-10 p-2">
                            <h2 class="text-base lg:text-lg font-bold mb-4">
                                FEATURES
                            </h2>
                            <div class="grid lg:grid-cols-2 gap-4 grid-cols-1">
                                <div
                                    class="flex items-center space-x-2 text-sm lg:text-base"
                                    v-for="(
                                        feature, indexFeature
                                    ) in facility.features"
                                    :key="indexFeature"
                                >
                                    <i class="kitchen1-ic mr-2"></i>
                                    <span>{{ feature }}</span>
                                </div>
                            </div>
                            <div class="pt-5">
                                <div
                                    class="flex border border-primaryColor w-40 justify-center rounded-lg"
                                >
                                    <router-link
                                        to="/gallery"
                                        class="text-primaryColor font-sans text-md p-2 rounded-md pr-5"
                                        >VIEW GALLERY</router-link
                                    >
                                    <i class="right-arrow-ic-brown"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full" v-else>
                <div class="w-full h-1/2">
                    <img
                        :src="facility.thumbnail"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-full h-full flex">
                    <div class="w-full lg:p-5 p-2">
                        <p
                            class="font-spectral text-xl lg:text-2xl text-primaryColor pt-5"
                        >
                            {{ facility.title }}
                        </p>
                        <span class="text-primaryColor text-xs lg:text-base">
                            {{ facility.description }}
                        </span>
                    </div>
                    <div class="lg:w-full w-1/2 flex">
                        <div class="text-[#5b3a29] font-sans lg:p-10 p-2">
                            <h2 class="text-base lg:text-lg font-bold mb-4">
                                FEATURES
                            </h2>
                            <div class="grid lg:grid-cols-2 gap-4 grid-cols-1">
                                <div
                                    class="flex items-center space-x-2 text-sm lg:text-base"
                                    v-for="(
                                        feature, indexFeature
                                    ) in facility.features"
                                    :key="indexFeature"
                                >
                                    <i class="kitchen1-ic mr-2"></i>
                                    <span>{{ feature }}</span>
                                </div>
                            </div>
                            <div class="pt-5">
                                <div
                                    class="flex border border-primaryColor w-40 justify-center rounded-lg"
                                >
                                    <router-link
                                        to="/gallery"
                                        class="text-primaryColor font-sans text-md p-2 rounded-md pr-5"
                                        >VIEW GALLERY</router-link
                                    >
                                    <i class="right-arrow-ic-brown"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end public kitchen -->
        <div class="carousel-item flex flex-col pt-5">
            <div class="bg-[#BF8E44] h-full">
                <div class="p-6 flex justify-end mr-5">
                    <a
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                        href="/room-type"
                    >
                        <p class="pr-2">Room Type</p>
                        <i class="right-arrow-ic"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col">
            <Footer />
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Footer from "../../components/Footer.vue";
import store from "../../store";
import { useToast } from "vue-toast-notification";

onMounted(() => {
    getFacilities();
});

const activeDescription = ref(-1); // Set deskripsi pertama sebagai default yang aktif
const toast = useToast();
const facilities = ref([]);

// Method untuk mengubah deskripsi yang aktif saat dihover
const setActiveDescription = (index) => {
    activeDescription.value = index;
};

const getFacilities = async () => {
    try {
        let response = await store.dispatch("postData", [
            "public/facility/view",
            {},
        ]);

        if (response.code == 200) {
            facilities.value = response.data;
        } else {
            toast.error("Something Wrong");
        }
    } catch (error) {
        toast.error("Something Wrong");
    }
};
</script>

<style scoped>
.bg-gradient-to-br {
    background: linear-gradient(to bottom right, rgba(0, 0, 0, 1), transparent);
}

.hover\:bg-gray-200:hover {
    background-color: #303135;
    /* border-radius: 15px; */
    padding: 15px;
}
.custom-width {
    margin: 10px;
    border-radius: 15px;
}

.transition {
    transition-property: background-color;
}

.duration-300 {
    transition-duration: 500ms;
}

.ease-in-out {
    transition-timing-function: ease-in-out;
}
.freezer-ic::before {
    content: url("../../../icons/freezer.svg");
}
.food-scope-ic::before {
    content: url("../../../icons/food-scope.svg");
}
.kitchen1-ic::before {
    content: url("../../../icons/kitchen1.svg");
}
.cooking-equipment-ic::before {
    content: url("../../../icons/cooking-equipment.svg");
}
.right-arrow-ic-brown {
    content: url("../../../icons/right-arrow-ic-brown.svg");
}
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
</style>
