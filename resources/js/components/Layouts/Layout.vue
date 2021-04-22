<template>
    <div class="application">
        <full-loading v-if="loading.fullLoading"/>
        <error-404 v-else-if="!loading.fullLoading && routes.notFound"/>
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
import TopRightToast from "../Toasts/TopRightToast";

export default {
    name: "Layout",
    components: {
        "full-loading": FullLoading,
        "login": LoginComponent,
        "error-404": Errors404,
        "toast": TopRightToast
    },
    data() {
        return {
            loading: {
                fullLoading: true
            },
            hasLoggedIn: false,
            routes: {
                notFound: false
            },
            toast: {
                open: false,
                background: this.$colors.successPrimary,
                data: {
                    title: "Success!",
                    message: "Tambah sparepart berhasil",
                    icon: "fa fa-check"
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
            }
        });
        this.resolve(this.$router.currentRoute);
        this.$root.$on('open-toast', (data) => {
            this.toast.open = true;
            this.toast.background = data.background;
            this.toast.data = data.data;
        });
        this.wantsFullScreen();
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
