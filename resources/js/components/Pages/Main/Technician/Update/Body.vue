<template>
    <div class="app-container">
        <div class="body-container" style="margin-bottom: 20px; position:relative;">
            <reset-password @onAnimationEnd="closeModal(layouts.modals.resetPassword)" v-if="layouts.modals.resetPassword.active" :username="username"/>
            <div class="biodata-role">
                Teknisi
            </div>
            <h4>
                <i class="fa fa-user" style="margin-right: 10px"></i>{{ user.data.name == null ? "" : user.data.name }}
            </h4>
            <div class="technician-container">
                <div class="biodata-container-left">
                    <div class="image-container" v-if="user.data.profile_picture !== null">
                        <div class="image">
                            <img ref="image" :src="user.data.picture" alt="">
                        </div>
                    </div>
                </div>
                <div class="biodata-container-center">
                    <div class="biodata-container-center-form">
                        <form action="" v-on:submit.prevent>
                            <h5>Profil Teknisi</h5>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.name === undefined, 'field-container-error': errors.biodata.data.name !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.name" @focus="errors.biodata.data.name = undefined">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Name</label>
                                </div>
                                <span v-if="errors.biodata.data.name !== undefined" class="sub-message-error">{{ errors.biodata.data.name[0] }}</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.username === undefined, 'field-container-error': errors.biodata.data.username !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.username" @focus="errors.biodata.data.username = undefined">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Username</label>
                                </div>
                                <span v-if="errors.biodata.data.username !== undefined" class="sub-message-error">{{ errors.biodata.data.username[0] }}</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.gender === undefined, 'field-container-error': errors.biodata.data.gender !== undefined}">
                                    <select style="width: 80%; border: none; outline: none;" v-model="user.data.gender" id="gender" @focus="errors.biodata.data.gender = undefined">
                                        <option value="Laki - laki">Laki - laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="gender" style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Gender</label>
                                </div>
                                <span v-if="errors.biodata.data.gender !== undefined" class="sub-message-error">{{ errors.biodata.data.gender[0] }}</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.address === undefined, 'field-container-error': errors.biodata.data.address !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.address" @focus="errors.biodata.data.address = undefined">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Alamat</label>
                                </div>
                                <span v-if="errors.biodata.data.address !== undefined" class="sub-message-error">{{ errors.biodata.data.address[0] }}</span>
                            </div>

                            <h5>Kontak Teknisi</h5>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled" :class="{'field-container': errors.biodata.data.email === undefined, 'field-container-error': errors.biodata.data.email !== undefined}">
                                    <input type="text" disabled style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.email" @focus="errors.biodata.data.email = undefined">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Email</label>
                                </div>
                                <span v-if="errors.biodata.data.email !== undefined" class="sub-message-error">{{ errors.biodata.data.email[0] }}</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.phone === undefined, 'field-container-error': errors.biodata.data.phone !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.phone" @focus="errors.biodata.data.phone = undefined">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">No Telp</label>
                                </div>
                                <span v-if="errors.biodata.data.phone !== undefined" class="sub-message-error">{{ errors.biodata.data.phone[0] }}</span>
                            </div>
                            <div class="button-update-container" style="margin-top: 20px">
                                <button class="button-save-biodata" v-on:click="updateBiodata" style="margin-left: 3px">Simpan</button>
                                <button class="button-transparent-md" v-on:click="layouts.modals.resetPassword.active = true;" style="margin-left: 3px">Reset Password</button>
                                <span v-if="errors.biodata.firstErrorMessage != null && button.saveActive" class="text-danger" style="margin-left: 20px;">{{ errors.biodata.firstErrorMessage }}</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="elevation-2" style="background-color: white; margin-top: 20px; margin-bottom: 20px;">
            <div style="background-color: #f6f7f8; height: 43px;">
                <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center;">
                    <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">GRAFIK PERBAIKAN 6 BULAN SEBELUMNYA</h5>
                </div>
            </div>
            <div style="padding: 20px;">
                <LineChart v-bind:data="graph.data"/>
            </div>
        </div>
    </div>
</template>

<script>
import ResetPassword from "./Modals/ResetPassword";
import LineChart from "../../../../Shared/Charts/LineChart";

