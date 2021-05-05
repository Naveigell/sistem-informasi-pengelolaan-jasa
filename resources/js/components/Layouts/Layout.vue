<template>
    <div class="application">
        <full-loading v-if="loading.fullLoading"/>
        <error-404 v-else-if="!loading.fullLoading && routes.notFound"/>
        <error-403 v-else-if="!loading.fullLoading && routes.unauthorized"/>
        <div v-else>
            <login v-if="!hasLoggedIn"/>
            <div v-else>
                <toast @toastEnded="toast.open = false" v-if="toast.open" :icon="toast.data.icon" :background="toast.background" :title="toast.data.title" :timer="2000" :subtitle="toast.data.message"/>
                <app-header v-if="!fullScreen"/>
                <app-sidebar v-if="!fullScreen"/>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import LoginComponent from "../Pages/Login/LoginComponent";
import FullLoading from "../Loaders/FullLoading";
import Errors404 from "../Errors/Errors404";
import Errors403 from "../Errors/Errors403";
import TopRightToast from "../Toasts/TopRightToast";

export default {
    name: "Layout",
    components: {
        "full-loading": FullLoading,
        "login": LoginComponent,
        "error-404": Errors404,
        "error-403": Errors403,
        "toast": TopRightToast
    },
    data() {
        return {
            loading: {
                fullLoading: true
            },
            hasLoggedIn: false,
            routes: {
                notFound: false,
                unauthorized: false
            },
            toast: {
                open: false,
                background: this.$colors.successPrimary,
                data: {
                    title: "",
                    message: "",
                    icon: ""
                }
            },
            fullScreen: false
        }
    },
    mounted() {
        this.$store.watch((state) => {
            if (state.user.check) {
                this.loading.fullLoading = false;
                this.hasLoggedIn = state.user.data !== null;
                if (state.user.data !== null) {
                    this.$role.setRole(state.user.data.role);
                    this.checkAuthorization();
                } else if (this.$router.currentRoute.path !== "/") {
                    this.routes.unauthorized = true;
                }
            }
        });

        this.$root.$on('open-toast', (data) => {
            this.toast.open = true;
            this.toast.background = data.background;
            this.toast.data = data.data;
        });

        this.$root.$on('reload-page', () => {
            this.reload();
        });
        this.reload();
    },
    watch: {
        async '$route' (to, from) {
            this.resolve(to);

            this.wantsFullScreen();

            this.loading.fullLoading = true;
            this.hasLoggedIn = false;
            await this.$store.commit('retrieveUserData');
        },
    },
    methods: {
        async reload(){
            this.loading.fullLoading = true;
            this.hasLoggedIn =
            this.routes.notFound =
            this.routes.unauthorized = false;

            await this.$store.commit('retrieveUserData');

            this.resolve(this.$router.currentRoute);
            this.wantsFullScreen();
        },
        checkAuthorization(){
            this.routes.unauthorized = !this.$router.currentRoute.meta.roles.includes(this.$store.state.user.data.role);
        },
        resolve(route){
            this.routes.notFound = route.name === "notfound";
        },
        wantsFullScreen(){
            this.fullScreen =   (this.$router.currentRoute.meta.fullscreen !== undefined &&
                                this.$router.currentRoute.meta.fullscreen);
        }
    }
}
</script>

<style scoped>
</style>
