<template>
    <CCard>
        <CCardBody>
            <div class="d-sm-flex align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <CFormInput type="search" placeholder="search by name, email, phone" @keyup="onSearch();"
                        v-model="formPagination.search" />
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
                            <CTableHeaderCell>Datetime</CTableHeaderCell>
                            <CTableHeaderCell></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-if="contacts.length < 1">
                            <CTableDataCell colspan="6" class="text-center">
                                No matching records found
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-else v-for="(contact, index) in contacts" :key="index">
                            <CTableDataCell v-html="iteration(index)" />
                            <CTableDataCell v-html="contact.name" />
                            <CTableDataCell v-html="contact.email" />
                            <CTableDataCell v-html="contact.phone" />
                            <CTableDataCell v-html="convertDate(contact.date, contact.time)" />
                            <CTableDataCell>
                                <div class="d-flex gap-2">
                                    <CButton color="info" size="xs"
                                        @click="() => { showMessageModal = true, contactSelected = contact }"><i
                                            class="fas fa-eye"></i> Show Message</CButton>
                                    <CButton type="button" @click="deleteContact(contact.id)" color="danger" size="xs">
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
                    v-html="contactSelected.name"></span>
            </CModalTitle>
        </CModalHeader>
        <CModalBody v-html="contactSelected.message" />
        <CModalFooter>
            <CButton color="secondary" @click="() => { showMessageModal = false }">
                <i class="fas fa-sign-out-alt"></i>
                Close
            </CButton>
        </CModalFooter>
    </CModal>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from "vuex";
import { useToast } from 'vue-toast-notification';
import { CCard, CCardBody, CTable, CTableBody, CTableHead, CTableHeaderCell, CTableDataCell, CTableRow, CButton, CModal, CModalFooter, CModalBody, CModalHeader, CFormInput } from "@coreui/vue"
import { Pagination } from "../../../components/dashboard"
import util from '../../../store/services/util';
import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.css'

const contacts = ref([])
const pagination = ref([])
const contactSelected = ref({})
const showMessageModal = ref(false)
const formPagination = ref({
    per_page: 10,
    page: 1,
    search: ""
})

const $store = useStore()
const $toast = useToast()

onMounted(() => {
    getContacts()
})

const getContacts = async () => {
    try {
        let response = await $store.dispatch("postData", ["contact/view", formPagination.value])
        contacts.value = response.data
        pagination.value = response.pagination
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error.response.data.messages,
        });
    }
}

const deleteContact = async (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await $store.dispatch("postData", ["contact/delete/" + id, {}])
                getContacts()
                Swal.fire({
                    title: "Deleted!",
                    text: "Your data has been deleted.",
                    icon: "success"
                });
            } catch (error) {
                $toast.error(error.response.data.messages, {
                    position: "top",
                });
            }
        }
    });
}

const onPageChange = (e) => {
    formPagination.value.page = e
    getContacts()
}

const onSearch = () => {
    getContacts()
}

const convertDate = (date, time) => {
    return util.convertDateTime(date, time)
}

const iteration = (index) => {
    return util.paginationIt(index, pagination.value)
}
</script>
