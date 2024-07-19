<template>
    <CCard>
        <CLoader v-if="isLoading" />
        <CCardHeader>
            <router-link :to="{ name: 'home.facility.create' }" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i> Add New Facility
            </router-link>
        </CCardHeader>
        <CCardBody>
            <div class="d-sm-flex align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <CFormInput type="search" placeholder="search by title" @keyup="onSearch()"
                        v-model="formPagination.search" />
                </div>
                <Pagination :pagination="pagination" @onPageChange="onPageChange($event)" />
            </div>
            <div class="table-responsive">
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">#</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Title</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Feature</CTableHeaderCell>
                            <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-if="facilities.length < 1">
                            <CTableDataCell colspan="4" class="text-center">
                                No matching records found
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-else v-for="(facility, index) in facilities" :key="index">
                            <CTableDataCell>{{ iteration(index) }}</CTableDataCell>
                            <CTableDataCell>{{ facility.title }}</CTableDataCell>
                            <CTableDataCell>
                                <ul>
                                    <li v-for="(feature, indexFeature) in facility.features" :key="indexFeature"
                                        v-html="feature"></li>
                                </ul>
                            </CTableDataCell>
                            <CTableDataCell>
                                <router-link :to="{
                                    name: 'home.facility.edit',
                                    params: { id: facility.id },
                                }" class="btn btn-xs btn-warning me-2"><i class="fas fa-edit"></i> Edit</router-link>
                                <CButton type="button" color="danger" size="xs" @click="deleteFacility(facility.id)">
                                    <i class="fas fa-trash"></i> Delete
                                </CButton>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </div>
        </CCardBody>
    </CCard>
</template>

<script>
import {
    CCard,
    CCardBody,
    CCardHeader,
    CTable,
    CTableBody,
    CTableDataCell,
    CTableHead,
    CTableHeaderCell,
    CTableRow,
    CButton,
    CFormInput,
} from "@coreui/vue";
import { ref } from "vue";
import util from "../../../store/services/util";
import { Pagination } from "../../../components/dashboard";
import { CLoader } from "../../../components";

export default {
    data() {
        return {
            facilities: [],
            formPagination: {
                per_page: 10,
                page: 1,
                search: ""
            },
            pagination: [],
            isLoading: false
        }
    },
    mounted() {
        this.getFacilities()
    },
    methods: {
        getFacilities() {
            this.isLoading = true;

            this.$store.dispatch("postData", ["facility/view", this.formPagination]).then((response) => {
                this.isLoading = false;
                this.facilities = response.data
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

        deleteFacility(id) {
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
                        .dispatch("postData", ["facility/delete/" + id, {}])
                        .then((response) => {
                            this.getFacilities();
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

        onPageChange(e) {
            this.formPagination.page = e
            this.getFacilities()
        },

        onSearch() {
            this.getFacilities()
        },

        iteration(index) {
            return util.paginationIt(index, this.pagination)
        },
    },
    components: {
        CCard,
        CCardBody,
        CCardHeader,
        CTable,
        CTableBody,
        CTableDataCell,
        CTableHead,
        CTableHeaderCell,
        CTableRow,
        CButton,
        CFormInput,
        Pagination,
        CLoader
    }
}
</script>
