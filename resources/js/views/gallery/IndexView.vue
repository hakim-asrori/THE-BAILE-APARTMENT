<template>
   <div class="h-full w-full overflow-y-auto">
        <div class="flex flex-wrap w-full h-full">
            <div
                class="lg:w-1/2 md:w-1/2 w-full h-1/2 bg-primaryColor"
                v-for="(image, index) in galleries"
                :key="index"
            >
                <img
                    :src="image.imagePath"
                    alt=""
                    class="w-full h-full object-cover"
                />
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
