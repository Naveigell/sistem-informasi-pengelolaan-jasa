<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="elevation-2" style="background: white;">
                        <div style="background-color: #f6f7f8; height: 43px; font-family: InterRegular, Arial, sans-serif;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px; font-size: 16px;">TAMBAH ORDER</h5>
                            </div>
                        </div>
                        <div style="background: white; padding: 20px 50px 50px 50px;">
                            <form @submit.prevent>
                                <div class="orders-information-container">
                                    <h4 style="font-weight: bold;">Informasi Perangkat</h4>
                                    <div class="information-container">
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Nama Pemilik</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-bind:class="{'input-error': errors.name != null && errors.name !== undefined}" @focus="errors.name = null;" type="text" v-model="data.name" placeholder="Masukkan nama pemilik" maxlength="70">
                                                </div>
                                                <span class="error-message" v-if="errors.name != null && errors.name !== undefined">{{ errors.name[0] }}</span>
                                                <span class="word-count">{{ data.name.length }}/70</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>
                                                    * Email Pemilik
                                                    <br>
                                                    <span @click="modals.insert.open = true;" style="display: inline-block; float: right;">
                                                        <a style="text-decoration: underline; color: #0000EE; cursor: pointer;">Buat</a>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input @click="modals.search.open = true;" v-bind:class="{'input-error': errors.email != null && errors.email !== undefined}" @focus="errors.email = null;" type="text" v-model="data.email" placeholder="Masukkan email pemilik" maxlength="70">
                                                </div>
                                                <span class="error-message" v-if="errors.email != null && errors.email !== undefined">{{ errors.email[0] }}</span>
                                                <span class="word-count">{{ data.email.length }}/255</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Alamat Pemilik</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <textarea v-bind:class="{'input-error': errors.address != null && errors.address !== undefined}" @focus="errors.address = null;" placeholder="Alamat pemilik" v-model="data.address" name="" cols="30" rows="10" style="resize: none"></textarea>
                                                </div>
                                                <span class="error-message" v-if="errors.address != null && errors.address !== undefined">{{ errors.address[0] }}</span>
                                                <span class="word-count">{{ data.address.length }}/90</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Nama Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-bind:class="{'input-error': errors.device_name != null && errors.device_name !== undefined}" @focus="errors.device_name = null;" type="text" v-model="data.device_name" placeholder="Masukkan nama perangkat" maxlength="70">
                                                </div>
                                                <span class="error-message" v-if="errors.device_name != null && errors.device_name !== undefined">{{ errors.device_name[0] }}</span>
                                                <span class="word-count">{{ data.device_name.length }}/50</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Keluhan Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <textarea v-bind:class="{'input-error': errors.device_problem != null && errors.device_problem !== undefined}" @focus="errors.device_problem = null;" placeholder="Keluhan perangkat" v-model="data.device_problem" name="" cols="30" rows="10" style="resize: none"></textarea>
                                                </div>
                                                <span class="error-message" v-if="errors.device_problem != null && errors.device_problem !== undefined">{{ errors.device_problem[0] }}</span>
                                                <span class="word-count">{{ data.device_problem.length }}/3000</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Tipe Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <select v-bind:class="{'input-error': errors.device_type != null && errors.device_type !== undefined}" @focus="errors.device_type = null;" v-model="data.device_type" name="" id="">
                                                        <option value="pc">Pc/Komputer</option>
                                                        <option value="hp">Handphone</option>
                                                        <option value="printer">Printer</option>
                                                    </select>
                                                    <span class="error-message" v-if="errors.device_type != null && errors.device_type !== undefined">{{ errors.device_type[0] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Merek Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-bind:class="{'input-error': errors.device_brand != null && errors.device_brand !== undefined}" @focus="errors.device_brand = null;" type="text" v-model="data.device_brand" placeholder="Merek Perangkat" value="">
                                                    <span class="error-message" v-if="errors.device_brand != null && errors.device_brand !== undefined">{{ errors.device_brand[0] }}</span>
                                                    <span class="word-count">{{ data.device_brand.length }}/70</span>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10 right-column">
                                                <button class="button-transparent-sm">Batal</button>
                                                <button @click="create" class="button-success-primary-sm">Buat</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <search @user="fillForm" @close="modals.search.open = false;" v-if="modals.search.open"/>
        <create-user v-if="modals.insert.open" @onAnimationEnd="modals.insert.open = false;"/>
    </div>
</template>

<script>
import FullOverlay from "../../../../Overlays/FullOverlay";
import Search from "./Modals/Search";
import Insert from "../../User/Index/Modals/Insert";

export default {
    name: "Body",
    components: {
        "full-overlay": FullOverlay,
        "search": Search,
        "create-user": Insert
    },
    data(){
        return {
            data: {
                name: "",
                email: "",
                address: "",
                device_name: "",
                device_problem: "",
                device_type: "pc",
                device_brand: ""
            },
            errors: {
                name: null,
                email: null,
                address: null,
                device_name: null,
                device_problem: null,
                device_type: null,
                device_brand: null
            },
            modals: {
                search: {
                    open: false
                },
                insert: {
                    open: false
                }
            }
        }
    },
    watch: {
        "data.name": function (newVal, oldVal) {
            if (newVal.length > 70) {
                this.data.name = oldVal;
            }
        },
        "data.email": function (newVal, oldVal) {
            if (newVal.length > 255) {
                this.data.email = oldVal;
            }
        },
        "data.address": function (newVal, oldVal) {
            if (newVal.length > 90) {
                this.data.address = oldVal;
            }
        },
        "data.device_name": function (newVal, oldVal) {
            if (newVal.length > 50) {
                this.data.address = oldVal;
            }
        },
        "data.device_problem": function (newVal, oldVal) {
            if (newVal.length > 3000) {
                this.data.device_problem = oldVal;
            }
        },
        "data.device_type": function (newVal, oldVal) {
            const arr = ["pc", "hp", "printer"];
            if (!arr.includes(newVal)) {
                this.data.device_type = oldVal;
            }
        },
        "data.device_brand": function (newVal, oldVal) {
            if (newVal.length > 70) {
                this.data.device_brand = oldVal;
            }
        },
    },
    methods: {
        create(){
            this.$api.post(this.$endpoints.orders.insert, this.data).then((response) => {
                this.$router.push({
                    name: "orders"
                });

                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Order berhasil dibuat",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors.messages;
                } else if (Math.floor(error.response.status / 100) === 5) {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: "Order gagal dibuat, silakan buat ulang",
                            icon: "fa fa-times"
                        }
                    });
                }
            })
        },
        fillForm(data){
            this.data.name = data.user.name;
            this.data.email = data.user.email;
            this.data.address = data.user.biodata.alamat === null ? "" : data.user.biodata.alamat;
        }
    }
}
</script>