export default {
    name: "Body",
    components: {
        "reset-password": ResetPassword,
        LineChart
    },
    mounted() {
        this.username = this.$router.currentRoute.params.username;
        if (this.username) {
            this.retrieve();
        }
    },
    data() {
        return {
            username: null,
            user: {
                data: {
                    id: "",
                    name: "",
                    username: "",
                    gender: "",
                    address: "",
                    email: "",
                    phone: "",
                    picture: null
                },
            },
            button: {
                changeActive: false,
                saveActive: false
            },
            errors: {
                biodata: {
                    data: {},
                    firstErrorMessage: null
                },
                image: {
                    data: {},
                    firstErrorMessage: null
                }
            },
            layouts: {
                alerts: {
                    success: {
                        biodata: {
                            active: false
                        }
                    }
                },
                modals: {
                    resetPassword: {
                        active: false
                    }
                },
            },
            graph: {
                data: {}
            },
        }
    },
    methods: {
        closeModal(modal){
            modal.active = false;
        },
        async retrieve(){
            this.$api.get(this.$endpoints.technicians.retrieve + "/" + this.username).then((response) => {
                this.user.data.id           = response.data.body.id_users;
                this.user.data.name         = response.data.body.name;
                this.user.data.username     = response.data.body.username;
                this.user.data.email        = response.data.body.email;
                this.user.data.gender       = response.data.body.biodata.jenis_kelamin;
                this.user.data.address      = response.data.body.biodata.alamat;
                this.user.data.phone        = response.data.body.biodata.nomor_hp;
                this.user.data.picture      = response.data.body.biodata.profile_picture;

                this.retrieveGraph(this.user.data.id)
            }).catch((error) => {
                if (error.response.status === 404) {
                    this.back();
                }
            });
        },
        retrieveGraph(id){
            const url = this.$url.generateUrl(this.$endpoints.technicians.graph)
            this.$api.get(url(id)).then((response) => {
                this.graph.data = response.data.body.graph.data;
            }).catch((error) => {

            });
        },
        async updateBiodata(){
            // take some needed data
            const { id, address, email, gender, name, phone, username } = this.user.data;

            this.$api.put(this.$endpoints.technicians.update, {
                id, address, email, gender, name, phone, username,
                username_before: this.username
            }).then((response) => {
                if (Math.floor(response.status / 100) === 2) {
                    this.$root.$emit("open-toast", {
                        type: "success",
                        background: this.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Data teknisi berhasil diubah",
                            icon: "fa fa-check"
                        }
                    });
                }
            }).catch((error) => {
                if (error.response.status === 422 || error.response.status === 409) {
                    this.errors.biodata.data = error.response.data.errors.messages;
                }
            });
        },
    }
}
</script>

<style scoped>
.sub-message-error {
    display: inline-block;
    margin-top: 3px;
    color: var(--error-primary);
    animation: submessageerror 0.2s ease-in-out;
}

.statistic {
    display: flex;
    flex-direction: row;
}

.technician-container {
    margin-top: 25px;
    min-height: 100%;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    position: relative;
}

.field-container {
    padding: 8px;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    width: 500px;
    position:relative;
}

.field-container-error {
    padding: 8px;
    border: 1px solid var(--error-primary);
    border-radius: 3px;
    width: 500px;
    position:relative;
}

.field-disabled {
    opacity: .7;
    cursor: no-drop;
}

.biodata-container-left {
    background: var(--body-primary);
    display: block;
    width: 310px;
    height: 310px;
    border: 1px solid #ddd;
}

.biodata-container-center {
    display: block;
    width: 100%;
    height: 100%;
}

.image {
    padding: 20px;
}

.image img {
    width: 260px;
    height: 260px;
}

.button-image {
    width: 260px;
    height: 35px;
    margin-left: 20px;
    border: 1px solid #ddd;
    background: #fdfdfd;
    outline: none;
}

.button-image:hover {
    background: #f9f9f9;
    transition: all .2s;
    -o-transition: all .2s;
    -moz-transition: all .2s;
    -webkit-transition: all .2s;
}

.sub-image-text:nth-child(even) {
    margin-top: 10px;
}

.sub-image-text {
    color: #aaaaaa;
    display: block;
    font-size: 12px;
    text-align: center;
    margin-top: 0;
}


.button-update-biodata, .button-save-biodata, .button-update-password {
    padding: 9px 17px;
    outline: none;
    border: none;
    border-radius: 4px;
}

.biodata-role {
    position: absolute;
    top: 20px;
    right: 30px;
    font-weight: bold;
    font-size: 20px;
}

.button-update-biodata:hover, .button-update-password:hover {
    background: #dfdfdf;
}

.button-save-biodata {
    background: #1d84ff;
    color: #fff;
}

.button-save-biodata:hover {
    background: #56a4ff;
}

.button-reset-password {
    background: #dfdfdf;
    color: blue;
}

.biodata-change {
    color: var(--blue-primary);
    cursor: pointer;
}

.biodata-change:hover {
    color: #8ba2ff;
}

.biodata-title, .biodata-value {
    display: inline-block;
    color: #222;
}

.biodata-title {
    width: 220px;
}

.biodata-value {
    width: 320px;
    margin-left: 8px;
}

.biodata-container-center-form {
    margin: 20px 20px 20px 30px;
    width: 100%;
    height: 100%;
}

.biodata-container-center-form h5 {
    font-size: 16px;
    font-weight: bold;
    margin-top: 40px;
}

.biodata-container-center-form h5:first-child {
    font-size: 16px;
    font-weight: bold;
    margin-top: -14px;
}

.biodata-role {
    position: absolute;
    top: 20px;
    right: 30px;
    font-weight: bold;
    font-size: 20px;
}

select::-ms-expand {
    display: none;
}

select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
}
</style>
