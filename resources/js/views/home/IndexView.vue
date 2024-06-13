<script>
export default {
    data() {
        return {
            testResult: {}
        }
    },
    computed: {
        formData() {
            let formData = new FormData();

            formData.append("key", "value");

            return formData;
        },
    },
    mounted() {
        this.getTestApi()
    },
    methods: {
        getTestApi() {
            this.$store.dispatch("postData", ["test", this.formData])
                .then((response) => {
                    this.testResult = response
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
}
</script>

<template>
    <h1>
        Ini Halaman Home
    </h1>

    <p>Result API : {{ testResult }}</p>
</template>
