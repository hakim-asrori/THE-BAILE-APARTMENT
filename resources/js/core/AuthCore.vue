<template>
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="../../images/logo.png" alt="" style="height: 100px; width: 100px" />
                                </div>
                                <h4 class="text-center mb-4">
                                    Sign in your account {{ isLoading }}
                                </h4>
                                <CForm method="post" @submit.prevent="handleSignIn">
                                    <div class="mb-3">
                                        <CFormInput type="email" label="Email address" v-model="form.email"
                                            :invalid="errors.email" :feedbackInvalid="errors.email"
                                            :disabled="isLoading" />
                                    </div>
                                    <div class="mb-3">
                                        <CFormInput type="password" label="Password" v-model="form.password"
                                            :invalid="errors.password" :feedbackInvalid="errors.password"
                                            :disabled="isLoading" />
                                    </div>
                                    <div class="text-center">
                                        <CButton type="submit" color="primary btn-block" v-if="!isLoading">
                                            Sign In
                                        </CButton>
                                        <CButton
                                            color="primary btn-block d-flex align-items-center gap-3 justify-content-center"
                                            v-if="isLoading">
                                            <CSpinner /> <span>Waiting...</span>
                                        </CButton>
                                    </div>
                                </CForm>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jsCookie from "js-cookie";
import { CFormInput, CButton, CForm, CSpinner } from "@coreui/vue";

<<<<<<< HEAD
export default {
    data() {
        return {
            isLoading: false,
            form: {
                email: "",
                password: ""
            },
            errors: {}
=======
const $store = useStore();
const $toast = useToast();
const isLoading = ref(false);
const form = ref({
    email: "",
    password: "",
});

const errors = ref({});

const handleSignIn = async () => {
    isLoading.value = true;
    errors.value = {};
    try {
        isLoading.value = false;
        let response = await $store.dispatch("postData", [
            "auth/login",
            form.value,
        ]);

        jsCookie.set("baile", response.data.baile);
        window.location.replace("/home");
    } catch (error) {
        console.log(error);
        isLoading.value = false;

        if (error.response.status == $store.state.STATUS_CODE.VALIDATION) {
            errors.value = error.response.data.messages;
>>>>>>> e25c2805c68abaa048ee6ec3c8f57a5f691bd63e
        }
    },
    methods: {
        async handleSignIn() {
            this.errors = {}
            this.isLoading = true

            this.$store.dispatch("postData", [
                "auth/login",
                this.form,
            ]).then((response) => {
                this.isLoading = false
                jsCookie.set("baile", response.data.baile);
                window.location.replace("/home");
            }).catch((error) => {
                this.isLoading = false

                if (error.response.status == this.$store.state.STATUS_CODE.VALIDATION) {
                    this.errors = error.response.data.messages;
                }

                if (
                    [
                        this.$store.state.STATUS_CODE.BAD_REQUEST,
                        this.$store.state.STATUS_CODE.SERVER_ERROR,
                    ].includes(error.response.status)
                ) {
                    this.$toast.error(error.response.data.messages, {
                        position: "top",
                    });
                }
            });
        }
    },
    components: { CFormInput, CButton, CForm, CSpinner }
}
</script>
