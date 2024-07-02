<template>
    <CCard>
        <CCardHeader>
            <router-link
                :to="{ name: 'home.facility.create' }"
                class="btn btn-primary btn-sm"
            >
                <i class="fas fa-plus me-2"></i> Add New Facility
            </router-link>
        </CCardHeader>
        <CCardBody>
            <div class="table-responsive">
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">#</CTableHeaderCell>
                            <CTableHeaderCell scope="col"
                                >Class</CTableHeaderCell
                            >
                            <CTableHeaderCell scope="col"
                                >Heading</CTableHeaderCell
                            >
                            <CTableHeaderCell scope="col"
                                >Heading</CTableHeaderCell
                            >
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow>
                            <CTableHeaderCell scope="row">1</CTableHeaderCell>
                            <CTableDataCell>Mark</CTableDataCell>
                            <CTableDataCell>Otto</CTableDataCell>
                            <CTableDataCell>@mdo</CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </div>
        </CCardBody>
    </CCard>
</template>

<script setup>
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
} from "@coreui/vue";
import { ref } from "vue";
</script>
