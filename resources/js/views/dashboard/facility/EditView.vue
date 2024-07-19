<template>
    <CForm @submit.prevent="handleSubmit">
        <CCard>
            <CCardHeader>
                <CCardTitle>Edit Facility</CCardTitle>
            </CCardHeader>
            <CCardBody>
                <CRow>
                    <CCol>
                        <div class="mb-3">
                            <CFormInput type="file" label="Upload Thumbnail" @change="uploadThumbnail"
                                accept="image/jpg, image/png, image/jpeg" :class="{
                                    'is-invalid':
                                        errors.image,
                                }" :feedbackInvalid="errors.image" :disabled="isLoading" />
                        </div>
                        <div class="mb-3" v-if="previewThumbnail">
                            <img :src="previewThumbnail" height="150" width="150" />
                        </div>
                        <div class="mb-3" v-else>
                            <img :src="facility.thumbnail" height="150" width="150" />
                        </div>
                        <div class="mb-3">
                            <CFormInput type="text" label="Title" v-model="form.title" :class="{
                                'is-invalid':
                                    errors.title,
                            }" :feedbackInvalid="errors.title" :disabled="isLoading" />
                        </div>
                        <div class="mb-3">
                            <CFormTextarea label="Description" v-model="form.description" :class="{
                                'is-invalid':
                                    errors.description,
                            }" :feedbackInvalid="errors.description" :disabled="isLoading"></CFormTextarea>
                        </div>
                        <div class="mb-3">
                            <CFormLabel>Features</CFormLabel>
                            <CRow>
                                <CCol lg="6 mb-3" v-for="(test, index) in 4" :key="index">
                                    <CFormInput type="text" v-model="form.features[index]" :class="{
                                        'is-invalid':
                                            errors.features &&
                                            errors.features.length > 0 &&
                                            errors.features[index],
                                    }" :feedbackInvalid="errors.features &&
                                        errors.features.length > 0 &&
                                        errors.features[index]
                                        " :disabled="isLoading" />
                                </CCol>
                            </CRow>
                        </div>
                    </CCol>
                </CRow>
            </CCardBody>
            <CCardFooter class="justify-content-between d-flex">
                <router-link class="btn btn-secondary btn-sm" :to="{ name: 'home.facility.index' }">
                    <i class="fas fa-chevron-left me-2"></i> Back
                </router-link>
                <CButton color="primary btn-sm" type="submit"><i class="fas fa-save me-2"></i> Save</CButton>
            </CCardFooter>
        </CCard>
    </CForm>
</template>

<script>
import {
    CCard,
    CCardHeader,
    CCardTitle,
    CCardBody,
    CCardFooter,
    CButton,
    CRow,
    CCol,
    CFormTextarea,
    CFormInput,
    CForm,
    CFormLabel,
    CTable,
    CTableBody,
    CTableDataCell,
    CTableHead,
    CTableHeaderCell,
    CTableRow,
    CTableFoot,
} from "@coreui/vue";
import { useStore } from "vuex";
import { ref } from "vue";

export default {
    props: ["id"],
    components: {
        CCard,
        CCardHeader,
        CCardTitle,
        CCardBody,
        CCardFooter,
        CButton,
        CRow,
        CCol,
        CFormTextarea,
        CFormInput,
        CForm,
        CFormLabel,
        CTable,
        CTableBody,
        CTableDataCell,
        CTableHead,
        CTableHeaderCell,
        CTableRow,
        CTableFoot,
    },
    data() {
        return {
            form: {
                title: "",
                image: null,
                description: "",
                features: [],
            },
            facility: {},
            previewThumbnail: null,
            counter: 0,
            isLoading: false,
            errors: {}
        };
    },
    mounted() {
        this.getFacility()
    },
    methods: {
        getFacility() {
            this.isLoading = true

            this.$store.dispatch("postData", [`facility/show/${this.id}`, {}]).then((response) => {
                this.isLoading = false
                this.facility = response.data
                this.form.title = response.data.title
                this.form.description = response.data.description
                response.data.features.forEach(feature => {
                    this.form.features.push(feature)
                });
            }).catch((error) => {
                this.isLoading = false
                this.$swal({
                    icon: "error",
                    title: "Oops...",
                    text: error.response.data.messages,
                });
            });
        },

        uploadThumbnail(event) {
            const file = event.target.files[0];
            this.form.image = file
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewThumbnail = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.$toast.error(
                    `File "${file.name}" must be a jpg, jpeg, or png image`,
                    {
                        position: "top",
                    }
                );
                this.previewThumbnail = null;
            }

            event.target.value = null;
        },
        handleSubmit() {
            this.errors = {};
            this.isLoading = true;

            let formData = new FormData()
            formData.append("title", this.form.title)
            if (this.form.image) {
                formData.append("image", this.form.image)
            }
            formData.append("description", this.form.description)
            for (let index = 0; index < this.form.features.length; index++) {
                formData.append(`features[${index}]`, this.form.features[index])
            }

            this.$store.dispatch("postData", [
                "facility/update/" + this.id,
                formData,
            ]).then((response) => {
                this.$swal({
                    icon: "success",
                    title: "Selamat...",
                    text: response.messages,
                });
                this.$router.push({ name: "home.facility.index" });
            }).catch((error) => {
                this.isLoading = false;
                if (
                    error.response.status ==
                    this.$store.state.STATUS_CODE.VALIDATION
                ) {
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
    }
};
</script>
