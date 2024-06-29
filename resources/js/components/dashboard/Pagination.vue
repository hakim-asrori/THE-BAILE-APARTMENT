<template>
    <CNav class="d-flex align-items-center justify-content-md-end justify-content-center">
        <p class="me-2 ">{{ pagination.from }} - {{ pagination.to }}</p>
        <p class="me-2 ">dari</p>
        <p class="">{{ pagination.total }}</p>
        <div class="d-flex">
            <p class="" :class="pagination.currentPage == 1 ? 'pointer-block' : ''">
                <CButton class="btn no-border show-block" :disabled="pagination.currentPage == 1"
                    @click="onPageChange(pagination.currentPage - 1)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 8 8 12 12 16"></polyline>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                    </svg>
                </CButton>
            </p>
            <p class="" :class="pagination.currentPage == pagination.lastPage
                ? 'pointer-block'
                : ''
                ">
                <CButton class="btn show-block no-border" :disabled="pagination.currentPage == pagination.lastPage"
                    @click="onPageChange(pagination.currentPage + 1)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-right-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 16 16 12 12 8"></polyline>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </CButton>
            </p>
        </div>
    </CNav>
</template>

<script setup>
import { CNav, CButton } from "@coreui/vue";
import { defineProps, defineEmits } from "vue"

const props = defineProps({
    pagination: {
        type: Object,
        default: {}
    }
})

const emit = defineEmits(['onPageChange']);

const onPageChange = (page) => {
    emit('onPageChange', page)
}
</script>

<style scoped>
.pointer-block {
    cursor: no-drop;
}

.no-border {
    border: none;
}

.show-block:hover {
    background-color: rgba(0, 0, 0, 0.035);
}

p {
    padding: 0;
    margin: 0;
}
</style>
