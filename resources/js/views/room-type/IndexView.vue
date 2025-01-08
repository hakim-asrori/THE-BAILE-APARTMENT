<template>
    <div class="h-full w-full">
        <div
            class="flex h-full relative bg-no-repeat bg-cover"
            style="
                background-image: url('https://github.com/dzikrifazahk/image-thebaile/blob/main/img3.jpg?raw=true');
            "
        >
            <div class="absolute inset-0 bg-gradient-to-tl p-10">
                <div class="h-full relative">
                    <div class="absolute lg:w-1/2 right-5 bottom-0">
                        <div class="mb-10">
                            <h1
                                class="font-spectral text-2xl text-white lg:text-right sm:text-center pb-10"
                            >
                                THE BAILE ROOM TYPE
                            </h1>
                            <h1
                                class="text-white font-thin p-2 lg:text-right sm:text-center"
                            >
                                The Baile provides a variety of room types
                                designed to meet your needs and preferences.
                                Find your preferred room type at The Baile
                                Apartment
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- room type 1 -->
        <div
            class="flex gap-2 flex-col"
            v-for="(data, index) in roomTypeData"
            :key="index"
        >
            <div class="flex flex-col lg:flex-row w-full">
                <div
                    class="flex flex-wrap w-full lg:w-1/2"
                    v-if="index % 2 === 0 || (index % 2 === 1 && isMobile)"
                >
                    <div
                        class="w-1/2 h-1/2"
                        v-for="(dataImage, imagesIndex) in data.images"
                        :key="imagesIndex"
                    >
                        <img
                            :src="dataImage.image"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                </div>
                <div
                    class="w-full lg:w-1/2 h-full lg:p-7 p-2 flex flex-col lg:gap-10 gap-3"
                >
                    <div>
                        <p
                            class="lg:text-3xl text-xl font-spectral text-primaryColor"
                        >
                            {{ data?.title ?? "None" }}
                        </p>
                        <p
                            class="font-sans text-primaryColor lg:pt-5 pt-2 lg:text-base text-xs"
                        >
                            {{ data?.description ?? "None" }}
                        </p>
                    </div>
                    <div class="text-[#5b3a29] font-sans">
                        <div
                            class="mb-4"
                            v-for="(feature, indexFeature) in data.features"
                            :key="indexFeature"
                        >
                            <h2
                                class="font-bold lg:text-lg text-sm text-brown-800 mb-2"
                            >
                                {{ feature.category }}
                            </h2>
                            <ul
                                class="list-disc list-inside text-brown-600 lg:text-base text-sm"
                            >
                                <li
                                    v-for="(item, indexItem) in feature.items"
                                    :key="indexItem"
                                >
                                    {{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-wrap w-full lg:w-1/2"
                    v-if="index % 2 === 1 && !isMobile"
                >
                    <div
                        class="w-1/2 h-1/2"
                        v-for="(dataImage, imagesIndex) in data.images"
                        :key="imagesIndex"
                    >
                        <img
                            :src="dataImage.image"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
        <!-- end room type 1 -->

        <div class="flex flex-col w-full">
            <div class="bg-[#BF8E44] h-full">
                <div class="p-6 flex justify-end mr-5">
                    <a
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                        href="/gallery"
                    >
                        <p class="pr-2">Gallery</p>
                        <i class="right-arrow-ic"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <Footer />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import Footer from "../../components/Footer.vue";
import store from "../../store";
import { useToast } from "vue-toast-notification";

const isMobile = ref(false);

const checkResolution = () => {
    isMobile.value = window.innerWidth <= 900; // Anggap lebar mobile adalah 768px atau kurang
    console.log(
        `Window width: ${window.innerWidth}, isMobile: ${isMobile.value}`
    );
};

onMounted(() => {
    checkResolution();
    fetchData();
    window.addEventListener("resize", checkResolution);
});

onUnmounted(() => {
    window.removeEventListener("resize", checkResolution);
});

const toast = useToast();
const roomTypeData = ref([]);
const fetchData = async () => {
    try {
        const response = await store.dispatch("postData", [
            "public/room/view",
            {},
        ]);

        if (response.code == 200) {
            roomTypeData.value = response.data;
        } else {
            toast.error("Something Wrong");
        }
    } catch (error) {
        toast.error("Something Wrong");
    }
};
</script>

<style scoped>
.bg-gradient-to-tl {
    background: linear-gradient(to top left, rgba(0, 0, 0, 1), transparent);
}
.description {
    display: none;
}

.custom-width:hover .description {
    display: block;
}

.hover\:bg-gray-200:hover {
    background-color: #303135;
}

.transition {
    transition-property: background-color;
}
.duration-300 {
    transition-duration: 300ms;
}
.ease-in-out {
    transition-timing-function: ease-in-out;
}

.custom-width {
    width: auto;
}
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
</style>
