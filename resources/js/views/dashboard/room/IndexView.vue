<template>
    <router-link
        :to="{ name: 'home.room.create' }"
        class="btn btn-primary btn-sm mb-4"
    >
        <i class="fas fa-plus me-2"></i> Add new Room Type
    </router-link>

    <div class="d-flex justify-content-center">
        <CSpinner v-if="isLoading" />
    </div>
    <CAlert v-if="!isLoading && rooms.length < 1" color="warning"
        >Data empty!</CAlert
    >
    <CRow v-else>
        <CCol v-for="(room, index) in rooms" :key="index" lg="6" md="6">
            <CCard>
                <CCardHeader>
                    <CCardTitle v-html="room.title" />
                </CCardHeader>
                <CCardBody>
                    <p class="card-text" v-html="room.description"></p>
                </CCardBody>
                <CCardFooter
                    class="d-flex justify-content-end align-items-center gap-2"
                >
                    <router-link
                        :to="{
                            name: 'home.room.edit',
                            params: { id: room.id },
                        }"
                        class="btn btn-xs btn-warning"
                        ><i class="fas fa-edit"></i> Edit</router-link
                    >
                    <CButton
                        type="button"
                        color="danger"
                        size="xs"
                        @click="deleteRoom(room.id)"
                    >
                        <i class="fas fa-trash"></i> Delete
                    </CButton>
                </CCardFooter>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import {
    CCard,
    CCardBody,
    CCardHeader,
    CCardFooter,
    CButton,
    CTable,
    CTableHead,
    CTableHeaderCell,
    CTableBody,
    CTableDataCell,
    CRow,
    CCol,
    CCardTitle,
    CSpinner,
    CAlert,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
} from "@coreui/vue";

export default {
    data() {
        return {
            formPagination: {
                per_page: 8,
                page: 1,
            },
            pagination: [],
            rooms: [],
            isLoading: false,
        };
    },
    mounted() {
        this.getRooms();
    },
    methods: {
        getRooms() {
            this.isLoading = true;

            this.$store
                .dispatch("postData", ["room/view", {}])
                .then((response) => {
                    this.isLoading = false;
                    this.rooms = response.data;
                    this.pagination = response.pagination;
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

        deleteRoom(id) {
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
                        .dispatch("postData", ["room/delete/" + id, {}])
                        .then((response) => {
                            this.getRooms();
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
    },
    components: {
        CCard,
        CCardBody,
        CCardHeader,
        CCardFooter,
        CButton,
        CTable,
        CTableHead,
        CTableHeaderCell,
        CTableBody,
        CTableDataCell,
        CRow,
        CCol,
        CCardTitle,
        CSpinner,
        CAlert,
        CModalHeader,
        CModalTitle,
        CModalBody,
        CModalFooter,
    },
};
</script>

<style scoped>
.card-footer {
    padding: 1rem 1rem !important;
}
</style>
