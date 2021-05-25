<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div
                                style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 24px;">LIHAT KOMPLAIN</h5>
                            </div>
                        </div>
                        <div style="padding: 40px;">
                            <router-link v-if="data.complaint.order !== undefined && data.complaint.order !== null" style="color: #5179d6; text-decoration: none;" :to="{ path: '/orders/' + data.complaint.order.unique_id }">
                                <h3>{{ data.complaint.order.unique_id }}</h3>
                            </router-link>
                            <span v-if="Object.keys(data.complaint).length > 0">
                                <span v-if="data.complaint.disetujui_admin === 0" class="label" v-bind:class="{'label-danger': data.complaint.dikerjakan_teknisi === 0 && data.complaint.disetujui_pelanggan === 0, 'label-info': data.complaint.dikerjakan_teknisi === 1 && data.complaint.disetujui_pelanggan === 0, 'label-success': data.complaint.disetujui_pelanggan === 1 && data.complaint.dikerjakan_teknisi}" style="display: inline-block; margin-bottom: 20px;">
                                    {{ data.complaint.disetujui_pelanggan === 1 && data.complaint.dikerjakan_teknisi === 1 ? "Disetujui pelanggan" : data.complaint.dikerjakan_teknisi === 1 ? "Selesai dikerjakan" : "complain" }}
                                </span>
                                <span v-else class="label-default label" style="display: inline-block; margin-bottom: 20px;">
                                    selesai
                                </span>
                            </span>
                            <div class="email-app mb-4">
                                <main class="message">
                                    <div class="toolbar">
                                        <div class="btn-group">
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-star"></span>
                                            </button>
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-star-o"></span>
                                            </button>
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-bookmark-o"></span>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-mail-reply"></span>
                                            </button>
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-mail-reply-all"></span>
                                            </button>
                                            <button class="btn btn-light" type="button">
                                                <span class="fa fa-mail-forward"></span>
                                            </button>
                                        </div>
                                        <button class="btn btn-light" type="button">
                                            <span class="fa fa-trash-o"></span>
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-light dropdown-toggle" data-toggle="dropdown" type="button">
                                                <span class="fa fa-tags"></span>
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">add label <span class="badge badge-danger"> Home</span></a>
                                                <a class="dropdown-item" href="#">add label <span class="badge badge-info"> Job</span></a>
                                                <a class="dropdown-item" href="#">add label <span class="badge badge-success"> Clients</span></a>
                                                <a class="dropdown-item" href="#">add label <span class="badge badge-warning"> News</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="details" style="padding: 10px; min-height: 200px;">
                                        <div class="header" v-if="data.complaint.user !== undefined">
                                            <img class="avatar" :src="data.complaint.user.biodata.profile_picture" v-if="$store.state.user.data.role === 'admin' && data.complaint.user !== null">
                                            <div class="from" v-if="$store.state.user.data.role === 'admin'">
                                                <span>{{ data.complaint.user.name }}</span>
                                                {{ data.complaint.user.email }}
                                            </div>
                                            <div class="from" v-else>
                                                <span>Kepada: Admin</span>
                                            </div>
                                            <div class="date"><b>{{ data.date }}</b></div>
                                        </div>
                                        <div class="content" v-html="data.content"></div>
                                    </div>
                                </main>
                            </div>
                            <div v-if="$store.state.user.data.role === 'teknisi' && data.complaint.dikerjakan_teknisi === 0">
                                <button @click="actions.doComplaint = true;" class="button-success-primary-tag" v-if="!actions.doComplaint">Kerjakan</button>
                                <div v-else>
                                    <button @click="doComplaint" class="button-green-primary-tag"><i class="fa fa-check"></i>&nbspIya</button>
                                    <button @click="actions.doComplaint = false;" class="button-danger-primary-tag"><i class="fa fa-times"></i>&nbspBatal</button>
                                </div>
                            </div>
                            <div v-if="$store.state.user.data.role === 'pelanggan' && data.complaint.dikerjakan_teknisi === 1 && data.complaint.disetujui_pelanggan === 0">
                                <span style="display: block; margin-bottom: 10px; font-weight: bold;" class="text-info text">Komplain sudah dikerjakan oleh teknisi, mohon untuk menyetujui komplain.</span>
                                <button @click="actions.doAccept = true;" class="button-success-primary-tag" v-if="!actions.doAccept">Setujui</button>
                                <div v-else>
                                    <button @click="accept" class="button-green-primary-tag"><i class="fa fa-check"></i>&nbspIya</button>
                                    <button @click="actions.doAccept = false;" class="button-danger-primary-tag"><i class="fa fa-times"></i>&nbspBatal</button>
                                </div>
                            </div>
                            <div v-if="this.$role.isAdmin && data.complaint.dikerjakan_teknisi === 1 && data.complaint.disetujui_pelanggan === 1 && data.complaint.disetujui_admin === 0">
                                <span style="display: block; margin-bottom: 10px; font-weight: bold;" class="text-info text">Komplain sudah dikerjakan oleh teknisi dan diterima pelanggan, mohon admin untuk menyetujui komplain.</span>
                                <button @click="actions.doAccept = true;" class="button-success-primary-tag" v-if="!actions.doAccept">Setujui</button>
                                <div v-else>
                                    <button @click="accept" class="button-green-primary-tag"><i class="fa fa-check"></i>&nbspIya</button>
                                    <button @click="actions.doAccept = false;" class="button-danger-primary-tag"><i class="fa fa-times"></i>&nbspBatal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Body",
    data(){
        return {
            data: {
                content: "",
                date: "",
                complaint: {},
                reply: ""
            },
            errors: {
                reply: null
            },
            actions: {
                doComplaint: false,
                doAccept: false
            }
        }
    },
    watch: {
        "data.reply": function (newVal, oldVal) {
            if (newVal.length > 3000) {
                this.data.reply = oldVal;
            }
        },
    },
    mounted() {
        this.retrieve(this.$router.currentRoute.params.id);

        console.log(this.$role)
    },
    methods: {
        retrieve(id){
            const url = this.$url.generateUrl(this.$endpoints.complaints.retrieve);
            this.$api.get(url(id)).then((response) => {
                this.data.content       = response.data.body.complaint.content;
                this.data.date          = response.data.body.complaint.created_at_sentences;
                this.data.complaint     = response.data.body.complaint;

                console.log(this.data.complaint);

                this.$nextTick(_ => {})
            }).catch((error) => {
                console.log(error)
            })
        },
        accept(){
            let endpoint = this.$endpoints.complaints.do_admin_accept;
            if (this.$role.isUser) {
                endpoint = this.$endpoints.complaints.do_user_accept;
            }

            const url = this.$url.generateUrl(endpoint);
            const id = this.$router.currentRoute.params.id;

            this.$api.put(url(id)).then((response) => {
                if (this.$role.isUser) {
                    this.data.complaint.disetujui_pelanggan = 1;
                } else {
                    this.data.complaint.disetujui_admin = 1;
                }

                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Komplain berhasil disetujui",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors.messages;
                } else {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: "Komplain gagal disetujui",
                            icon: "fa fa-times"
                        }
                    });
                }
            });
        },
        doComplaint(){
            const url = this.$url.generateUrl(this.$endpoints.complaints.do_complaint);
            const id = this.$router.currentRoute.params.id;

            this.$api.put(url(id)).then((response) => {
                this.data.complaint.dikerjakan_teknisi = 1;

                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Komplain berhasil dikerjakan",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors.messages;
                } else {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: "Komplain gagal dikerjakan",
                            icon: "fa fa-times"
                        }
                    });
                }
            });
        }
    }
}
</script>

