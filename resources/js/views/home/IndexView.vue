<template>
    <div class="h-full carousel carousel-vertical w-full bg-[#E7E6D4]">
        <div class="carousel-item h-full">
            <video class="h-full w-full object-cover" autoplay loop muted>
                <source src="../../../videos/vid-1.mp4" type="video/mp4" media="(min-width: 768px)" />
                Your browser does not support the video tag.
                <source src="../../../videos/vid-mobile.mp4" type="video/mp4" media="(max-width: 767px)" />
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="carousel-item h-full pl-8 pt-5 flex flex-col">
            <u class="text-4xl text-[#5F3F2F] font-spectral"
                >The Baile Apartment</u
            >
            <p class="text-xl pl-5 pt-5 text-[#5F3F2F] font-sans">
                “One Step Away From Everything”
            </p>
            <div
                class="text-sm pl-5 text-[#5F3F2F] flex font-sans h-full"
            >
                <div
                    class="flex flex-col h-auto w-auto"
                >
                    The Baile is strategically located in Menteng, a premium and
                    strategic area at the heart of the city. Now you can reach
                    every desired destination in just a step away.
                    <div class="flex flex-col flex-grow mt-5">
                        <img
                            src="../../../images/baile-maps.png"
                            alt="BAILE MAPS"
                            class="w-full h-full"
                        />
                    </div>
                    <div
                        class="flex justify-center items-end flex-grow w-full h-auto"
                    >
                        <a
                            class="w-56 h-12 bg-[#E28A39] p-3 rounded-t-3xl flex justify-between items-center cursor-pointer"
                            href="https://maps.app.goo.gl/hY3fBpur9H4qDWjZ8" target="_blank"
                        >
                            <p class="font-sans text-white pl-2">
                                VIEW ON GOOGLE MAPS
                            </p>
                            <i class="maps-ic pr-2"></i>
                        </a>
                    </div>
                </div>
                <div class="max-w-[25vw] h-full hidden md:block">
                    <div
                        class="bg-[url('/public/images/home-bg.svg')] bg-no-repeat bg-cover ml-5 pt-5 pb-5 h-full rounded-lg"
                    >
                        <div class="ml-10 p-3">
                            <p
                                class="font-spectral text-4xl flex justify-center text-center text-white"
                            >
                                The Perfect Location
                            </p>
                            <div class="font-sans text-base mt-5">
                                <ol class="list-disc">
                                    <li>Walking Distance to RSCM & FK UI</li>
                                    <li>
                                        0 Min Drive from Bundaran HI, Plaza
                                        Indonesia and Grand Indonesia Shopping
                                        Town
                                    </li>
                                    <li>5 Mins to Cikini Train Station</li>
                                    <li>5 Mins to Megaria Cinema</li>
                                    <li>
                                        10 Mins to Jakarta’s Central Business
                                        District (Sudirman, Rasuna Said, SCBD)
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col">
            <div class="bg-[rgb(191,142,68)]">
                <div class="p-6 flex justify-end mr-5">
                    <a
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                        href="/facilities"
                    >
                        <p class="pr-2">Facilities</p>
                        <i class="right-arrow-ic"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="carousel-item h-80">
            <Footer />
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import store from "../../store";
import Footer from "../../components/Footer.vue";

// const fetchData = async () => {
//     await store.dispatch("postData", ["public/room/view", {}]).then().catch();
// };

onMounted(() => {
    console.log("nganu", import.meta.env);
    console.log("homeeepost");
    // fetchData();
});

const backgroundSvg = {
    backgroundImage: `url('data:image/svg+xml;utf8,<svg width="310" height="547" viewBox="0 0 310 547" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 27C0 18.7157 6.71573 12 15 12H310V547H15C6.71573 547 0 540.284 0 532V27Z" fill="#5F3F2F"/>
<path d="M15 15C15 6.71572 21.7157 0 30 0H310V535H30C21.7157 535 15 528.284 15 520V15Z" fill="#BF9B44"/>
</svg>
')`,
};

</script>

<style scoped>
.video-container {
    max-width: 800px;
    /* margin: 0 auto; */
    /* padding: 20px; */
}
.responsive-video {
    width: 100vw;
    height: 100vh;
    object-fit: cover;
}
.maps-ic {
    content: url("../../../icons/maps-ic.svg");
}
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
</style>
