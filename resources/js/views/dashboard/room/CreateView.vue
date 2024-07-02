<template>
    <CForm @submit.prevent="handleSubmit">
        <CCard>
            <CCardHeader>
                <CCardTitle>Create new Room Type</CCardTitle>
            </CCardHeader>
            <CCardBody>
                <div class="mb-3">
                    <CFormInput
                        type="text"
                        label="Title"
                        v-model="form.title"
                        :class="{ 'is-invalid': errors.title }"
                        :feedbackInvalid="errors.title"
                        :disabled="isLoading"
                    />
                </div>
                <div class="mb-3">
                    <CFormTextarea
                        label="Description"
                        rows="3"
                        v-model="form.description"
                        :class="{ 'is-invalid': errors.description }"
                        :feedbackInvalid="errors.description"
                        :disabled="isLoading"
                    ></CFormTextarea>
                </div>
                <div class="mb-3">
                    <CFormInput
                        label="Upload Image"
                        text="Must be 4 image."
                        type="file"
                        max="4"
                        multiple
                        accept="image/png, image/jpg, image/jpeg"
                        ref="imageFile"
                        @change="handleUploadImages($event)"
                        class="mb-3"
                        :class="{
                            'is-invalid':
                                errors.images && errors.images.length > 0,
                        }"
                        :feedbackInvalid="errors.images"
                        :disabled="isLoading"
                    />
                </div>
                <div class="mb-3">
                    <CRow>
                        <CCol
                            v-for="(image, index) in images"
                            :key="index"
                            class="mb-3 position-relative col-lg-6 col-md-6 col-sm-6"
                        >
                            <button
                                class="badge badge-circle badge-danger position-absolute top-0"
                                style="right: 10px"
                                @click="deleteImage(index)"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                            <CImage
                                rounded
                                thumbnail
                                :src="image.url"
                                style="height: 200px; width: 100%"
                            />
                        </CCol>
                    </CRow>
                </div>
                <div class="mb-3">
                    <CFormLabel>Features</CFormLabel>
                    <CTable bordered>
                        <CTableHead>
                            <CTableRow>
                                <CTableHeaderCell scope="col"
                                    >Type</CTableHeaderCell
                                >
                                <CTableHeaderCell scope="col"
                                    >Name</CTableHeaderCell
                                >
                                <CTableHeaderCell
                                    scope="col"
                                ></CTableHeaderCell>
                            </CTableRow>
                        </CTableHead>
                        <CTableBody>
                            <CTableRow
                                v-for="(item, index) in form.features"
                                :key="index"
                            >
                                <CTableDataCell>
                                    <CFormSelect
                                        v-model="form.features[index].type"
                                        :class="{
                                            'is-invalid':
                                                errors.features &&
                                                errors.features.length > 0 &&
                                                errors.features[index].type,
                                        }"
                                        :feedbackInvalid="
                                            errors.features &&
                                            errors.features.length > 0 &&
                                            errors.features[index].type
                                        "
                                        :disabled="isLoading"
                                    >
                                        <option disabled selected></option>
                                        <option value="1">Features</option>
                                        <option value="2">Bathroom</option>
                                        <option value="3">Entertainment</option>
                                    </CFormSelect>
                                </CTableDataCell>
                                <CTableDataCell>
                                    <CFormInput
                                        v-model="form.features[index].name"
                                        :class="{
                                            'is-invalid':
                                                errors.features &&
                                                errors.features.length > 0 &&
                                                errors.features[index].name,
                                        }"
                                        :feedbackInvalid="
                                            errors.features &&
                                            errors.features.length > 0 &&
                                            errors.features[index].name
                                        "
                                        :disabled="isLoading"
                                    />
                                </CTableDataCell>
                                <CTableDataCell>
                                    <CButton
                                        color="danger btn-block btn-xs remove-feature"
                                        @click="removeFeature(index)"
                                        v-if="
                                            form.features.length > 1 &&
                                            index !== form.features.length - 1
                                        "
                                    >
                                        <i class="fas fa-trash"></i>
                                    </CButton>
                                </CTableDataCell>
                            </CTableRow>
                        </CTableBody>
                        <CTableFoot>
                            <CTableRow>
                                <CTableDataCell colspan="3">
                                    <CButton
                                        color="info btn-block btn-xs"
                                        @click="duplicateFeature"
                                    >
                                        <i class="fas fa-plus"></i>
                                    </CButton>
                                </CTableDataCell>
                            </CTableRow>
                        </CTableFoot>
                    </CTable>
                </div>
            </CCardBody>
            <CCardFooter
                class="d-flex justify-content-between align-items-center"
            >
                <router-link
                    :to="{ name: 'home.room.index' }"
                    class="btn btn-secondary btn-sm"
                >
                    <i class="fas fa-sign-out-alt me-2"></i> Cancel
                </router-link>
                <CButton type="submit" color="primary" size="sm">
                    <i class="fas fa-plus me-2"></i>Add
                </CButton>
            </CCardFooter>
        </CCard>
    </CForm>
