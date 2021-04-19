<template>
    <div class="app-container">
        <div class="body-container" style="position:relative;">
            <div class="biodata-role">
                {{ $store.state.user.data == null ? "" : $store.state.user.data.role.capitalize() }}
            </div>
            <h4>
                <i class="fa fa-user" style="margin-right: 10px"></i>{{ $store.state.user.data == null ? "" : $store.state.user.data.name }}
            </h4>
            <div class="biodata-container">
                <div class="biodata-container-left">
                    <div class="image-container">
                        <div class="image">
                            <img ref="image" v-on:click="changeProfilePicture($event)" v-if="user.data !== null" v-bind:src="user.data.biodata.profile_picture" alt="">
                        </div>
                        <input v-on:change="onProfilePictureChange($event)" type="file" accept="image/jpeg, image/png, image/jpg" hidden ref="input_image">
                        <button class="button-image" v-on:click="changeProfilePicture($event)">
                            Pilih Avatar
                        </button>
                        <span class="sub-image-text">Ukuran foto maksimal 10MB</span>
                        <span class="sub-image-text">Format gambar yang diterima .jpg, .png, .jpeg</span>
                    </div>
                </div>
                <div class="biodata-container-center">
                    <div class="biodata-container-center-form">
                        <form v-if="user.data !== null" action="" v-on:submit.prevent>
<!--                            <div v-if="button.saveActive" class="alert-success">Biodata berhasil diubah</div>-->
                            <h5>Profil Saya</h5>
                            <div v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Nama</span>
                                <span v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.name }}</span>
                                <input v-model="user.update.biodata.name" v-else type="text" class="biodata-input">
                            </div>
                            <div v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Username</span>
                                <span v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.username }}</span>
                                <input v-model="user.update.biodata.username" v-else type="text" class="biodata-input">
<!--                                <span v-if="button.saveActive" class="biodata-error-message">Field tidak boleh kosong</span>-->
                            </div>
                            <div v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Jenis Kelamin</span>
                                <span v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.jenis_kelamin }}</span>
                                <select v-model="user.update.biodata.jenis_kelamin" v-else name="" id="" class="biodata-input">
                                    <option value="Laki - laki">Laki - laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div style="display: flex" v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Alamat</span>
                                <span style="margin-left: 11px;" v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.alamat }}</span>
                                <textarea style="margin-left: 12px; resize: none;" v-model="user.update.biodata.alamat" v-else type="text" class="biodata-input"></textarea>
<!--                                <span v-if="button.saveActive" class="biodata-error-message">Field tidak boleh kosong</span>-->
                            </div>

                            <h5>Kontak Saya</h5>
                            <div v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Email</span>
                                <span v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.email }}</span>
                                <input v-model="user.update.biodata.email" v-else type="text" v-bind:class="{'biodata-input': errors.biodata.data.email === undefined, 'biodata-input-error': errors.biodata.data.email !== undefined}">
                            </div>
                            <div v-bind:class="{'biodata-table': !button.saveActive, 'biodata-table-save-button-active': button.saveActive}">
                                <span class="biodata-title">Nomor Telepon</span>
                                <span v-if="!button.saveActive" class="biodata-value">{{ user.data.biodata.nomor_hp }}</span>
                                <input v-model="user.update.biodata.nomor_hp" v-else type="text" v-bind:class="{'biodata-input': errors.biodata.data.nomor_hp === undefined, 'biodata-input-error': errors.biodata.data.nomor_hp !== undefined}">
                            </div>

                            <div class="button-update-container" style="margin-top: 20px">
                                <button class="button-update-password">Ubah Password</button>
                                <button class="button-update-biodata" v-on:click="button.saveActive = !button.saveActive;">{{ button.saveActive ? "Batal" : "Ubah Biodata" }}</button>
                                <button class="button-save-biodata" v-on:click="updateBiodata()" style="margin-left: 3px" v-if="button.saveActive">Simpan</button>
                                <span v-if="errors.biodata.firstErrorMessage != null && button.saveActive" class="text-danger" style="margin-left: 20px;">{{ errors.biodata.firstErrorMessage }}</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <span class="alert alert-danger" style="padding: 10px 15px;" v-if="errors.image.firstErrorMessage != null">{{ errors.image.firstErrorMessage }}</span>
        </div>

        <div class="elevation-2" style="background-color: white; margin-top: 20px; margin-bottom: 20px;" v-if="$store.state.user.data.role === 'teknisi'">
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
import BiodataUpdateSuccess from "../../../Alerts/BiodataUpdateSuccess";
import LineChart from "../../../Shared/Charts/LineChart";

