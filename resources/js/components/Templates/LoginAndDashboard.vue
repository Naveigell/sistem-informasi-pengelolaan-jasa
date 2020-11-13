<template>
    <div class="">
        <login-component v-if="!hasLoggedIn"/>
        <dashboard-component v-else/>
        <full-loading v-if="loading.fullLoading"/>
    </div>
</template>

<script>
    import LoginComponent from "../Pages/Login/LoginComponent";
    import Dashboard from "../Pages/Main/Dashboard/Dashboard"

    export default {
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

        },
        methods: {

        },
        components: {
            'login-component': LoginComponent,
            'dashboard-component': Dashboard,
        },
    }
</script>
