<template>
    <div>
        <div class="row" style="margin: 10px;">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="elevation-2" style="background-color: white;">
                    <div style="padding: 0px;">
                        <table class="table table-striped borderless">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>FOTO</th>
                                <th>USERNAME</th>
                                <th>NOMOR HP</th>
                                <th>AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(technician, index) in technicians">
                                <td>
                                    {{ index + 1 }}
                                </td>
                                <td>
                                    {{ technician.name }}
                                </td>
                                <td>
                                    <img v-if="technician.biodata !== undefined" width="50" height="50" :src="technician.biodata.profile_picture" alt="technicians">
                                </td>
                                <td>
                                    {{ technician.username }}
                                </td>
                                <td>
                                    {{ technician.biodata === undefined ? '' : technician.biodata.nomor_hp === null ? "-" : technician.biodata.nomor_hp }}
                                </td>
                                <td>
                                    <button @click="moveTo('/technician/' + technician.username)" class="button-warning-primary-tag">
                                        Lihat
                                    </button>
                                    <transition name="technician-delete-container-transition">
                                        <button v-on:click="openDeleteModal(technician.id, technician, index)" v-if="onDeleteMode" style="margin-left: 4px;" class="button-danger-primary-tag">
                                            Hapus
                                        </button>
                                    </transition>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <delete-modal @onAnimationEnd="onDeleteModalAnimationEnd" :technician="data.technician" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";

export default {
    name: "ListView",
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

.table-striped > tbody > tr {
    margin-top: 20px;
    margin-bottom: 20px;
}

table > tbody > tr > td {
    padding-bottom: 20px;
    padding-top: 20px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
    color: #6c757d;
}

table > tbody > tr > td:first-child, table > thead > tr > th:first-child {
    padding-left: 20px;
}

table > tbody > tr > td:first-child > a, table > tbody > tr > td:nth-child(3) > a {
    color: #5179d6;
    text-decoration: none;
}

table > thead > tr > th {
    padding-bottom: 10px;
    padding-top: 10px;
    color: #000;
    letter-spacing: 1px;
    line-height: 25px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f1f4f5;
}

.table-striped > tbody > tr:nth-of-type(even) {
    background-color: #fff;
}
</style>
