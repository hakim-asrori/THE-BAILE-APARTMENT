<template>
    <div>
        <CCard>
            <CCardHeader class="justify-content-start gap-3">
                <router-link
                    :to="{ name: 'home.room.index' }"
                    class="text-primary"
                    ><i class="fas fa-arrow-left"></i
                ></router-link>
                <CCardTitle> Edit Room Type </CCardTitle>
            </CCardHeader>
        </CCard>

        <CRow>
            <CCol lg="5" md="6">
                <CForm @submit.prevent="handleSubmitRoom">
                    <CCard>
                        <CCardHeader>
                            <CCardTitle> Edit Title & Description</CCardTitle>
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
                            <div>
                                <CFormTextarea
                                    label="Description"
                                    rows="3"
                                    v-model="form.description"
                                    :class="{
                                        'is-invalid': errors.description,
                                    }"
                                    :feedbackInvalid="errors.description"
                                    :disabled="isLoading"
                                ></CFormTextarea>
                            </div>
                        </CCardBody>
                        <CCardFooter class="d-flex justify-content-end">
                            <CButton type="submit" color="primary" size="xs"
                                ><i class="fas fa-save"></i> Save</CButton
                            >
                        </CCardFooter>
                    </CCard>
                </CForm>
            </CCol>
            <CCol lg="7" md="6">
                <CCard>
                    <CCardHeader
                        class="d-flex justify-content-between align-items-center"
                    >
                        <CCardTitle> Edit Images</CCardTitle>
                        <CButton
                            size="xs"
                            color="primary"
                            v-if="room.images && room.images.length < 4"
                            @click="showModalImage = true"
                            ><i class="fas fa-upload"></i> Upload Image</CButton
                        >
                    </CCardHeader>
                    <CCardBody>
                        <CRow>
                            <CCol
                                v-for="(image, index) in room.images"
                                :key="index"
                                class="mb-3 position-relative"
                                sm="6"
                                md="6"
                                lg="6"
                            >
                                <router-link
                                    to="#"
                                    class="badge badge-circle badge-danger position-absolute top-0"
                                    style="right: 10px"
                                    @click="deleteImage(image.id)"
                                >
                                    <i class="fas fa-times"></i>
                                </router-link>
                                <CImage
                                    rounded
                                    thumbnail
                                    :src="image.image"
                                    style="height: 200px; width: 100%"
                                />
                            </CCol>
                        </CRow>
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
        <CForm @submit.prevent="handleSubmitFeature">
            <CCard>
                <CCardHeader>
                    <CCardTitle> Edit Features</CCardTitle>
                </CCardHeader>
                <CCardBody>
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
                                v-for="(item, index) in features"
                                :key="index"
                            >
                                <CTableDataCell>
                                    <CFormSelect
                                        v-model="features[index].typeId"
                                        :class="{
                                            'is-invalid':
                                                errors.features &&
                                                errors.features.length > 0 &&
                                                errors.features[index].typeId,
                                        }"
                                        :feedbackInvalid="
                                            errors.features &&
                                            errors.features.length > 0 &&
                                            errors.features[index].typeId
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
                                        v-model="features[index].name"
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
                                            features.length > 1 &&
                                            index !== features.length - 1
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
                </CCardBody>
                <CCardFooter class="d-flex justify-content-end">
                    <CButton type="submit" color="primary" size="xs"
                        ><i class="fas fa-save"></i> Save</CButton
                    >
                </CCardFooter>
            </CCard>
        </CForm>
    </div>

    <CModal
        :visible="showModalImage"
        @close="
            () => {
                showModalImage = false;
            }
        "
        aria-labelledby="showModalImage"
    >
        <CModalHeader>
            <CModalTitle id="showModalImage"> Upload Image </CModalTitle>
        </CModalHeader>
        <form @submit.prevent="handleSubmitImage" method="post">
            <CModalBody>
                <div>
                    <CFormInput
                        type="file"
                        multiple
                        accept="image/png, image/jpg, image/jpeg"
                        ref="imageFile"
                        @change="handleUploadImages($event)"
                        class="mb-3"
                        :class="{ 'is-invalid': errors.images }"
                        :feedbackInvalid="errors.images"
                        :disabled="isLoading"
                    />
                </div>

                <CRow>
                    <CCol
                        v-for="(image, index) in images"
                        :key="index"
                        class="mb-3 position-relative col-lg-6 col-md-6 col-sm-6"
                    >
                        <button
                            class="badge badge-circle badge-danger position-absolute top-0"
                            style="right: 10px"
                            @click="deleteImageForm(index)"
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
            </CModalBody>
            <CModalFooter>
                <CButton
                    size="sm"
                    color="secondary"
                    @click="
                        () => {
                            showModalImage = false;
                        }
                    "
                    v-if="!isLoading"
                >
                    <i class="fas fa-sign-out-alt"></i>
                    Close
                </CButton>
                <CButton
                    size="sm"
                    type="submit"
                    color="primary"
                    v-if="!isLoading"
                >
                    <i class="fas fa-save"></i>
                    Save
                </CButton>
                <CButton
                    size="sm"
                    color="primary d-flex align-items-center gap-3 justify-content-center"
                    v-if="isLoading"
                >
                    <CSpinner /> <span>Waiting...</span>
                </CButton>
            </CModalFooter>
        </form>
    </CModal>
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
    CModal,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
} from "@coreui/vue";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,
            showModalImage: false,
            images: [],
            errors: {},
            form: {
                title: "",
                description: "",
            },
            image: [],
            room: {},
            features: [],
            totalImage: 0,
        };
    },
    mounted() {
        this.getRoom();
    },
    methods: {
        getRoom() {
            this.isLoading = true;

            this.$store
                .dispatch("postData", [`room/show/${this.id}`, {}])
                .then((response) => {
                    this.isLoading = false;
                    this.room = response.data;
                    this.form.title = response.data.title;
                    this.totalImage = 4 - response.data.images.length;
                    this.form.description = response.data.description;
                    this.features = response.data.features;
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: error.response.data.messages,
                    });
                });
        },

        handleSubmitRoom() {
            this.errors = {};
            this.isLoading = true;

            this.$store
                .dispatch("postData", [
                    "room/update/" + this.room.id,
                    this.form,
                ])
                .then((response) => {
                    this.$swal({
                        icon: "success",
                        title: "Selamat...",
                        text: response.messages,
                    });
                    this.getRoom();
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

        handleSubmitFeature() {
            this.errors = {};
            this.isLoading = true;

            let formData = new FormData();
            for (let index = 0; index < this.features.length; index++) {
                formData.append(
                    `features[${index}][name]`,
                    this.features[index].name
                );
                formData.append(
                    `features[${index}][type]`,
                    this.features[index].typeId
                );
            }
            formData.append("room_id", this.id);

            this.$store
                .dispatch("postData", ["room/feature/store", formData])
                .then((response) => {
                    this.$swal({
                        icon: "success",
                        title: "Selamat...",
                        text: response.messages,
                    });
                    this.getRoom();
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

        handleSubmitImage() {
            this.errors = {};
            this.isLoading = true;

            let formData = new FormData();
            for (let index = 0; index < this.image.length; index++) {
                formData.append(`images[${index}]`, this.image[index]);
            }
            formData.append("room_id", this.id);

            this.$store
                .dispatch("postData", ["room/image/store", formData])
                .then((response) => {
                    this.$swal({
                        icon: "success",
                        title: "Selamat...",
                        text: response.messages,
                    });
                    this.getRoom();
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
            if (images.length > this.totalImage) {
                e.target.value = [];
                this.$swal({
                    title: "Ooops!",
                    text: `Your image must be ${this.totalImage}.`,
                    icon: "error",
                });
            }

            for (let index = 0; index < images.length; index++) {
                const file = images[index];

                this.image.push(file);

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
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$store
                        .dispatch("postData", ["room/image/delete/" + id, {}])
                        .then((response) => {
                            this.getRoom();
                            this.$swal({
                                title: "Deleted!",
                                text: "Your data has been deleted.",
                                icon: "success",
                            });
                        })
                        .catch((error) => {
                            this.$toast.error(error.response.data.messages, {
                                position: "top",
                            });
                        });
                }
            });
        },

        deleteImageForm(id) {
            this.images.splice(id, 1);
            this.image.splice(id, 1);
        },

        duplicateFeature() {
            this.features.push({ typeId: "", name: "" });
            if (
                this.errors &&
                this.errors.features &&
                this.errors.features.length > 0
            ) {
                this.errors.features.push({});
            }
        },

        removeFeature(id) {
            this.features.splice(id, 1);
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
        CModal,
        CModalHeader,
        CModalTitle,
        CModalBody,
        CModalFooter,
    },
};
</script>
