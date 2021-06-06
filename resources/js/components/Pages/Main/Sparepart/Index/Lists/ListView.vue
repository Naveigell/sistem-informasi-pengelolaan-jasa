<template>
    <div>
        <div class="row" style="margin: 10px;">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="elevation-2" style="background-color: white;">
<!--                    <div style="background-color: #f6f7f8; height: 43px;">-->
<!--                        <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">-->
<!--                            <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">LIST SPARE PART</h5>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div style="padding: 0px;">
                        <table class="table table-striped borderless">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>GAMBAR</th>
                                <th>HARGA</th>
                                <th>TIPE</th>
                                <th>STOK</th>
                                <th>AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(sparepart, index) in spareparts">
                                <td>
                                    {{ index + 1 }}
                                </td>
                                <td>
                                    {{ sparepart.nama }}
                                </td>
                                <td>
                                    <img width="50" height="50" :src="sparepart.images[0].picture" alt="sparepart">
                                </td>
                                <td>
                                    Rp{{ $currency.indonesian(sparepart.harga) }}
                                </td>
                                <td>
                                    {{ sparepart.tipe }}
                                </td>
                                <td>
                                    {{ sparepart.stok }}
                                </td>
                                <td>
                                    <button @click="moveTo('/sparepart/' + sparepart.id)" class="button-warning-primary-tag">
                                        Lihat
                                    </button>
                                    <transition name="product-delete-container-transition">
                                        <button v-on:click="openDeleteModal(sparepart.id, sparepart, index)" v-if="onDeleteMode" style="margin-left: 4px;" class="button-danger-primary-tag">
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
        <Delete @onAnimationEnd="onDeleteModalAnimationEnd" :sparepart="data.sparepart" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";

export default {
    name: "ListView",
    components: {
        Delete
    },
    props: ["spareparts", "onDeleteMode"],
    data() {
        return {
            data: {
                id: -1,
                sparepart: null,
                index: -1
            },
            modal: {
                delete: false
            },
        }
    },
    methods: {
        openDeleteModal(id, sparepart, index){
            this.data.id = id;
            this.data.sparepart = sparepart;
            this.data.index = index;
            this.modal.delete = true;
        },
        onDeleteModalAnimationEnd(){
            const self = this;
            const id = setTimeout(function () {
                self.spareparts.splice(self.data.index, 1);
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
