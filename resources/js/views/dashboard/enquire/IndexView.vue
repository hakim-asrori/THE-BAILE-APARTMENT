<template>
    <CCard>
        <CLoader v-if="isLoading" />
        <CCardBody>
            <div class="d-md-flex align-items-center justify-content-between gap-3 mb-3">
                <div class="d-md-flex gap-3">
                    <CFormInput type="search" placeholder="search by name" @keyup="onSearch();"
                        v-model="formPagination.search" class="mb-md-0 mb-3" />
                    <CFormSelect class="mb-md-0 mb-3" :options="roomsSelect" @change="onRoomChange()"
                        v-model="formPagination.room" />
                </div>
                <Pagination :pagination="pagination" @onPageChange="onPageChange($event)" />
            </div>
            <div class="table-responsive">
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell>#</CTableHeaderCell>
                            <CTableHeaderCell>Name</CTableHeaderCell>
                            <CTableHeaderCell>Email</CTableHeaderCell>
                            <CTableHeaderCell>Phone</CTableHeaderCell>
                            <CTableHeaderCell>Room Type</CTableHeaderCell>
                            <CTableHeaderCell>Datetime</CTableHeaderCell>
                            <CTableHeaderCell></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-if="enquires.length < 1">
                            <CTableDataCell colspan="6" class="text-center">
                                No matching records found
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-else v-for="(enquire, index) in enquires" :key="index">
                            <CTableDataCell v-html="iteration(index)" />
                            <CTableDataCell v-html="enquire.name" />
                            <CTableDataCell v-html="enquire.email" />
                            <CTableDataCell v-html="enquire.phone" />
                            <CTableDataCell v-html="enquire.titleRoom" />
                            <CTableDataCell v-html="convertDate(enquire.date, enquire.time)" />
                            <CTableDataCell>
                                <div class="d-flex gap-2">
                                    <CButton type="button" @click="deleteEnquire(enquire.id)" color="danger" size="xs">
                                        <i class="fas fa-trash"></i> Delete
                                    </CButton>
                                </div>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </div>
        </CCardBody>
    </CCard>

    <CModal :visible="showMessageModal" @close="() => { showMessageModal = false }" aria-labelledby="showMessageModal">
        <CModalHeader>
            <CModalTitle id="showMessageModal">Show Message from <span class="fw-bold"
                    v-html="enquireSelected.name"></span>
            </CModalTitle>
        </CModalHeader>
        <CModalBody v-html="enquireSelected.message" />
        <CModalFooter>
            <CButton color="secondary" @click="() => { showMessageModal = false }">
                <i class="fas fa-sign-out-alt"></i>
                Close
            </CButton>
        </CModalFooter>
    </CModal>
</template>

<script>
import { CCard, CCardBody, CTable, CTableBody, CTableHead, CTableHeaderCell, CTableDataCell, CTableRow, CButton, CModal, CModalFooter, CModalBody, CModalHeader, CFormInput, CFormSelect } from "@coreui/vue"
import { Pagination } from "../../../components/dashboard"
import { CLoader } from "../../../components"
import util from '../../../store/services/util';

export default {
    data() {
        return {
            formPagination: {
                per_page: 10,
                page: 1,
                search: "",
                room: 0,
            },
            pagination: [],
            enquires: [],
            roomsSelect: [],
            enquireSelected: {},
            showMessageModal: false,
            isLoading: false,
        }
    },
    mounted() {
        this.getEnquire()
        this.getRooms()
    },
    methods: {
        getEnquire() {
            this.isLoading = true;
            this.$store.dispatch("postData", ["enquire/view", this.formPagination]).then((response) => {
                this.isLoading = false;
                this.enquires = response.data
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

        getRooms() {
            this.$store.dispatch("postData", ["room/view", {}]).then((response) => {
                let select = [];
                select.push({ label: "all room", value: 0 })
                response.data.forEach(room => {
                    select.value = room.id
                    select.label = room.title
                    select.push({
                        value: room.id,
                        label: room.title
                    })
                });

                this.roomsSelect = select
            }).catch((error) => {
                this.$swal({
                    icon: "error",
                    title: "Oops...",
                    text: error.response.data.messages,
                });
            });
        },

        deleteEnquire(id) {
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$store.dispatch("postData", ["enquire/delete/" + id, {}]).then((response) => {
                        this.getEnquire()
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

        onPageChange(e) {
            this.formPagination.page = e
            this.getEnquire()
        },

        onSearch() {
            this.getEnquire()
        },

        onRoomChange() {
            this.getEnquire()
        },

        convertDate(date, time) {
            return util.convertDateTime(date, time)
        },

        iteration(index) {
            return util.paginationIt(index, this.pagination)
        },
    },
    components: { CCard, CCardBody, CTable, CTableBody, CTableHead, CTableHeaderCell, CTableDataCell, CTableRow, CButton, CModal, CModalFooter, CModalBody, CModalHeader, CFormInput, Pagination, CLoader, CFormSelect }
}
</script>
