<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="technician-grid-container">
                    <div class="technician-grid" v-for="(technician, index) in technicians" v-if="technicians.length > 0">
                        <router-link :to="{ path: '/technician/' + technician.username }" style="text-decoration: none;">
                            <img v-if="technician.biodata !== undefined" width="100%" height="170" :src="technician.biodata.profile_picture" alt="technicians">
                            <hr/>
                            <span class="technician-title">
                                {{ technician.name }}
                            </span>
                            <div class="technician-info">
                                <span class="technician-price">
                                    {{ technician.username }}
                                </span>
                                <span class="technician-stock">
                                    {{ technician.biodata === undefined ? '' : technician.biodata.nomor_hp === null ? "-" : technician.biodata.nomor_hp }}
                                </span>
                            </div>
                            <div class="technician-meta">
                                <span class="technician-type">
                                    <i class="fas fa-box"></i> Teknisi
                                </span>
                            </div>
                            <br/>
                        </router-link>
                        <transition name="technician-delete-container-transition">
                            <div key="delete" class="technician-delete-container" v-if="onDeleteMode">
                                <span v-on:click="openDeleteModal(technician.id, technician, index)">
                                    <i class="fa fa-trash"></i> Hapus
                                </span>
                            </div>
                        </transition>
                    </div>
                    <delete-modal @onAnimationEnd="onDeleteModalAnimationEnd" :technician="data.technician" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";

export default {
    name: "GridList",
    props: ["technicians", "onDeleteMode"],
    components: {
        "delete-modal": Delete,
    },
    data() {
        return {
            data: {
                id: -1,
                user: null,
                index: -1
            },
            modal: {
                delete: false
            },
        }
    },
    methods: {
        openDeleteModal(id, technician, index){
            this.data.id = id;
            this.data.technician = technician;
            this.data.index = index;
            this.modal.delete = true;
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
.technician-delete-container-transition-enter-active {
    transition: all .3s ease;
    -o-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -webkit-transition: all .3s ease;
}

.technician-delete-container-transition-leave-active {
    transition: all .1s ease;
    -o-transition: all .1s ease;
    -moz-transition: all .1s ease;
    -webkit-transition: all .1s ease;
}

.technician-delete-container-transition-enter, .technician-delete-container-transition-leave-to {
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

.technician-delete-container {
    border-top: 1px solid #dedede;
    width: 184px;
    background: white;
    color: var(--red-primary);
}

.technician-delete-container > span {
    display: block;
    text-align: center;
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.technician-delete-container > span > i {
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

.technician-info {
    margin-top: 8px;
    margin-right: 10px;
    margin-left: 10px;
}

.technician-type {
    float: right;
    font-size: 12px;
    margin-right: 10px;
    color: #a4a4a4;
}

.technician-price {
    color: var(--blue-primary);
    font-size: 15px;
}

.technician-stock {
    margin-top: 5px;
    display: block;
    color: #a4a4a4;
}

.technician-meta {
    padding-bottom: 7px;
}

.technician-grid-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.technician-title {
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

.technician-grid:hover {
    /*height: 340px;*/
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.technician-grid:hover .technician-delete-container {
    display: block;
}

.technician-grid {
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

.technician-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

hr {
    margin: 0;
}
</style>
