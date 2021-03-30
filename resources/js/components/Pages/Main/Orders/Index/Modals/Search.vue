<template>
    <div>
        <div class="modal-search-container">
            <div class="search-container">
                <div style="background-color: #f6f7f8; height: 43px; font-family: InterRegular, Arial, sans-serif;">
                    <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <h5 @click="users.push(1)" style="font-weight: 500; letter-spacing: 1px; line-height: 25px; font-size: 16px;">CARI PENGGUNA</h5>
                        <span @click="closeModal" style="display: inline-block; cursor: pointer;">
                            <i class="fa fa-times" style="font-size: 26px; color: #ff2b5d;"></i>
                        </span>
                    </div>
                </div>
                <div>
                    <form style="display: block; margin: 20px; background-color: #edf7f8; padding: 7px 10px; border-radius: 3px; position: relative;" action="" v-on:submit.prevent>
                        <div>
                            <input @keyup.enter="find" v-model="search.query" class="search-input" type="text" style="border: none; display: block; width: 100%; padding-right: 24px; background-color: transparent; outline: none;" placeholder="Cari Email ...">
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
                                <th>EMAIL</th>
                                <th>AKSI</th>
                            </tr>
                            <tr v-for="(user, index) in users">
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <button @click="chooseUser(index)" class="button-success-primary-sm">Pilih</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <full-overlay @clicked="find()"/>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "Search",
    components: {
        "full-overlay": FullOverlay
    },
    data(){
        return {
            users: [],
            search: {
                query: ""
            }
        }
    },
    methods: {
        find(){
            const params = {
                query: this.search.query
            }

            this.$api.get(this.$endpoints.users.search_email, { params }).then((response) => {
                this.users = response.data.body.users;
            }).catch((error) => {
                console.error(error);
            });
        },
        closeModal(){
            document.body.style.overflow = "visible";
            this.$emit("close");
        },
        chooseUser(index) {
            this.$emit("user", {
                user: this.users[index]
            });
            this.closeModal();
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
