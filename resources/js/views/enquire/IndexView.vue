<template>
    <div class="h-full carousel carousel-vertical w-full">
        <div class="m-4">
            <div class="carousel-item flex flex-col p-5">
                <div class="grid grid-rows-3 grid-flow-col gap-4">
                    <div
                        class="col-span-2 font-spectral text-xl text-primaryColor"
                    >
                        BOOK YOUR VISIT
                    </div>
                    <div class="row-span-2 col-span-2 text-[#A2A2A2]">
                        Explore the Baile Apartment Experience Gallery. Please
                        Register Here For An Exclusive Viewing Tour At the Baile
                        Apartment Experience Gallery.
                    </div>
                    <div class="row-span-3 mr-5"><i class="atom-ic"></i></div>
                </div>
                <!-- <div className="pt-2 flex-col max-w-[30vw] border border-red-400"> -->
                <div className="flex-col w-full">
                    <div class="flex flex-wrap w-full">
                        <div class="flex flex-col m-2 w-[30vw]">
                            <label for="fullname" class="custom-label"
                                >FULL NAME</label
                            >
                            <input
                                type="text"
                                id="fullname"
                                class="custom-input"
                                placeholder="FULL NAME"
                            />
                        </div>
                        <div class="flex flex-col m-2 w-[30vw]">
                            <label for="email" class="custom-label"
                                >EMAIL</label
                            >
                            <input
                                type="email"
                                id="email"
                                class="custom-input"
                                placeholder="EMAIL"
                            />
                        </div>
                        <div class="flex flex-col m-2 w-[30vw]">
                            <label for="phone" class="custom-label"
                                >PHONE NUMBER</label
                            >
                            <input
                                type="tel"
                                id="phone"
                                class="custom-input"
                                placeholder="PHONE NUMBER"
                            />
                        </div>
                        <div class="flex flex-col m-2 w-[30vw]">
                            <label for="date" class="custom-label">DATE</label>
                            <input
                                type="datetime-local"
                                id="date"
                                class="custom-input"
                                placeholder="PICK A DATE"
                            />
                        </div>
                        <div class="flex flex-col m-2 w-[30vw]">
                            <label for="room" class="custom-label"
                                >ROOM TYPE</label
                            >
                            <select id="room" class="custom-input">
                                <option>PICK A ROOM TYPE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <div class="flex border border-primaryColor w-40 justify-center rounded-lg">
                        <button
                            class=" text-primaryColor font-sans text-md p-2 rounded-md pr-5"
                        >
                            S U B M I T
                        </button>
                        <i class="right-arrow-ic-brown"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col pt-5">
            <div class="bg-[#BF8E44] h-full">
                <div class="p-6 flex justify-end mr-5">
                    <a
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                        href="/home"
                    >
                        <p class="pr-2">Home</p>
                        <i class="right-arrow-ic"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="carousel-item flex flex-col">
            <Footer/>
        </div>
    </div>
</template>

<script setup>
import Footer from "../../components/Footer.vue";
</script>
<style scoped>
.atom-ic {
    content: url("../../../icons/atom-ic.svg");
}
.custom-input {
    border: 2px solid #8b5e34;
    border-radius: 15px;
    background-color: transparent;
    padding: 10px;
    width: 100%;
}
.custom-label {
    color: #8b5e34;
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

::-webkit-calendar-picker-indicator {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
}
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}
.right-arrow-ic-brown {
    content: url("../../../icons/right-arrow-ic-brown.svg");
}
</style>
