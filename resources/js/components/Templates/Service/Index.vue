<template>
    <div>
        <full-loading v-if="loading.fullLoading"/>
        <error-404-not-found v-if="!hasLoggedIn"/>
        <service v-else/>
    </div>
</template>

<script>
import Errors404 from "../../Errors/Errors404";
import Service from "../../Pages/Main/Service/Index/Service";

export default {
    name: "Index",
    components: {
        "error-404-not-found": Errors404,
        "service": Service
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
