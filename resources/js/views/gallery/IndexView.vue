<template>
    <div class="h-full carousel carousel-vertical w-full">
        <div class="carousel-item flex h-full">
            <div class="w-full flex flex-col h-full">
                <div class="w-auto h-full">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img1.jpg?raw=true"
                        alt="Image"
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-auto h-full">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img1.jpg?raw=true"
                        alt="Image"
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
            <div class="w-full h-full">
                <img
                    src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img10.jpg?raw=true"
                    alt=""
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
        <div class="carousel-item flex flex-col h-full">
            <div class="w-full bg-black h-1/2">
                <img
                    src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img11.jpg?raw=true"
                    alt=""
                    class="w-full h-full object-cover"
                />
            </div>
            <div class="flex h-1/2">
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img12.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img13.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col h-full">
            <div class="flex h-1/2">
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img14.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img15.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
            <div class="flex h-1/2">
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img3.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-1/2 h-full bg-primaryColor">
                    <img
                        src="https://github.com/dzikrifazahk/image-thebaile/blob/main/img4.jpg?raw=true"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col">
            <div class="bg-[#BF8E44] h-full">
                <div class="p-6 flex justify-end mr-5">
                    <div
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                    >
                        <p class="pr-2">Contact</p>
                        <i class="right-arrow-ic"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col">
            <Footer />
        </div>
    </div>
</template>

<script setup>
import Footer from "../../components/Footer.vue";
</script>

<style scoped>
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
</style>
