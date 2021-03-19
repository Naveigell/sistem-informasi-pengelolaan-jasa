<template>
    <div class="app-container">
        <div class="service-container">
            <div class="top-navigation">
                <ul>
                    <li class="router-active">Semua</li>
                </ul>
            </div>
            <div class="service-list-container">
                <div class="service-container-tools">
                    <div class="service-list-left">
                        <h4>{{ listCount }} Jasa Aktif</h4>
                    </div>
                    <div class="service-list-right">
                        <button @click="modal.insert.open = true;" class="button-add button-success-primary-md" style="padding: 10px 20px;">
                            <i class="fa fa-plus"></i>&nbsp Tambah Jasa
                        </button>
                    </div>
                </div>
                <div class="service-list">
                    <list-view @updateListCount="updateListCount"/>
                </div>
            </div>
        </div>
        <Insert v-if="modal.insert.open" @onAnimationEnd="closeModal(modal.insert)" @response="openToast"/>
    </div>
</template>

<script>
import ListView from "./Lists/ListView";
import Insert from "./Modals/Insert";

export default {
    name: "Body",
    components: {
        "list-view": ListView,
        Insert
    },
    data(){
        return {
            listCount: 0,
            modal: {
                insert: {
                    open: false
                },
            },
        }
    },
    methods: {
        updateListCount(count) {
            this.listCount = count;
        },
        closeModal(modal) {
            modal.open = false;
        },
        openToast(obj){
            this.$root.$emit("open-toast", {
                type: obj.type,
                background: obj.type === "failed" ? this.$colors.redPrimary : this.$colors.successPrimary,
                data: {
                    title: obj.type === "failed" ? "Failed!" : "Success!",
                    message: obj.message,
                    icon: obj.type === "failed" ? "fa fa-times-circle" : "fa fa-check"
                }
            });
        }
    }
}
</script>

<style scoped>
.service-list-container {
    padding: 20px;
}

.service-list {
    margin-top: 40px;
}

.service-container-tools {
    display: flex;
    align-items: center;
    /*background: red;*/
    justify-content: space-between;
}

.service-container {
    background: white;
    border: 1px solid #e5e5e5;
    margin-bottom: 20px;
}

.top-navigation {
    height: 60px;
    border-bottom: 1px solid #d4d4d4;
    display: flex;
    justify-content: flex-start;
}

.top-navigation ul {
    display: flex;
    flex-direction: row;
    height: 100%;
    margin: 0 0 0 10px;
    padding: 0;
}

.top-navigation ul li {
    display: flex;
    cursor: pointer;
    justify-content: center;
    align-items: center;
    bottom: 0;
    border-bottom: 4px solid white;
    list-style: none;
    position: relative;
    padding: 20px 22px 16px 22px;
    height: 100%;
    margin: 0;
}

.top-navigation ul li:hover {
    color: var(--blue-primary);
    transition: .3s;
    -o-transition: .3s;
    -moz-transition: .3s;
    -webkit-transition: .3s;
}

.top-navigation ul .router-active {
    border-bottom: 4px solid var(--blue-primary);
    color: var(--blue-primary);
    font-weight: bold;
}

h4 {
    color: #222;
    font-weight: bold;
    font-size: 22px;
    display: inline-block;
}
</style>
