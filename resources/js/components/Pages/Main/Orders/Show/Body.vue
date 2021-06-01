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
                            <div class="status-bar-indicator-container" style="position: relative; width: 100%;">
                                <div style="position: absolute; left: 0; right: 0;">
                                    <div v-for="(status, index) in statuses" style="background: red;">
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
                                            <button v-if="updateStatusAuthorized(status)" @click="updateStatusService(status)" class="button-transparent-tag" style="position: absolute; bottom: -40px;">Pilih</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="background: white; padding: 80px 50px 50px 50px;">
                            <form @submit.prevent>
                                <div class="orders-information-container">
                                    <h4 style="font-weight: bold;">Informasi Perangkat</h4>
                                    <br/>
                                    <div v-if="complaint.exists">
                                        <span class="status status-danger" v-if="complaint.data.dikerjakan_teknisi === 0" style="font-weight: bold; font-size: 16px;">Komplain</span>
                                        <span class="status status-info" v-else-if="complaint.data.dikerjakan_teknisi === 1 && complaint.data.disetujui_pelanggan === 0" style="font-weight: bold; font-size: 16px;">Komplain selesai dikerjakan</span>
                                        <span class="status status-success" v-else-if="complaint.data.disetujui_pelanggan === 1 && complaint.data.disetujui_admin === 0" style="font-weight: bold; font-size: 16px;">Komplain disetujui pelanggan</span>
                                    </div>
                                    <div class="information-container">
                                        <div class="row">
                                            <div class="col-md-2 left-column">
                                                <span>* Nama Pelanggan</span>
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
                                                    * Email Pelanggan
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
                                                <span>* Alamat Pelanggan</span>
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
                                                    <button v-if="$store.state.user.data.role !== 'teknisi'" @click="modals.show_sparepart.open = true;" class="button-success-primary-sm">Lihat</button>
                                                    <button :disabled="['selesai', 'terima'].includes(data.status)" v-else @click="['selesai', 'terima'].includes(data.status) ? modals.choose_sparepart.open = false : modals.choose_sparepart.open = true;" class="button-success-primary-sm">Tambah Sparepart</button>
                                                </div>
                                                <span v-if="$store.state.user.data.role === 'teknisi'" style="display: inline-block; margin-top: 10px; color: #999;">Sparepart hanya bisa diperbarui saat status service dibawah "SELESAI"</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div v-if="spareparts.length > 0 && $store.state.user.data.role === 'teknisi'">
                                            <div class="row">
                                                <div class="col-md-2 left-column"></div>
                                                <div class="col-md-10 right-column">
                                                    <table style="border-left: 1px solid #ebebeb; border-right: 1px solid #ebebeb;">
                                                        <thead>
                                                            <tr style="background-color: #fafafa;">
                                                                <th style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; color: #999; padding: 10px 80px; font-weight: normal; text-align: center;">Nama</th>
                                                                <th style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; color: #999; padding: 10px 80px; font-weight: normal;">Harga</th>
                                                                <th style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; color: #999; padding: 10px 60px; font-weight: normal;">Jumlah</th>
                                                                <th style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; color: #999; padding: 10px 40px; font-weight: normal;">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(sparepart, index) in spareparts">
                                                                <td style="max-width: 100px; text-overflow: ellipsis; overflow-x: hidden; border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; padding: 10px 20px; font-weight: normal;">{{ sparepart.nama }}</td>
                                                                <td style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; padding: 10px 80px; font-weight: normal;">Rp {{ $currency.indonesian(sparepart.harga) }}</td>
                                                                <td style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; padding: 10px 60px; font-weight: normal; position: relative;">
                                                                    <div class="input-container" v-if="$store.state.user.data.role === 'teknisi'">
                                                                        <input type="text" v-bind:disabled="['selesai', 'terima'].includes(data.status)" v-model="sparepart.jumlah">
                                                                    </div>
                                                                    <span v-else>x{{ sparepart.jumlah }}</span>
                                                                </td>
                                                                <td style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; border-left: 1px solid #ebebeb; padding: 10px 40px; font-weight: normal;"><i @click="['selesai', 'terima'].includes(data.status) ? null : spareparts.splice(index, 1)" class="fa fa-trash" style="color: #999; cursor: pointer;"></i></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-2 left-column"></div>
                                                <div class="col-md-10">
                                                    <button v-if="['dicek', 'perbaikan'].includes(data.status)" @click="saveSparepart" class="button-success-primary-sm">Simpan</button>
                                                </div>
                                            </div>
                                           <br/>
                                        </div>
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
                                        <div v-if="data.service !== null">
                                            <div class="row">
                                                <div class="col-md-2 left-column">
                                                    <span>* Jenis Jasa</span>
                                                </div>
                                                <div class="col-md-10 right-column">
                                                    <div style="width: 100%;">
                                                        <div class="col-lg-4 col-md-4 col-sm-4" style="display: inline-block; text-align: center; border-bottom: 1px solid #cfcfcf; border-top: 1px solid #cfcfcf; border-left: 1px solid #cfcfcf; padding: 15px 10px; font-weight: normal;">{{ data.service.name }}</div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4" style="display: inline-block; text-align: center; border-bottom: 1px solid #cfcfcf; border-top: 1px solid #cfcfcf; border-left: 1px solid #cfcfcf; padding: 15px 10px; font-weight: normal; position: relative;">
                                                            {{ data.service.tipe.capitalize() }}
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4" style="display: inline-block; text-align: center; border-bottom: 1px solid #cfcfcf; border-top: 1px solid #cfcfcf; border-left: 1px solid #cfcfcf; border-right: 1px solid #cfcfcf; padding: 15px 10px; font-weight: normal;">Rp {{ $currency.indonesian(data.service.biaya_jasa) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                        </div>
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
                                            <div class="col-md-2 left-column">
                                                <span>* Total Pembayaran</span>
                                            </div>
                                            <div class="col-md-10 right-column">
                                                <div class="input-container">
                                                    <input disabled type="text" v-model="totalPrices">
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="(/*!['selesai', 'terima'].includes(data.status) && */!this.$role.isUser) || (note.exists && this.$role.isUser)">
                                            <br/>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-2 left-column">
                                                        <span>
                                                            * {{ data.note !== null && this.$role.isUser ? '' : 'Buat' }} Catatan
                                                        </span>
                                                    </div>
                                                    <div class="col-md-10 right-column">
                                                        <div class="input-container">
                                                            <button v-if="!note.form.show" @click="note.form.show = true;" class="button-danger-sm">Buat</button>
                                                            <textarea v-model="note.text" :disabled="this.$role.isUser" @focus="note.errors.note = null" ref="complaint" v-bind:class="{'input-error': note.errors.note !== null && note.errors.note !== undefined}" v-else name="" cols="30" rows="10" placeholder="Tulis catatan disini" style="resize: none"></textarea>
                                                        </div>
                                                        <div v-if="note.form.show">
                                                            <span class="error-message" v-if="note.errors.note != null && note.errors.note !== undefined">{{ note.errors.note[0] }}</span>
                                                            <span class="word-count">{{ note.text.length }}/3000</span>
                                                        </div>
                                                        <div v-if="note.form.show && !this.$role.isUser">
                                                            <br/>
                                                            <div>
                                                                <button @click="updateNote()" class="button-success-primary-sm">Ubah</button>
                                                                <button v-if="data.note !== null" @click="deleteNote()" class="button-danger-sm">Hapus</button>
                                                                <button v-else @click="note.form.show = false;" class="button-transparent-sm">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div v-if="['selesai', 'terima'].includes(data.status)">
                                            <div class="row" v-if="$role.isUser || complaint.exists">
                                                <div class="col-md-2 left-column">
                                                    <span>
                                                        * {{ complaint.exists && !this.$role.isUser ? '' : 'Buat' }} Komplain
                                                        <span>
                                                            <br>
                                                            <router-link :to="{ path: '/complaints/' + complaint.data.id_pengaduan }" style="display: inline-block;">
                                                                <a style="color: #0000EE; cursor: pointer;">(Link komplain)</a>
                                                            </router-link>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="col-md-10 right-column" v-if="complaint.exists">
                                                    <div class="input-container">
                                                        <textarea v-model="complaint.data.isi" disabled name="" cols="30" rows="10" style="resize: none"></textarea>
                                                    </div>
                                                    <div v-if="complaint.data.dikerjakan_teknisi !== 1">
                                                        <span class="text-danger" style="font-size: 15px;">{{ $store.state.user.data.role === 'teknisi' ? "Mohon segera mengerjakan komplain" : "Komplain belum dikerjakan, mohon menunggu." }}</span>
                                                    </div>
                                                    <div v-if="complaint.data.disetujui_admin === 0 && complaint.data.dikerjakan_teknisi === 1 && complaint.data.disetujui_pelanggan === 1">
                                                        <span class="text-danger" style="font-size: 15px;">Menunggu persetujuan admin</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-10 right-column" v-else>
                                                    <div class="input-container">
                                                        <button v-if="!complaint.form.show" @click="complaint.form.show = true;" class="button-danger-sm">Buat</button>
                                                        <textarea v-model="complaint.text" @focus="complaint.errors.text = null" ref="complaint" v-bind:class="{'input-error': complaint.errors.text !== null && complaint.errors.text !== undefined}" v-else name="" cols="30" rows="10" placeholder="Tulis komplain disini" style="resize: none"></textarea>
                                                    </div>
                                                    <div v-if="complaint.form.show">
                                                        <span class="error-message" v-if="complaint.errors.text != null && complaint.errors.text !== undefined">{{ complaint.errors.text[0] }}</span>
                                                        <span class="word-count">{{ complaint.text.length }}/6000</span>
                                                    </div>
                                                    <div v-if="complaint.form.show">
                                                        <br/>
                                                        <div>
                                                            <button @click="sendComplaint" class="button-success-primary-sm">Kirim</button>
                                                            <button @click="complaint.form.show = false;" class="button-transparent-sm">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                        </div>
                                        <div class="row" v-if="!complaint.form.show">
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
            <ShowSparepart :spareparts="data.spareparts" v-if="modals.show_sparepart.open" @close="modals.show_sparepart.open = false;"/>
            <ChooseSparepart @sparepart="addSparepart" v-if="modals.choose_sparepart.open" @close="modals.choose_sparepart.open = false;"/>
        </div>
    </div>