</template>

<script>
import {
    CCard,
    CCardBody,
    CCardHeader,
    CButton,
    CForm,
    CFormInput,
    CFormTextarea,
    CRow,
    CCol,
    CImage,
    CFormLabel,
    CTable,
    CTableHead,
    CTableFoot,
    CTableBody,
    CTableDataCell,
    CTableHeaderCell,
    CTableRow,
    CCardFooter,
    CCardTitle,
    CFormSelect,
} from "@coreui/vue";

export default {
    data() {
        return {
            isLoading: false,
            images: [],
            errors: {},
            form: {
                title: "",
                description: "",
                images: [],
                features: Array(1)
                    .fill()
                    .map(() => ({ type: "", name: "" })),
            },
        };
    },
    mounted() {},
    methods: {
        handleSubmit() {
            this.errors = {};
            this.isLoading = true;

            let formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            for (let index = 0; index < this.form.images.length; index++) {
                formData.append(`images[${index}]`, this.form.images[index]);
            }
            for (let index = 0; index < this.form.features.length; index++) {
                formData.append(
                    `features[${index}][type]`,
                    this.form.features[index].type
                );
                formData.append(
                    `features[${index}][name]`,
                    this.form.features[index].name
                );
            }

            this.$store
                .dispatch("postData", ["room/store", formData])
                .then((response) => {
                    this.$swal({
                        icon: "success",
                        title: "Selamat...",
                        text: response.messages,
                    });
                    this.$router.push({ name: "home.room.index" });
                })
                .catch((error) => {
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
        },

        handleUploadImages(e) {
            this.errors = {};
            let images = e.target.files;

            for (let index = 0; index < images.length; index++) {
                const file = images[index];

                this.form.images.push(file);

                if (
                    file.type == "image/jpeg" ||
                    file.type == "image/png" ||
                    file.type == "image/jpg"
                ) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.images.push({ url: e.target.result });
                    };

                    reader.readAsDataURL(file);
                } else {
                    this.$toast.error(
                        `File "${file.name}" must be a jpg, jpeg, or png image`,
                        {
                            position: "top",
                        }
                    );
                    this.images = [];
                }
            }

            e.target.value = [];
        },

        deleteImage(id) {
            this.images.splice(id, 1);
            this.form.images.splice(id, 1);
        },

        duplicateFeature() {
            this.form.features.push({ type: "", name: "" });
            if (
                this.errors &&
                this.errors.features &&
                this.errors.features.length > 0
            ) {
                this.errors.features.push({});
            }
        },

        removeFeature(id) {
            this.form.features.splice(id, 1);
        },
    },
    components: {
        CCard,
        CCardBody,
        CCardHeader,
        CButton,
        CForm,
        CFormInput,
        CFormTextarea,
        CRow,
        CCol,
        CImage,
        CFormLabel,
        CTable,
        CTableHead,
        CTableFoot,
        CTableBody,
        CTableDataCell,
        CTableHeaderCell,
        CTableRow,
        CCardFooter,
        CCardTitle,
        CFormSelect,
    },
};
</script>
