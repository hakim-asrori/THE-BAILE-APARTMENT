<template>
    <CForm @submit.prevent="handleSubmit">
        <CCard>
            <CCardBody>
                <CRow>
                    <CCol>
                        <div class="mb-3">
                            <CFormInput
                                type="file"
                                label="Upload Thumbnail"
                                @change="uploadThumbnail"
                            />
                        </div>
                        <div class="mb-3" v-show="previewThumbnail">
                            <img
                                :src="previewThumbnail"
                                height="150"
                                width="150"
                            />
                        </div>
                        <div class="mb-3">
                            <CFormInput type="text" label="Title" />
                        </div>
                        <div class="mb-3">
                            <CFormTextarea label="Description"></CFormTextarea>
                        </div>
                        <div class="mb-3">
                            <CFormLabel>Features</CFormLabel>
                            <CTable bordered>
                                <CTableHead>
                                    <CTableRow>
                                        <CTableHeaderCell scope="col"
                                            >Icon</CTableHeaderCell
                                        >
                                        <CTableHeaderCell scope="col"
                                            >Title</CTableHeaderCell
                                        >
                                        <CTableHeaderCell
                                            scope="col"
                                        ></CTableHeaderCell>
                                    </CTableRow>
                                </CTableHead>
                                <CTableBody>
                                    <CTableRow
                                        class="duplicate"
                                        id="double-0"
                                        data-id="0"
                                    >
                                        <CTableDataCell>
                                            <CFormInput />
                                        </CTableDataCell>
                                        <CTableDataCell>
                                            <CFormInput />
                                        </CTableDataCell>
                                        <CTableDataCell>
                                            <CButton
                                                color="danger btn-block btn-xs remove-feature"
                                                @click="removeFeature"
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
                    </CCol>
                </CRow>
            </CCardBody>
            <CCardFooter class="justify-content-between d-flex">
                <router-link
                    class="btn btn-secondary btn-sm"
                    :to="{ name: 'home.facility.index' }"
                >
                    <i class="fas fa-chevron-left me-2"></i> Back
                </router-link>
                <CButton color="primary btn-sm" type="submit"
                    ><i class="fas fa-save me-2"></i> Save</CButton
                >
            </CCardFooter>
        </CCard>
    </CForm>
</template>

<!-- <script setup>
import {
    CCard,
    CCardBody,
    CCardFooter,
    CButton,
    CRow,
    CCol,
    CFormTextarea,
    CFormInput,
    CForm,
    CFormLabel,
    CTable,
    CTableBody,
    CTableDataCell,
    CTableHead,
    CTableHeaderCell,
    CTableRow,
    CTableFoot,
} from "@coreui/vue";
import { useStore } from "vuex";
import { ref, onMounted } from "vue";

const $store = useStore();
const form = ref({
    title: "",
    image: null,
    description: "",
    features: "",
});
const previewThumbnail = ref(null);
let counter = 0;

onMounted(() => {
    counter = $(".duplicate:last").data("id");
    $("#double-" + counter)
        .find("button")
        .hide();
});

const uploadThumbnail = (event) => {
    const file = event.target.files[0];
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewThumbnail.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const duplicateFeature = () => {
    var editElm;
    counter++;

    $(".duplicate:last")
        .clone(true)
        .map(function () {
            editElm = $(this)
                .attr("id", `double-${counter}`)
                .attr("data-id", counter);
        });
    if ($("#double-" + (counter - 1)).length) {
        $("#double-" + (counter - 1)).after(editElm);
    } else {
        $("#double-0").after(editElm);
    }

    $(".duplicate").find("button").show();
    $("#double-" + counter)
        .find("button")
        .hide();
};

const removeFeature = () => {
    $(".remove-feature").on("click", function () {
        $(this).parents(".duplicate").remove();
    });
};

const handleSubmit = async () => {
    try {
        let response = await $store.dispatch("postData", [
            "facility/store",
            {},
        ]);
        console.log(response);
    } catch (error) {
        console.log(error.response);
    }
};
</script> -->
<script>
import {
    CCard,
    CCardBody,
    CCardFooter,
    CButton,
    CRow,
    CCol,
    CFormTextarea,
    CFormInput,
    CForm,
    CFormLabel,
    CTable,
    CTableBody,
    CTableDataCell,
    CTableHead,
    CTableHeaderCell,
    CTableRow,
    CTableFoot,
} from "@coreui/vue";
import { useStore } from "vuex";
import { ref } from "vue";

export default {
    components: {
        CCard,
        CCardBody,
        CCardFooter,
        CButton,
        CRow,
        CCol,
        CFormTextarea,
        CFormInput,
        CForm,
        CFormLabel,
        CTable,
        CTableBody,
        CTableDataCell,
        CTableHead,
        CTableHeaderCell,
        CTableRow,
        CTableFoot,
    },
    data() {
        return {
            form: {
                title: "",
                image: null,
                description: "",
                features: "",
            },
            previewThumbnail: null,
            counter: 0,
        };
    },
    mounted() {
        this.initDuplicateFeature()
    },
    methods: {
        uploadThumbnail(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewThumbnail = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        initDuplicateFeature() {
            this.counter = $(".duplicate:last").data("id") || 0;
            $("#double-" + this.counter)
                .find("button")
                .hide();
        },
        duplicateFeature() {
            var editElm;
            this.counter++;

            $(".duplicate:last")
                .clone(true)
                .map(function () {
                    editElm = $(this)
                        .attr("id", `double-${this.counter}`)
                        .attr("data-id", this.counter);
                }.bind(this));
            if ($("#double-" + (this.counter - 1)).length) {
                $("#double-" + (this.counter - 1)).after(editElm);
            } else {
                $("#double-0").after(editElm);
            }

            $(".duplicate").find("button").show();
            $("#double-" + this.counter)
                .find("button")
                .hide();
        },
        removeFeature() {
            $(".remove-feature").on("click", function () {
                $(this).parents(".duplicate").remove();
            });
        },
        async handleSubmit() {
            try {
                let response = await this.$store.dispatch("postData", [
                    "facility/store",
                    {},
                ]);
                console.log(response);
            } catch (error) {
                console.log(error.response);
            }
        }
    }
};
</script>