<style scoped>
img {
    width: 168px;
    height: 168px;
    border-radius: 4px;
    object-position: center;
}

.word-count {
    margin-top: 5px;
    display: inline-block;
    color: #999;
    float: right;
}

.error-message {
    margin-top: 5px;
    display: inline-block;
    color: var(--error-primary);
    opacity: 1;
}

.separator {
    height: 22px;
    width: 1px;
    background: #e0e0e0;
    display: inline-block;
    margin-left: 10px;
    opacity: .7;
}

.input-container-price {
    width: 100%;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    padding: 7px 7px 7px 12px;
    display: flex;
    align-items: center;
}

.input-container-price input {
    margin-left: 10px;
    width: 100%;
    font-size: 14px;
    outline: none;
    border: none;
}

.input-container input, .input-container textarea, .input-container select {
    width: 100%;
    font-size: 14px;
    outline: none;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    padding: 7px 7px 7px 9px;
}

.input-container .input-error, .input-error {
    border: 1px solid var(--error-primary);
}

.left-column {
    display: flex;
    align-items: self-start;
    justify-content: flex-end;
}

.left-column span {
    margin-top: 7px;
    white-space: nowrap;
}

.information-container {
    /*padding-left: 50px;*/
    /*padding-right: 50px;*/
    margin-top: 40px;
}

.layer {
    width: 168px;
    height: 168px;
    position: absolute;
    /*background: #0c0c0c;*/
    border-radius: 4px;
    opacity: 0;
}

.insert-overlay {
    width: 168px;
    height: 168px;
    opacity: 0.6;
    background: #222;
    position: absolute;
}

.remove-image-overlay span {
    color: white;
}

.remove-image-overlay {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    /*background: #242424;*/
}

.orders-information-container {
    /*margin-top: 60px;*/
}

.orders-body-container {
    background: white;
    border: 1px solid #e5e5e5;
    margin-bottom: 20px;
    padding: 30px;
}

.image-container {
    margin-top: 30px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-dashed {
    width: 170px;
    height: 170px;
    border: 1px dashed var(--blue-primary);
    border-radius: 4px;
    margin-left: 5px;
    margin-right: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fa-plus-circle {
    color: var(--blue-primary);
    font-size: 40px;
}

.fa-times-circle {
    font-size: 40px;
}

.image-fill {
    width: 170px;
    height: 170px;
    border: 1px solid #a4a4a4;
    border-radius: 4px;
    margin-left: 5px;
    margin-right: 5px;
    cursor: pointer;
}

.image-fill:hover .layer {
    opacity: 1;
    transition: 0.3s all;
    -o-transition: 0.3s all;
    -moz-transition: 0.3s all;
    -webkit-transition: 0.3s all;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
</style>
