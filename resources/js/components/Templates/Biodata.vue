<template>
    <div>
        <full-loading v-if="loading.fullLoading"/>
        <error-404-not-found v-if="!hasLoggedIn"/>
        <biodata-component v-else/>
    </div>
</template>

<script>
import BiodataComponent from "../Pages/Main/Biodata/Biodata";
import Errors404 from "../Errors/Errors404";

export default {
    name: "Biodata",
    components: {
        "biodata-component": BiodataComponent,
        "error-404-not-found": Errors404
    },
    data(){
        return {
            hasLoggedIn: false,
            loading: {
                fullLoading: true
            }
        };
    },
    mounted() {
        const self = this;
        this.$store.watch(function (state) {
            if (state.user.check) {
                self.loading.fullLoading = false;
                self.hasLoggedIn = state.user.data !== null;
            }
        });
    }
}
</script>

<style scoped>

</style>
