<template>
    <div>
        <div class="flex flex-col md:flex-row m-5">
            <div class="w-full md:w-1/3 h-full p-2">
                <p>
                    Jl. Kimia No.4 10, RT.10/RW.1, Pegangsaan, Kec. Menteng,
                    Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10h-440
                </p>
                <p class="mt-2"><b>PHONE</b> &nbsp;: (+62) 857-1810-1985</p>
                <p><b>PHONE</b> &nbsp;: (+62) 813-8707-6706</p>
                <p><b>PHONE</b> &nbsp;: (+62) 821-2927-4019</p>
                <p class="mt-2">
                    <b>EMAIL</b> &nbsp; &nbsp;: thebaileapartment@gmail.com
                </p>
            </div>
            <div class="w-full md:w-1/3 h-44 flex flex-col">
                <div class="flex flex-grow h-full items-center">
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        HOME
                    </p>
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        FACILITIES
                    </p>
                </div>
                <div class="flex flex-grow h-full items-center">
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        ROOM TYPE
                    </p>
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        GALLERY
                    </p>
                </div>
                <div class="flex flex-grow h-full items-center">
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        CONTACT
                    </p>
                    <p
                        class="font-sans text-primaryColor w-full justify-center flex"
                    >
                        ENQUIRE
                    </p>
                </div>
            </div>
            <div class="w-full md:w-1/3 h-44 text-primaryColor mt-5 md:mt-0">
                <div>
                    <p class="font-spectral text-xl">
                        Receive news and offers from The Baile Apartment.
                    </p>
                </div>
                <p class="font-spectral text-sm mt-5">EMAIL</p>
                <div class="flex">
                    <input
                        type="text"
                        class="bg-transparent border-b-2 border-black p-2 mr-5 flex-grow"
                        v-model="email"
                    />
                    <div
                        class="border border-[#5F3F2F] rounded-3xl pt-2 w-28 flex justify-center cursor-pointer"
                        @click="handleSubmit()"
                    >
                        SUBSCRIBE
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="border-t border-[#5F3F2F]"></div>
        <div
            class="w-full h-16 flex flex-col md:flex-row justify-between items-center"
        >
            <div class="flex h-full items-center p-5 text-primaryColor">
                © 2024 thebaileapartment.com - Apartment.
            </div>
            <div class="pr-5 pt-2 text-center md:text-left">
                <p class="text-primaryColor">CONNECT WITH US</p>
                <div class="flex gap-2 justify-center">
                    <a href="https://instagram.com/dzikrifazahk">
                        <i class="icon-instagram"></i>
                    </a>
                    <a href="https://facebook.com/dzikrifazahk">
                        <i class="icon-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import store from "../store";

import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { validateEmail } from "../helpers/validate";
const $toast = useToast();

const email = ref("");

const handleSubmit = async () => {
    const isValidEmail = validateEmail(email.value);

    if (!isValidEmail) {
        return $toast.warning("Invalid Email !", {
            position: "top-right",
        });
    }

    try {
        const response = await store.dispatch("postData", [
            "public/subscription/store",
            {
                email: email.value,
            },
        ]);
        if (response.code === 201 || response.code === 200) {
            $toast.success("Success To Subscribe!", {
                position: "top-right",
            });
        }
    } catch (error) {
        $toast.error(`${error}`, {
            position: "top-right",
        });
    }
};
</script>
<style scoped>
.icon-instagram::before {
    content: url("../../icons/instagram_ic.svg");
    cursor: pointer;
}
.icon-facebook::before {
    content: url("../../icons/facebook_ic.svg");
    cursor: pointer;
}
</style>
