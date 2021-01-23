<template>
    <div>
        <div class="list-container">
            <list @updateList="updateList" @error="createToast" :list="list" :key="list.id_jasa" v-for="(list, index) in lists" :id="list.id_jasa" :index="index"/>
        </div>
        <toast @toastEnded="toast.open = false" v-if="toast.open" :background="toast.background" :title="toast.data.title" :subtitle="toast.data.message" :icon="toast.data.icon" :timer="1200"/>
    </div>
</template>

<script>
import List from "./List";
import FullOverlay from "../../../../../Overlays/FullOverlay";
import TopRightToast from "../../../../../Toasts/TopRightToast";

export default {
    name: "ListView",
    components: {
        "list": List,
        "overlay": FullOverlay,
        "toast": TopRightToast
    },
    data () {
        return {
            lists: [],
            toast: {
                open: false,
                background: this.$colors.bluePrimary,
                data: {
                    title: "Success!",
                    message: "Message",
                    icon: "fa fa-check"
                }
            }
        }
    },
    mounted() {
        this.retrieveAll();
        this.$root.$on("jasaInserted", (data) => {
            this.lists.push(data);
            this.updateJasaCount();
        });

        this.$root.$on("jasaDeleted", (data) => {
            this.lists.splice(data.index, 1);
            this.updateJasaCount();
            this.createToast({
                title: "Success!",
                message: "Hapus jasa berhasil",
                icon: "fa fa-check",
                background: this.$colors.successPrimary
            });
        });

        this.$root.$on("openToast", (data) => {
            this.createToast(data);
        })
    },
    methods: {
        retrieveAll(){
            const self = this;
            this.$api.get(this.$endpoints.service.data).then(function (response) {
                self.lists = response.data.body.service;
                self.updateJasaCount();
            }).catch(function (error) {
                console.log(error);
            })
        },
        createToast({title, message, icon, background}){
            this.toast.background = background;
            this.toast.data.title = title;
            this.toast.data.message = message;
            this.toast.data.icon = icon;
            this.toast.open = true;
        },
        updateList(obj){
            this.$set(this.lists, obj.index, obj.data);
            this.updateJasaCount();
        },
        updateJasaCount(){
            const activeListCount = this.lists.map(item => item.aktif).reduce(function (prev, next) {
                return prev + next;
            });
            this.$emit("updateListCount", activeListCount);
        },
    }
}
</script>

<style scoped>
</style>
