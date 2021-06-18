<template>
    <div class="app-container">
        <div class="body-container" style="margin-bottom: 20px; position:relative;">
            <div class="biodata-role">
                Pelanggan
            </div>
            <h4>
                <i class="fa fa-user" style="margin-right: 10px"></i>{{ user.data.name == null ? "" : user.data.name }}
            </h4>
            <div class="user-container">
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
                            <h5>Profil Pelanggan</h5>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.name">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Name</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.username">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Username</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.gender">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Gender</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.address">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Alamat</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.company">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Instansi</label>
                                </div>
                            </div>

                            <h5>Kontak Pelanggan</h5>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.email">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">Email</label>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <div class="field-disabled field-container">
                                    <input disabled type="text" style="width: 80%; border: none; outline: none; cursor: no-drop;" v-model="user.data.phone">
                                    <label style="display: inline-block; margin-left: 4px; color: #aaaaaa; font-weight: normal; font-size: 15px; position:absolute; right: 10px">No Telp</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Body",
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
                    company: "",
                    picture: null
                },
            },
        }
    },
    methods: {
        async retrieve(){
            const url = this.$url.generateUrl(this.$endpoints.users.retrieve);
            this.$api.get(url(this.username)).then((response) => {
                this.user.data.id           = response.data.body.id_users;
                this.user.data.name         = response.data.body.name;
                this.user.data.username     = response.data.body.username;
                this.user.data.email        = response.data.body.email;
                this.user.data.gender       = response.data.body.biodata.jenis_kelamin;
                this.user.data.address      = response.data.body.biodata.alamat;
                this.user.data.phone        = response.data.body.biodata.nomor_hp;
                this.user.data.picture      = response.data.body.biodata.profile_picture;
                this.user.data.company      = response.data.body.biodata.instansi;
                this.user.data.company      = this.user.data.company === null ? "-" : this.user.data.company;
            }).catch((error) => {
                if (error.response.status === 404) {
                    this.back();
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

.user-container {
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
