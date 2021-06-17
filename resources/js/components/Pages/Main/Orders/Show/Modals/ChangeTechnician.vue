<template>
    <div>
        <div class="modal-search-container">
            <div class="search-container">
                <div style="background-color: #f6f7f8; height: 43px; font-family: InterRegular, Arial, sans-serif;">
                    <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px; font-size: 16px;">CARI TEKNISI</h5>
                        <span @click="closeModal" style="display: inline-block; cursor: pointer;">
                            <i class="fa fa-times" style="font-size: 26px; color: #ff2b5d;"></i>
                        </span>
                    </div>
                </div>
                <div>
                    <form style="display: block; margin: 20px;" action="" v-on:submit.prevent>
                        <div style="background-color: #edf7f8; padding: 7px 10px; border-radius: 3px; position: relative;">
                            <input @keyup.enter="find" v-model="search.query" class="search-input" type="text" style="border: none; display: block; width: 100%; padding-right: 24px; background-color: transparent; outline: none;" placeholder="Masukkan nama teknisi ...">
                            <div style="display: inline-block; position: absolute; right: 9px; top: 8px;">
                                <span>
                                    <i class="fa fa-search" style="font-size: 18px;"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                    <div style="padding: 0 20px 20px 20px; overflow-y: hidden; height: 75vh;">
                        <table class="table table-striped borderless" style="overflow-y: hidden; height: 100px;">
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>USERNAME</th>
                                <th>AKSI</th>
                            </tr>
                            <tr v-for="(technician, index) in technicians">
                                <td>{{ index + 1 }}</td>
                                <td>{{ technician.name }}</td>
                                <td>{{ technician.username }}</td>
                                <td>
                                    <button @click="change(technician)" class="button-success-primary-tag">Ganti</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <full-overlay @clicked="closeModal()"/>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "ChangeTechnician",
    props: ["id"],
    components: {
        "full-overlay": FullOverlay
    },
    data(){
        return {
            technicians: [],
            search: {
                query: "",
            }
        }
    },
    methods: {
        closeModal(){
            document.body.style.overflow = "visible";
            this.$emit("close");
        },
        find(){
            const params = {
                q: this.search.query
            }

            this.$api.get(this.$endpoints.technicians.search, { params }).then((response) => {
                const username = this.$store.state.user.data.username;

                this.technicians = response.data.body.technicians;
                this.technicians = this.technicians.filter((item) => {
                    return item.username !== username;
                });
            }).catch((error) => {
                console.error(error);
            });
        },
        change(technician){
            const url = this.$url.generateUrl(this.$endpoints.orders.change_technician);
            this.$api.post(url(this.id), {
                technician_id: technician.id
            }).then((response) => {
                this.closeModal();
                this.$emit("response");
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Pemindahan teknisi berhasil",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>
.modal-search-container {
    position: fixed;
    z-index: 35;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-container {
    height: 95%;
    width: 80%;
    background: white;
    position: relative;
    z-index: 21;
}

.borderless td, .borderless th {
    border: none;
}

.table-striped > tr {
    margin-top: 20px;
    margin-bottom: 20px;
}

table > tr > td {
    padding-bottom: 20px;
    padding-top: 20px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
    color: #6c757d;
}

table > tr > td:first-child, table > tr > th:first-child {
    padding-left: 20px;
}

table > tr > td:first-child, table > tr > td:nth-child(3) > a {
    color: #5179d6;
    text-decoration: none;
}

table > tr > th {
    padding-bottom: 10px;
    padding-top: 10px;
    color: #000;
    letter-spacing: 1px;
    line-height: 25px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
}

.table-striped > tr:nth-of-type(odd) {
    background-color: #f1f4f5;
}

.table-striped > tr:nth-of-type(even) {
    background-color: #fff;
}
</style>
