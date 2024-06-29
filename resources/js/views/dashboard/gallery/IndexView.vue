<template>
    <CCard>
        <CLoader v-if="isLoading" />
        <CCardHeader class="d-md-flex align-items-center justify-content-between gap-3">
            <div>
                <CButton color="primary" @click="showMessageModal = true"><i class="fas fa-upload"></i> Upload Image
                </CButton>
            </div>
            <Pagination :pagination="pagination" @onPageChange="onPageChange($event)" />
        </CCardHeader>
        <CCardBody>
            <CRow id="lightgallery">
                <CCol v-for="(gallery, index) in galleries" :key="index"
                    class="mb-3 position-relative col-lg-3 col-md-6 col-sm-6">
                    <button class="badge badge-circle badge-danger position-absolute top-0" style="right: 10px;"
                        @click="deleteGallery(gallery.id)">
                        <i class="fas fa-times"></i>
                    </button>
                    <CImage rounded thumbnail :src="gallery.imagePath" style="height: 200px; width: 100%;" />
                </CCol>
            </CRow>
        </CCardBody>
    </CCard>

    <CModal :visible="showMessageModal" @close="() => { showMessageModal = false }" aria-labelledby="showMessageModal">
        <CModalHeader>
            <CModalTitle id="showMessageModal">
                Upload Image
            </CModalTitle>
        </CModalHeader>
        <form @submit.prevent="handleSubmit()" method="post">
            <CModalBody>
                <div>
                    <CFormInput type="file" multiple accept="image/png, image/jpg, image/jpeg" ref="imageFile"
                        @change="handleUploadImages($event)" class="mb-3" :class="{ 'is-invalid': errors.images }"
                        :feedbackInvalid="errors.images" :disabled="isLoading" />
                </div>

                <CRow>
                    <CCol v-for="(image, index) in images" :key="index"
                        class="mb-3 position-relative col-lg-6 col-md-6 col-sm-6">
                        <button class="badge badge-circle badge-danger position-absolute top-0" style="right: 10px;"
                            @click="deleteImage(index)">
                            <i class="fas fa-times"></i>
                        </button>
                        <CImage rounded thumbnail :src="image.url" style="height: 200px; width: 100%;" />
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => { showMessageModal = false }" v-if="!isLoading">
                    <i class="fas fa-sign-out-alt"></i>
                    Close
                </CButton>
                <CButton type="submit" color="primary" v-if="!isLoading">
                    <i class="fas fa-save"></i>
                    Save
                </CButton>
                <CButton color="primary d-flex align-items-center gap-3 justify-content-center" v-if="isLoading">
                    <CSpinner /> <span>Waiting...</span>
                </CButton>
            </CModalFooter>
        </form>
    </CModal>
</template>

<script>
import { CButton, CCard, CCardBody, CCardHeader, CRow, CCol, CImage, CModal, CModalHeader, CModalTitle, CModalBody, CModalFooter, CFormInput, CSpinner } from '@coreui/vue';
import { CLoader } from '../../../components';
import { Pagination } from '../../../components/dashboard';

export default {
    data() {
        return {
            formPagination: {
                per_page: 8,
                page: 1,
            },
            pagination: [],
            galleries: [],
            gallerySelected: {},
            showMessageModal: false,
            isLoading: false,
            images: [],
            form: {
                images: []
            },
            errors: {}
        }
    },
    mounted() {
        this.getGalleries()
    },
    methods: {
        getGalleries() {
            this.isLoading = true;
            this.$store.dispatch("postData", ["gallery/view", this.formPagination])
                .then((response) => {
                    this.isLoading = false;
                    this.galleries = response.data
                    this.pagination = response.pagination
                }).catch((error) => {
                    this.isLoading = false;
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: error.response.data.messages,
                    });
                });
        },

        deleteGallery(id) {
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$store.dispatch("postData", ["gallery/delete/" + id, {}]).then((response) => {
                        this.getGalleries()
                        this.$swal({
                            title: "Deleted!",
                            text: "Your data has been deleted.",
                            icon: "success"
                        });
                    }).catch((error) => {
                        this.$toast.error(error.response.data.messages, {
                            position: "top",
                        });
                    });
                }
            });
        },

        handleSubmit() {
            this.isLoading = true;
            this.errors = {}

            let formData = new FormData()
            for (let index = 0; index < this.form.images.length; index++) {
                formData.append(`images[${index}]`, this.form.images[index])
            }

            this.$store.dispatch("postData", ["gallery/store", formData]).then((response) => {
                this.showMessageModal = false
                this.$swal({
                    icon: "success",
                    title: "Selamat...",
                    text: response.messages,
                });
                this.form.images = []
                this.images = []
                this.getGalleries()
            }).catch((error) => {
                this.isLoading = false;

                if (error.response.status == this.$store.state.STATUS_CODE.VALIDATION) {
                    this.errors = error.response.data.messages
                }

                if (
                    [
                        this.$store.state.STATUS_CODE.BAD_REQUEST,
                        this.$store.state.STATUS_CODE.SERVER_ERROR,
                    ].includes(error.response.status)
                ) {
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: error.response.data.messages,
                    });
                }
            });
        },

        handleUploadImages(e) {
            this.errors = {}
            let images = e.target.files;

            for (let index = 0; index < images.length; index++) {
                const file = images[index];

                this.form.images.push(file)

                if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.images.push({ url: e.target.result })
                    }

                    reader.readAsDataURL(file)
                } else {
                    this.$toast.error(`File "${file.name}" must be a jpg, jpeg, or png image`, {
                        position: "top"
                    })
                    this.images = []
                }
            }

            e.target.value = []
        },

        deleteImage(id) {
            this.images.splice(id, 1);
            this.form.images.splice(id, 1)
        },

        onPageChange(e) {
            this.formPagination.page = e
            this.getGalleries()
        }
    },
    components: { CCard, CCardBody, CCardHeader, CButton, CLoader, Pagination, CRow, CCol, CImage, CModal, CModalHeader, CModalTitle, CModalBody, CModalFooter, CFormInput, CSpinner }
};
</script>
