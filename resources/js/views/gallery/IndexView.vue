<template>
    <div class="h-full w-full overflow-y-auto">
        <div class="flex flex-wrap w-full h-full">
            <a
                class="lg:w-1/2 md:w-1/2 w-full h-1/2 bg-primaryColor"
                v-if="galleries.length > 0"
                v-for="(image, index) in galleries"
                :key="index"
                :href="image.imagePath"
                target="_blank"
            >
                <img
                    :src="image.imagePath"
                    alt=""
                    class="w-full h-full object-cover"
                />
            </a>
            <div class="w-full p-10" v-else>
                <div role="alert" class="alert alert-warning w-full">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 shrink-0 stroke-current"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span>Gallery is empty</span>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="bg-[#BF8E44] h-full">
            <div class="p-6 flex justify-end mr-5">
                <a
                    class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                    href="/contact"
                >
                    <p class="pr-2">Contact</p>
                    <i class="right-arrow-ic"></i>
                </a>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import { onMounted, ref } from "vue";
import Footer from "../../components/Footer.vue";
import store from "../../store";
import { useToast } from "vue-toast-notification";

const toast = useToast();
const galleries = ref([]);

onMounted(() => {
    fetchImage();
});

const fetchImage = async () => {
    try {
        const response = await store.dispatch("postData", [
            "public/gallery/view",
            {},
        ]);

        galleries.value = response.data;
        console.log(galleries.value);
    } catch (error) {
        toast.error("Something Wrong");
    }
};
</script>

<style scoped>
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
</style>
