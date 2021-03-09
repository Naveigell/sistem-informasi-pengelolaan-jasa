<template>
    <div class="app-container">
        <div class="body-container" style="margin-bottom: 20px; position:relative;">
            <reset-password @response="openToast" @onAnimationEnd="closeModal(layouts.modals.resetPassword)" v-if="layouts.modals.resetPassword.active" :username="username" :icon="layouts.toast.data.icon" :background="layouts.toast.background" :title="layouts.toast.data.title" :timer="2000" :subtitle="layouts.toast.data.message"/>
            <TopRightToast v-if="layouts.toast.open" @toastEnded="layouts.toast.open = false" :subtitle="'Reset password teknisi berhasil'" :title="'Success!'" :icon="'fa fa-check'" :background="this.$colors.successPrimary" :timer="2000"/>
            <div class="biodata-role">
                Teknisi
            </div>
            <h4>
                <i class="fa fa-user" style="margin-right: 10px"></i>{{ $store.state.user.data == null ? "" : $store.state.user.data.name }}
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
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.name" value="John Doe">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Name</label>
                                </div>
                                <span v-if="error_test" class="sub-message-error">Nama harus diisi</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.username === undefined, 'field-container-error': errors.biodata.data.username !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.username" value="dityajelita12345">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Username</label>
                                </div>
                                <span v-if="error_test" class="sub-message-error">Username harus diisi</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.gender === undefined, 'field-container-error': errors.biodata.data.gender !== undefined}">
                                    <select style="width: 80%; border: none; outline: none;" v-model="user.data.gender" id="gender">
                                        <option value="Laki - laki">Laki - laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="gender" style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Gender</label>
                                </div>
                                <span v-if="error_test" class="sub-message-error">Gender harus diisi</span>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.address === undefined, 'field-container-error': errors.biodata.data.address !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.address" value="Jln. Diponegoro Gang Mawar No.172">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Alamat</label>
                                </div>
                                <span v-if="errors.biodata.data.address !== undefined" class="sub-message-error">{{ errors.biodata.data.address[0] }}</span>
                            </div>

                            <h5>Kontak Teknisi</h5>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.email === undefined, 'field-container-error': errors.biodata.data.email !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.email" value="john.doe@mail.com">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Email</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div :class="{'field-container': errors.biodata.data.phone === undefined, 'field-container-error': errors.biodata.data.phone !== undefined}">
                                    <input type="text" style="width: 80%; border: none; outline: none;" v-model="user.data.phone" value="089999999999">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">No Telp</label>
                                </div>
                            </div>
                            <div class="button-update-container" style="margin-top: 20px">
                                <button class="button-save-biodata" v-on:click="updateBiodata" style="margin-left: 3px">Simpan</button>
                                <button class="button-transparent-md" v-on:click="layouts.modals.resetPassword.active = true;" style="margin-left: 3px">Reset Password</button>
                                <span v-if="errors.biodata.firstErrorMessage != null && button.saveActive" class="text-danger" style="margin-left: 20px;">{{ errors.biodata.firstErrorMessage }}</span>
                            </div>
                        </form>
<!--                        <alert-success-biodata v-if="layouts.alerts.success.biodata.active" v-on:destroyed="layouts.alerts.success.biodata.active = false"/>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="body-container" style="margin-bottom: 20px;">
            <div class="statistic-container">
                <h4>Statistik</h4>
                <span>Statistik dari teknisi ini</span>
                <div class="statistic" style="margin-top: 40px; margin-bottom: 10px;">
                    <div v-for="i in 4" style="flex-basis: 25%; text-align: center; border-left: 1px solid rgba(227, 227, 227, 1)">
                        <span style="display: block; font-weight: bold; font-size: 16px; color: #2673dd;">0</span>
                        <span style="display: block; font-size: 14px; margin-top: 5px;">Service diselesaikan</span>
                    </div>
                </div>
<!--                <div class="statistic-graph" style="margin-top: 30px;">-->
<!--                    Here is the graph-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
import ResetPassword from "./Modals/ResetPassword";
import TopRightToast from "../../../../Toasts/TopRightToast";

export default {
    name: "Body",
    props: ["username"],
    components: {
        TopRightToast,
        "reset-password": ResetPassword
    },
    mounted() {
        this.error_test = false;
        this.retrieve();
    },
    data() {
        return {
            error_test: false,
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
        }
    },
    methods: {
        closeModal(modal){
            modal.active = false;
        },
        openToast(obj){
            this.layouts.toast.data.message = obj.message;

            if (obj.type === "failed") {
                this.layouts.toast.data.title = "Failed!";
                this.layouts.toast.data.icon = "fa fa-times-circle";
                this.layouts.toast.background = this.$colors.redPrimary;
            } else if (obj.type === "success") {
                this.layouts.toast.background = this.$colors.successPrimary;
            }

            this.layouts.toast.open = true;
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
            }).catch((error) => {
                if (error.response.status === 404) {
                    window.history.back();
                }
                console.error(error)
            });
        },
        async updateBiodata(){
            this.$api.put(this.$endpoints.technicians.update).then((response) => {
                console.log(response)
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.error_test = true;
                    this.errors.biodata.data = error.response.data.errors.messages;
                }
                console.error(error.response.data.errors)
            });
        },
        resetPassword(){
            console.log(1)
        }
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
