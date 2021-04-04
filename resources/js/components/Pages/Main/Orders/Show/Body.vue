<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background: white;">
                        <div style="background-color: #f6f7f8; height: 43px; font-family: InterRegular, Arial, sans-serif;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px; font-size: 16px;">STATUS ORDER</h5>
                            </div>
                        </div>
                        <div style="height: 200px;">
                            <h4 style="font-weight: bold; margin: 50px;">Status Perbaikan</h4>
                            <div class="status-bar-indicator-container" style="">
                                <div v-for="(status, index) in statuses">
                                    <div v-if="index <= statuses.indexOf(data.status)" class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">
                                        <div style="background: #39b474DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-check" style="color: white; font-size: 20px;"></i>
                                        </div>
                                        <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">{{ createOrderStatusText(status) }}</span>
                                    </div>
                                    <div v-else class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">
                                        <div style="background: #808080DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-clock-o" style="color: white; font-size: 20px;"></i>
                                        </div>
                                        <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">{{ createOrderStatusText(status) }}</span>
                                    </div>
<!--                                    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                        <div style="background: #d40d0daa; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                            <i class="fa fa-times" style="color: white; font-size: 20px;"></i>-->
<!--                                        </div>-->
<!--                                        <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">{{ createOrderStatusText(status) }}</span>-->
<!--                                    </div>-->
                                </div>
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: #39b474DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                        <i class="fa fa-check" style="color: white; font-size: 20px;"></i>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Menunggu</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: #39b474DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                        <i class="fa fa-check" style="color: white; font-size: 20px;"></i>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Sedang Dicek</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: #39b474DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                        <i class="fa fa-check" style="color: white; font-size: 20px;"></i>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Dalam Perbaikan</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: white; border-radius: 30000px; height: 64px; width: 64px; display: flex; align-items: center; justify-content: center; border: 4px solid #39b474DD;">-->
<!--                                        <div style="background: #39b474DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                            <i class="fa fa-check" style="color: white; font-size: 20px;"></i>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Pembayaran</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: #d40d0daa; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                        <i class="fa fa-times" style="color: white; font-size: 20px;"></i>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Selesai</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="display: flex; justify-content: center; align-items: center; height: 120px; position: relative; flex-direction: column;">-->
<!--                                    <div style="background: #808080DD; border-radius: 30000px; padding: 20px; height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">-->
<!--                                        <i class="fa fa-clock-o" style="color: white; font-size: 20px;"></i>-->
<!--                                    </div>-->
<!--                                    <span style="display: inline-block; position: absolute; bottom: 0; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Diterima</span>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <div style="background: white; padding: 80px 50px 50px 50px;">
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
                                                    <input v-model="data.name" disabled maxlength="70">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>
                                                    * Email Pemilik
                                                </span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-model="data.email" disabled type="text" maxlength="70">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Alamat Pemilik</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <textarea v-model="data.address" disabled name="" cols="30" rows="10" style="resize: none"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>
                                                    * Sparepart yang diganti
                                                </span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <button @click="modals.sparepart.open = true;" class="button-success-primary-sm">Lihat</button>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Nama Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-model="data.device_name" disabled type="text" maxlength="70">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Keluhan Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <textarea v-model="data.device_problem" disabled name="" cols="30" rows="10" style="resize: none"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Tipe Perangkat</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <select v-model="data.device_type" disabled name="" id="">
                                                        <option value="pc">Pc/Komputer</option>
                                                        <option value="hp">Handphone</option>
                                                        <option value="printer">Printer</option>
                                                    </select>
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
                                                    <input v-model="data.device_brand" disabled type="text" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Teknisi</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input v-model="data.technician.name" disabled type="text" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10 right-column">
                                                <button @click="$router.back()" class="button-transparent-sm">Kembali</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <Sparepart :spareparts="data.spareparts" v-if="modals.sparepart.open" @close="modals.sparepart.open = false;"/>
        </div>
    </div>
</template>

<script>
import Sparepart from "./Modals/Sparepart";

export default {
    name: "Body",
    components: {
        Sparepart
    },
    data() {
        return {
            data: {
                name: "",
                email: "",
                address: "",
                technician: {
                    name: ""
                },
                spareparts: [],
                status: "menunggu",
                device_name: "",
                device_problem: "",
                device_type: "pc",
                device_brand: ""
            },
            modals: {
                sparepart: {
                    open: false
                }
            },
            statuses: [
                "menunggu", "dicek", "perbaikan", "selesai", "pembayaran", "terima"
            ]
        }
    },
    mounted() {
        this.retrieve()
    },
    methods: {
        retrieve(){
            const url = this.$url.generateUrl(this.$endpoints.orders.retrieve);
            this.$api.get(url(this.$router.currentRoute.params.unique_id)).then((response) => {
                this.data.name              = response.data.body.order.nama_pemilik;
                this.data.email             = response.data.body.order.user.email;
                this.data.address           = response.data.body.order.alamat;
                this.data.technician        = response.data.body.order.technician == null ? this.data.technician : response.data.body.order.technician;
                this.data.status            = response.data.body.order.status;
                this.data.spareparts        = response.data.body.order.spareparts;
                this.data.device_name       = response.data.body.order.nama_perangkat;
                this.data.device_problem    = response.data.body.order.keluhan;
                this.data.device_type       = response.data.body.order.jenis === "pc/komputer" ? "pc" : response.data.body.order.jenis;
                this.data.device_problem    = response.data.body.order.keluhan;
                this.data.device_brand      = response.data.body.order.merk;

                if (this.data.technician.name === "") {
                    this.data.technician.name = "-";
                }
                console.log(response)
            }).catch((error) => {
                console.error(error);
            })
        },
        createOrderStatusText(status){
            switch (status) {
                case "dicek":
                    return "Sedang Dicek";
                case "perbaikan":
                    return "Dalam Perbaikan";
            }

            return status.capitalize();
        },
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

.remove-image-overlay span {
    color: white;
}

.orders-information-container {
    /*margin-top: 60px;*/
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