export default {
    name: "Body",
    components: {
        'alert-success-biodata': BiodataUpdateSuccess,
        LineChart
    },
    data() {
        return {
            user: {
                data: null,
                update: null
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
                }
            },
            graph: {
                data: {}
            },
        }
    },
    mounted() {
        this.retrieveUserBiodata();
        if (this.$store.state.user.data.role === 'teknisi') {
            this.retrieveGraphData();
        }
    },
    methods: {
        random(){
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        },
        retrieveGraphData(){
            this.$api.get(this.$endpoints.biodata.graph).then((response) => {
                this.graph.data = response.data.body.graph.data;
                console.log(this.graph.data)
            }).catch((error) => {
                console.error(error);
            })
        },
        retrieveUserBiodata(){
            const self = this;
            this.$api.get(this.$endpoints.biodata.data).then(function (response) {
                self.user.data = JSON.parse(JSON.stringify(response.data.body));
                self.user.update = JSON.parse(JSON.stringify(response.data.body));
            }).catch(function (error) {
                console.log(error)
            });
        },
        changeProfilePicture() {
            if (this.$refs.input_image !== undefined) {
                this.$refs.input_image.click();
            }
        },
        async onProfilePictureChange(event) {
            const file = event.target.files[0];
            const image = this.$refs.image;
            const self = this;

            if (file !== undefined && image !== null) {
                const updated = await this.saveProfilePicture(file);

                if (updated) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const result = e.target.result;

                        if (self.user.data != null) {
                            self.user.data.biodata.profile_picture = result;
                        }

                        image.setAttribute("src", result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        },
        async saveProfilePicture(file){
            let updated = false;
            const headers = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };
            const self = this;
            const form = new FormData();
            form.append("image", file);

            await this.$api.post(this.$endpoints.biodata.image, form, headers).then((response) => {
                updated = true;
                if (self.user.data != null) {
                    self.user.data.biodata.profile_picture = response.data.body.new_image;

                    self.errors.image.data = {};
                    self.errors.image.firstErrorMessage = null;

                    self.$root.$emit("open-toast", {
                        type: "success",
                        background: self.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Profile picture berhasil diubah",
                            icon: "fa fa-check"
                        }
                    });

                    this.$store.dispatch('reloadUserData');
                }
            }).catch(function (error) {
                self.errors.image.data = error.response.data.errors.messages;

                const errors = self.errors.image.data;

                const key = Object.keys(errors)[0];
                const value = errors[key][0];

                self.errors.image.firstErrorMessage = value;
            });

            return updated;
        },
        updateBiodata(){
            const self = this;

            if (this.user.data == null) return;

            this.$api.put(this.$endpoints.biodata.data, {
                ...this.user.update.biodata
            }).then(function (response) {
                if (response.status === 200) {
                    self.$root.$emit("open-toast", {
                        type: "success",
                        background: self.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Biodata berhasil diubah",
                            icon: "fa fa-check"
                        }
                    });

                    // parse after use
                    const objs = JSON.parse(JSON.stringify(self.user.update.biodata));
                    const clone = {};

                    // copy properties into a new object
                    for (const key in objs) {
                        if (objs.hasOwnProperty(key) && key !== "profile_picture") {
                            clone[key] = objs[key];
                        }
                    }

                    clone["profile_picture"] = self.user.data.biodata.profile_picture;
                    self.user.data.biodata = JSON.parse(JSON.stringify(clone));
                }
            }).catch(function (error) {
                self.errors.biodata.data = error.response.data.errors.messages;

                const errors = self.errors.biodata.data;

                const key = Object.keys(errors)[0];
                const value = errors[key][0];

                self.errors.biodata.firstErrorMessage = value;
            });
        }
    }
}
</script>

<style scoped>
img {
    width: 260px;
    height: 260px;
    cursor: pointer;
    object-fit: cover;
    object-position: center;
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

.biodata-error-message {
    display: block;
    margin-left: 233px;
    margin-top: 7px;
    padding-bottom: 8px;
    color: orangered;
}

.biodata-input {
    width: 370px;
    margin-left: 8px;
    padding: 8px 12px;
    border: 1px solid #cacfd4;
    border-radius: 2px;
    outline: none;
}

.biodata-input-error {
    width: 370px;
    margin-left: 8px;
    padding: 8px 12px;
    border: 1px solid var(--error-primary);
    border-radius: 2px;
    box-shadow: 0 0 1px var(--error-primary);
    outline: none;
}

.biodata-input-select {
    width: 370px;
    margin-left: 8px;
    padding: 8px 12px;
    border: 1px solid #cacfd4;
    border-radius: 2px;
    outline: none;
}

/*.biodata-value:hover {*/
/*    color: var(--blue-primary);*/
/*}*/

.biodata-table {
    margin-top: 22px;
}

.biodata-table-save-button-active {
    margin-top: 6px;
}

.biodata-container {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
    position: relative;
}

.biodata-container-left {
    background: var(--body-primary);
    display: block;
    width: 400px;
    height: 400px;
    border: 1px solid #ddd;
}

.biodata-container-center {
    display: block;
    width: 100%;
    height: 440px;
}

.image-container {
    width: 100%;
}

.image {
    padding: 20px;
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
</style>
