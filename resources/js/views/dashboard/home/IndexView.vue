<template>
    <CRow class="invoice-card-row">
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <CCard class="bg-warning invoice-card">
                <CCardBody class="d-flex">
                    <div class="icon me-3">
                        <i class="flaticon-013-checkmark text-white" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">{{ dashboard.countFacility }}</h2>
                        <span class="text-white fs-18">Total Facilities</span>
                    </div>
                </CCardBody>
            </CCard>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <CCard class="bg-success invoice-card">
                <CCardBody class="d-flex">
                    <div class="icon me-3">
                        <i class="text-white flaticon-046-home" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">{{ dashboard.countRoom }}</h2>
                        <span class="text-white fs-18">Total Rooms</span>
                    </div>
                </CCardBody>
            </CCard>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <CCard class="bg-info invoice-card">
                <CCardBody class="d-flex">
                    <div class="icon me-3">
                        <i class="text-white flaticon-381-notebook" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">{{ dashboard.countContact }}</h2>
                        <span class="text-white fs-18">Total Contact & Enquire</span>
                    </div>
                </CCardBody>
            </CCard>
        </div>
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <CCard class="bg-secondary invoice-card">
                <CCardBody class="d-flex">
                    <div class="icon me-3">
                        <i class="text-white flaticon-381-phone-call" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">{{ dashboard.countSubscription }}</h2>
                        <span class="text-white fs-18">Total Subscription</span>
                    </div>
                </CCardBody>
            </CCard>
        </div>
    </CRow>
    <CCard>
        <CCardBody>
            <CTable>
                <CTableHead>
                    <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Email</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Created At</CTableHeaderCell>
                        <CTableHeaderCell scope="col"></CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-if="subscriptions.length < 1">
                        <CTableDataCell colspan="3" class="text-center">
                            No matching records found
                        </CTableDataCell>
                    </CTableRow>
                    <CTableRow v-else v-for="(subscription, index) in subscriptions" :key="index">
                        <CTableDataCell>{{ iteration(index) }}</CTableDataCell>
                        <CTableDataCell>{{ subscription.email }}</CTableDataCell>
                        <CTableDataCell>{{ convertDate(subscription.createdAt) }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton type="button" color="danger" size="xs"
                                @click="deleteSubscription(subscription.id)">
                                <i class="fas fa-trash"></i> Delete
                            </CButton>
                        </CTableDataCell>
                    </CTableRow>
                </CTableBody>
            </CTable>
        </CCardBody>
    </CCard>
</template>

<script setup>
import { CButton, CCard, CCardBody, CCol, CRow, CTable, CTableBody, CTableDataCell, CTableHead, CTableHeaderCell, CTableRow } from '@coreui/vue';
import { ref, onMounted } from "vue";
import { useToast } from 'vue-toast-notification';
import Swal from 'sweetalert2'
import store from '../../../store';
import util from "../../../store/services/util";

const $toast = useToast();

const dashboard = ref({})
const subscriptions = ref([])
const pagination = ref({})

onMounted(() => {
    getDashboard()
    getSubscriptions()
})

const iteration = (index) => {
    return util.paginationIt(index, pagination.value)
}

const convertDate = (createdAt) => {
    let date = new Date(createdAt)
    let formatedDate = date.toLocaleDateString('en-EN', { day: '2-digit', month: 'long', year: 'numeric' })
    return formatedDate
}

const getDashboard = async () => {
    try {
        let response = await store.dispatch("postData", ["dashboard", {}]);
        dashboard.value = response.data
    } catch (error) {
        $toast.error("Something Wrong")
    }
}

const getSubscriptions = async () => {
    try {
        let response = await store.dispatch("postData", ["subscription/view", {}]);
        subscriptions.value = response.data
        pagination.value = response.pagination
    } catch (error) {
        $toast.error("Something Wrong")
    }
}

const deleteSubscription = async (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            store
                .dispatch("postData", ["subscription/delete/" + id, {}])
                .then((response) => {
                    getSubscriptions();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your data has been deleted.",
                        icon: "success",
                    });
                })
                .catch((error) => {
                    $toast.error(error.response.data.messages, {
                        position: "top",
                    });
                });
        }
    });
}
</script>
