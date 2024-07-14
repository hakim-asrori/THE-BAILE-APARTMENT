<template>
    <div class="h-full carousel carousel-vertical w-full">
        <div class="flex flex-col sm:flex-row gap-3 m-4 pt-4">
            <!-- Bagian Kontak -->
            <div class="w-full sm:w-1/2">
                <p class="text-3xl font-spectral text-primaryColor">CONTACT</p>
                <p class="text-md font-sans text-[#A2A2A2] pt-3">
                    Jl. Kimia No.4 10, RT.10/RW.1, Pegangsaan, Kec. Menteng,
                    Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10320
                </p>
                <div class="flex w-full pt-5 gap-5">
                    <div class="flex flex-col">
                        <p class="font-spectral text-primaryColor">
                            PHONE &nbsp;
                        </p>
                        <p>(+62) 857-1810-1985</p>
                        <p>(+62) 813-8707-6706</p>
                        <p>(+62) 821-2927-4019</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-spectral text-primaryColor">
                            EMAIL &nbsp;
                        </p>
                        <p>thebaileapartment@gmail.com</p>
                    </div>
                </div>
                <div class="h-[60vh] w-full mt-5">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4983891824722!2d106.84216857508106!3d-6.197784360717344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f46a593413f7%3A0xf7f953fd12507cc0!2sApartemen%20The%20Baile!5e0!3m2!1sen!2sid!4v1719188828113!5m2!1sen!2sid"
                        class="w-full h-full border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
                <div class="mt-5">
                    <a
                        href="https://maps.app.goo.gl/hY3fBpur9H4qDWjZ8"
                        target="_blank"
                        class="flex border border-primaryColor w-auto justify-center rounded-lg"
                    >
                        <button
                            class="text-primaryColor font-sans text-md p-2 rounded-md pr-5"
                        >
                            O P E N &nbsp; I N &nbsp; G O O G L E &nbsp; M A P S
                        </button>
                        <i class="maps-ic"></i>
                    </a>
                </div>
            </div>
            <!-- Bagian Formulir Input -->
            <div class="w-full mt-5 sm:mt-0 sm:w-1/2">
                <p class="text-2xl font-spectral text-primaryColor pt-10">
                    SCHEDULE A VISIT
                </p>
                <div class="m-2 pr-4 pl-4 flex flex-col gap-3">
                    <div class="">
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
                    <div class="">
                        <label for="email" class="custom-label">EMAIL</label>
                        <input
                            type="email"
                            id="email"
                            class="custom-input"
                            placeholder="EMAIL"
                        />
                    </div>
                    <div class="">
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
                    <div class="">
                        <label for="date" class="custom-label">DATE</label>
                        <input
                            type="datetime-local"
                            id="date"
                            class="custom-input"
                            placeholder="PICK A DATE"
                        />
                    </div>
                    <div class="">
                        <label for="message" class="custom-label"
                            >MESSAGE</label
                        >
                        <textarea id="message" class="custom-input h-40">
Message</textarea
                        >
                    </div>
                    <div class="">
                        <div
                            class="flex border border-primaryColor w-40 justify-center rounded-lg"
                        >
                            <button
                                class="text-primaryColor font-sans text-md p-2 rounded-md pr-5"
                            >
                                S U B M I T
                            </button>
                            <i class="right-arrow-ic-brown"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="bg-[#BF8E44] h-full w-full">
                <div class="p-6 flex justify-end mr-5">
                    <a
                        class="text-[#2A4B2C] flex text-xl font-spectral cursor-pointer bg-[#CFCE9B] p-2 rounded-lg"
                        href="/enquire"
                    >
                        <p class="pr-2">Enquire Now</p>
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
import Footer from "../../components/Footer.vue";
</script>

<style scoped>
.maps-ic {
    content: url("../../../icons/maps-ic-brown.svg");
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
.right-arrow-ic-brown {
    content: url("../../../icons/right-arrow-ic-brown.svg");
}
::-webkit-calendar-picker-indicator {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
}
.right-arrow-ic {
    content: url("../../../icons/right-arrow-ic.svg");
}

/* Penyesuaian untuk tampilan mobile */
</style>
