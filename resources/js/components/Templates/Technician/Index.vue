<template>
    <div>
        <full-loading v-if="loading.fullLoading"/>
        <error-404-not-found v-if="!hasLoggedIn"/>
        <technician v-else/>
    </div>
</template>

<script>
import Errors404 from "../../Errors/Errors404";
import Technician from "../../Pages/Main/Technician/Index/Technician";

export default {
    name: "Index",
    components: {
        "error-404-not-found": Errors404,
        "technician": Technician
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
        this.$store.watch((state) => {
            if (state.user.check) {
                this.loading.fullLoading = false;
                this.hasLoggedIn = state.user.data !== null;
            }
        });
    }
}
</script>

<style scoped>

</style>