</template>

<script>
import ShowSparepart from "./Modals/ShowSparepart";
import ChooseSparepart from "./Modals/ChooseSparepart";

export default {
    name: "Body",
    components: {
        ShowSparepart, ChooseSparepart
    },
    data() {
        return {
            data: {
                id: "",
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
                device_brand: "",
                total_price: 0,
                service: null,
                note: null
            },
            spareparts: [],
            modals: {
                show_sparepart: {
                    open: false
                },
                choose_sparepart: {
                    open: false
                }
            },
            statuses: [
                "menunggu", "dicek", "perbaikan", "selesai", "terima"
            ],
            complaint: {
                exists: false,
                form: {
                    show: false
                },
                data: {},
                errors: {},
                text: ""
            },
            note: {
                exists: false,
                form: {
                    show: false,
                },
                data: {},
                errors: {},
                text: ""
            }
        }
    },
    watch: {
        "complaint.text": function (newVal, oldVal) {
            if (newVal.length > 3000) {
                this.complaint.text = oldVal;
            }
        },
        "note.text": function (newVal, oldVal) {
            if (newVal.length > 6000) {
                this.note.text = oldVal;
            }
        }
    },
    computed: {
        totalPrices: {
            get(){
                switch (this.data.status) {
                    case "selesai":
                    case "terima":
                        return `Rp. ${this.$currency.indonesian(this.data.total_price + (this.data.service === null ? 0 : this.data.service.biaya_jasa))}`;
                    default:
                        return "-";
                }
            },
            set(value) {
                this.data.total_price = value;
            }
        },
    },
    mounted() {
        this.retrieve()
    },
    methods: {
        sendComplaint(){
            if (this.$refs.complaint !== undefined) {
                const text  = this.$refs.complaint.value;
                const id    = this.data.id;

                this.$api.post(this.$endpoints.orders.complaint, { text, id }).then((response) => {
                    this.complaint.form.show = false;
                    this.complaint.data.dikerjakan_teknisi = 0;
                    this.complaint.data.isi = text;
                    this.complaint.exists = true;

                    this.$root.$emit("open-toast", {
                        type: "Success",
                        background: this.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Komplain berhasil dikirim",
                            icon: "fa fa-check"
                        }
                    });
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.complaint.errors = error.response.data.errors.messages;
                    } else {
                        this.$root.$emit("open-toast", {
                            type: "Failed",
                            background: this.$colors.errorPrimary,
                            data: {
                                title: "Failed!",
                                message: "Komplain gagal dikirim",
                                icon: "fa fa-times"
                            }
                        });
                    }
                });
            }
        },
        saveSparepart(){
            const spareparts = this.spareparts.map(function (item, index, array) {
                const id = item.spare_part_id === undefined ? item.id : item.spare_part_id;

                return {
                    id,
                    jumlah: item.jumlah
                };
            });

            if (spareparts.length <= 0)
                return;

            this.$api.post(this.$endpoints.orders.save_sparepart, { spareparts, id: this.data.id }).then((response) => {
                if (response.status === 204) {
                    this.$root.$emit("open-toast", {
                        type: "success",
                        background: this.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Sparepart berhasil diubah",
                            icon: "fa fa-check"
                        }
                    });
                }
            }).catch((error) => {
                this.$root.$emit("open-toast", {
                    type: "failed",
                    background: this.$colors.errorPrimary,
                    data: {
                        title: "Failed!",
                        message: error.response.data.errors.messages.message,
                        icon: "fa fa-check"
                    }
                });
            })
        },
        addSparepart(sparepart){
            this.spareparts.push(sparepart);
        },
        retrieve(){
            const url = this.$url.generateUrl(this.$endpoints.orders.retrieve);
            this.$api.get(url(this.$router.currentRoute.params.unique_id)).then((response) => {
                this.data.id                = response.data.body.order.id;
                this.data.name              = response.data.body.order.nama_pelanggan;
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
                this.data.total_price       = response.data.body.order.price;
                this.data.service           = response.data.body.order.service;
                this.data.note              = response.data.body.order.note;

                this.spareparts             = this.data.spareparts;

                if (this.data.technician.name === "") {
                    this.data.technician.name = "-";
                }

                if (response.data.body.order.complaint !== null) {
                    this.complaint.exists = true;
                    this.complaint.data = response.data.body.order.complaint;
                }

                if (response.data.body.order.note !== null) {
                    this.note.exists = true;
                    this.note.text = response.data.body.order.note;
                    this.note.form.show = true;
                }

                console.log(this.note)
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
        updateStatusService(status) {
            const id = this.data.id;

            if (status === "selesai" || status === "terima") {
                const conf = confirm("Anda tidak akan bisa mengubah status menjadi status sebelumnya");
                if (!conf)
                    return;
            }

            this.$api.put(this.$endpoints.orders.update_status, { status, id }).then((response) => {
                this.data.status = response.data.body.status;
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Status service berhasil diubah",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                const message = error.response.data.errors.messages.exception !== undefined ?
                                error.response.data.errors.messages.exception :
                                error.response.data.errors.messages.message;

                this.$root.$emit("open-toast", {
                    type: "failed",
                    background: this.$colors.errorPrimary,
                    data: {
                        title: "Failed!",
                        message: message,
                        icon: "fa fa-check"
                    }
                });
            })
        },
        updateStatusAuthorized(status){
            const notAuthorized = function (array = []) {
                return !array.includes(status);
            };

            const arr = ["menunggu", "dicek", "perbaikan", "selesai", "terima"];

            const index = arr.indexOf(status);
            if (index <= 0)
                return false;

            // arr[index - 1] === this.data.status >> meaning
            // check the previous status if the previous status is same with current status
            const role = this.$store.state.user.data.role;
            if (role === "teknisi" && arr[index - 1] === this.data.status){
                return notAuthorized(["terima"]);
            } else if (role === "admin" && arr[index - 1] === this.data.status) {
                return notAuthorized(["menunggu", "dicek", "perbaikan", "selesai"]);
            }

            return false;
        },
        updateNote(){
            this.$api.post(this.$endpoints.orders.note, {
                note: this.note.text,
                id: this.data.id,
                id_technician: this.$role.isTechnician ? this.$store.state.user.data.id : undefined
            }).then((response) => {
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Catatan berhasil diubah atau dibuat",
                        icon: "fa fa-check"
                    }
                });
                this.data.note = this.note.text;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.note.errors = error.response.data.errors.messages;
                }
            });
        },
        deleteNote(){
            const conf = confirm("Yakin menghapus note?");
            if (!conf)
                return;

            this.$api.post(this.$endpoints.orders.note, {
                id: this.data.id,
                id_technician: this.$role.isTechnician ? this.$store.state.user.data.id : undefined
            }).then((response) => {
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Catatan berhasil dihapus",
                        icon: "fa fa-check"
                    }
                });

                this.note.exists = false;
                this.note.text = "";
                this.note.form.show = false;
                this.data.note = null;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.note.errors = error.response.data.errors.messages;
                }
            });
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

.status-danger {
    color: #e56767;
    background-color: #fbeaea;
}

.status {
    padding: 5px 9px;
    border-width: 1px;
    border-radius: 3px;
}

.status-info {
    color: #5cace5;
    background-color: #e0effa;
}

.status-success {
    color: #30c78d;
    background-color: #bff0dd;
}

.input-container .input-error, .input-error {
    border: 1px solid var(--error-primary);
}

.error-message {
    margin-top: 5px;
    display: inline-block;
    color: var(--error-primary);
    opacity: 1;
}

.word-count {
    margin-top: 5px;
    display: inline-block;
    color: #999;
    float: right;
}
</style>
