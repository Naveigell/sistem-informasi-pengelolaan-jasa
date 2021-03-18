<template>
    <div class="application">
        <full-loading v-if="loading.fullLoading"/>
        <error-404 v-else-if="!loading.fullLoading && routes.notFound"/>
        <div v-else>
            <login v-if="!hasLoggedIn"/>
            <div v-else>
                <app-header/>
                <app-sidebar/>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import LoginComponent from "../Pages/Login/LoginComponent";
import FullLoading from "../Loaders/FullLoading";
import Errors404 from "../Errors/Errors404";

export default {
    name: "Layout",
    components: {
        "full-loading": FullLoading,
        "login": LoginComponent,
        "error-404": Errors404
    },
    props: {
        el: {
            type: [String, Object],
            default: 'div',
        },
        id: {
            type: [String, Number],
            default: null
        },
        username: {
            type: [String, String],
            default: null
        }
    },
    data() {
        return {
            loading: {
                fullLoading: true
            },
            hasLoggedIn: false,
            routes: {
                notFound: false
            }
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
    },
    watch: {
        async '$route' (to, from) {
            this.resolve(to);

            // UNCOMMENT IT LATER
            // UNCOMMENT IT LATER

            this.loading.fullLoading = true;
            this.hasLoggedIn = false;
            await this.$store.commit('retrieveUserData');
        },
    },
    methods: {
        resolve(route){
            this.routes.notFound = route.name === "notfound";
        }
    }
}
</script>

<style scoped>
</style>
