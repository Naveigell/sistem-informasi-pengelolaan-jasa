<template>
    <div>
        <full-loading v-if="loading.fullLoading"/>
        <error-404-not-found v-if="!hasLoggedIn"/>
        <spare-part v-bind:id="id" v-else/>
    </div>
</template>

<script>
import Errors404 from "../../Errors/Errors404";
import Sparepart from "../../Pages/Main/Sparepart/Update/Sparepart";

export default {
    name: "Update",
    props: ["id"],
    components: {
        "error-404-not-found": Errors404,
        "spare-part": Sparepart
    },
    data() {
        return {
            loading: {
                fullLoading: true
            },
            hasLoggedIn: false
        }
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