<style scoped>
body{margin-top:20px;}
.email-app {
    display: flex;
    flex-direction: row;
    background: #fff;
    border: 1px solid #e1e6ef;
}

.email-app nav {
    flex: 0 0 200px;
    padding: 1rem;
    border-right: 1px solid #e1e6ef;
}

.email-app nav .nav .nav-item .nav-link i,
.email-app nav .nav .nav-item .navbar .dropdown-toggle i,
.navbar .email-app nav .nav .nav-item .dropdown-toggle i {
    width: 20px;
    margin: 0 10px 0 0;
    font-size: 14px;
    text-align: center;
}

.email-app main {
    min-width: 0;
    flex: 1;
    padding: 1rem;
}

.email-app .inbox .toolbar {
    padding-bottom: 1rem;
    border-bottom: 1px solid #e1e6ef;
}

.email-app .inbox .message a {
    color: #000;
}

.email-app .inbox .message a:hover {
    text-decoration: none;
}

.email-app .inbox .message.unread .header,
.email-app .inbox .message.unread .title {
    font-weight: bold;
}

.email-app .inbox .message .header {
    display: flex;
    flex-direction: row;
    margin-bottom: 0.5rem;
}

.email-app .inbox .message .header .date {
    margin-left: auto;
}

.email-app .message .toolbar {
    padding-bottom: 1rem;
    border-bottom: 1px solid #e1e6ef;
}

.email-app .message .details .header {
    display: flex;
    padding: 1rem 0;
    margin: 1rem 0;
    border-top: 1px solid #e1e6ef;
    border-bottom: 1px solid #e1e6ef;
}

.email-app .message .details .header .avatar {
    width: 40px;
    height: 40px;
    margin-right: 1rem;
}

.email-app .message .details .header .from {
    font-size: 12px;
    color: #9faecb;
    align-self: center;
}

.email-app .message .details .header .from span {
    display: block;
    font-weight: bold;
}

.email-app .message .details .header .date {
    margin-left: auto;
}

.email-app .message .details .attachments .attachment .menu a {
    padding: 0 0.5rem;
    font-size: 14px;
    color: #e1e6ef;
}

@media (max-width: 767px) {
    .email-app {
        flex-direction: column;
    }
    .email-app nav {
        flex: 0 0 100%;
    }
}

@media (max-width: 575px) {
    .email-app .message .header {
        flex-flow: row wrap;
    }
    .email-app .message .header .date {
        flex: 0 0 100%;
    }
}

.error-message {
    margin-top: 5px;
    display: inline-block;
    color: var(--error-primary);
    opacity: 1;
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

.word-count {
    margin-top: 5px;
    display: inline-block;
    color: #999;
    float: right;
}
</style>
