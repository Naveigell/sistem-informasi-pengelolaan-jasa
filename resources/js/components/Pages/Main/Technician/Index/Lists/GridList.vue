<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="product-grid-container">
                    <div class="product-grid" v-for="(technician, index) in technicians" v-if="technicians.length > 0">
                        <a v-bind:href="'/technician/' + technician.username" style="text-decoration: none;">
                            <img v-if="technician.biodata !== undefined" width="100%" height="170" :src="technician.biodata.profile_picture" alt="technicians">
                            <hr/>
                            <span class="product-title">
                                {{ technician.name }}
                            </span>
                            <div class="product-info">
                                <span class="product-price">
                                    {{ technician.username }}
                                </span>
                                <span class="product-stock">
                                    {{ technician.biodata === undefined ? '' : technician.biodata.nomor_hp === null ? "-" : technician.biodata.nomor_hp }}
                                </span>
                            </div>
                            <div class="product-meta">
                                <span class="product-type">
                                    <i class="fas fa-box"></i> Teknisi
                                </span>
                            </div>
                            <br/>
                        </a>
                        <transition name="product-delete-container-transition">
                            <div key="delete" class="product-delete-container" v-if="onDeleteMode">
                                <span v-on:click="openDeleteModal(technician.id, technician, index)">
                                    <i class="fa fa-trash"></i> Hapus
                                </span>
                            </div>
                        </transition>
                    </div>
                    <delete-modal @onAnimationEnd="onDeleteModalAnimationEnd" @response="onDeleteModalResponse" :technician="data.technician" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
                    <toast @toastEnded="toast.open = false" v-if="toast.open" :icon="toast.data.icon" :background="toast.background" :title="toast.data.title" :timer="2000" :subtitle="toast.data.message"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";
import Toast from "../../../../../Toasts/TopRightToast";

export default {
    name: "GridList",
    props: ["technicians", "onDeleteMode"],
    components: {
        "delete-modal": Delete,
        "toast": Toast
    },
    data() {
        return {
            data: {
                id: -1,
                technician: null,
                index: -1
            },
            modal: {
                delete: false
            },
            toast: {
                open: false,
                background: this.$colors.bluePrimary,
                data: {
                    title: "Success!",
                    message: "Just sample message",
                    icon: "fa fa-check"
                }
            }
        }
    },
    mounted() {

    },
    methods: {
        openDeleteModal(id, technician, index){
            this.data.id = id;
            this.data.technician = technician;
            this.data.index = index;
            this.modal.delete = true;
        },
        onDeleteModalResponse(obj){
            this.toast.data.message = obj.message;

            if (obj.type === "failed") {
                this.toast.data.title = "Failed!";
                this.toast.data.icon = "fa fa-times-circle";
                this.toast.background = this.$colors.redPrimary;
            } else if (obj.type === "success") {
                this.toast.background = this.$colors.successPrimary;
            }

            this.toast.open = true;
        },
        onDeleteModalAnimationEnd(){
            const self = this;
            const id = setTimeout(function () {
                self.technicians.splice(self.data.index, 1);
                clearTimeout(id);
            }, 800);
        }
    }
}
</script>

<style scoped>
.product-delete-container-transition-enter-active {
    transition: all .3s ease;
    -o-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -webkit-transition: all .3s ease;
}

.product-delete-container-transition-leave-active {
    transition: all .1s ease;
    -o-transition: all .1s ease;
    -moz-transition: all .1s ease;
    -webkit-transition: all .1s ease;
}

.product-delete-container-transition-enter, .product-delete-container-transition-leave-to {
    opacity: 0;
}

.delete-transition-ended-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.delete-transition-ended-leave {
    opacity: 1;
}

.delete-transition-ended-leave-to {
    opacity: 0;
}

.product-delete-container {
    border-top: 1px solid #dedede;
    width: 184px;
    background: white;
    color: var(--red-primary);
}

.product-delete-container > span {
    display: block;
    text-align: center;
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.product-delete-container > span > i {
    font-size: 16px;
    padding-right: 4px;
}

.grid-container {
    width: 100%;
    height: 100%;
}

.grid {
    padding: 20px;
    margin: 20px;
}

.product-info {
    margin-top: 8px;
    margin-right: 10px;
    margin-left: 10px;
}

.product-type {
    float: right;
    font-size: 12px;
    margin-right: 10px;
    color: #a4a4a4;
}

.product-price {
    color: var(--blue-primary);
    font-size: 15px;
}

.product-stock {
    margin-top: 5px;
    display: block;
    color: #a4a4a4;
}

.product-meta {
    padding-bottom: 7px;
}

.product-grid-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.product-title {
    margin-left: 10px;
    margin-right: 10px;
    margin-top: 1em;
    color: #222;
    display: block;
    display: -webkit-box;
    max-width: 100%;
    height: 32px;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.15;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-grid:hover {
    /*height: 340px;*/
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.product-grid:hover .product-delete-container {
    display: block;
}

.product-grid {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    display: inline-block;
    width: 186px;
    height: calc(100% + 30px);
    position: relative;
    margin: 5px 5px 12px;
    flex-grow: 0;
    flex-shrink: 1;
    text-decoration: none;
    /*flex-basis: calc(20% - 5px);*/
}

.product-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

hr {
    margin: 0;
}
</style>
