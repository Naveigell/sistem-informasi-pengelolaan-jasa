<template>
    <div class="">
        <login-component v-if="!hasLoggedIn"/>
        <dashboard-component v-else/>
        <full-loading v-if="loading.fullLoading"/>
    </div>
</template>

<script>
    import LoginComponent from "./Pages/Login/LoginComponent";
    import Dashboard from "./Pages/Main/Dashboard/Dashboard"
    import FullLoading from "./Loaders/FullLoading";

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

            this.$root.$on('event-login', function (args) {
                self.hasLoggedIn = args;
            });

            this.$api.get(this.$endpoints.auth.check).then(function (response) {
                if (response.status === 200) {
                    self.hasLoggedIn = response.data.body.loggedin;
                    self.loading.fullLoading = false;
                }
            }).catch(function (error) {
                console.log(error)
            })
        },
        components: {
            'login-component': LoginComponent,
            'dashboard-component': Dashboard,
            'full-loading': FullLoading
        },
    }
</script>
