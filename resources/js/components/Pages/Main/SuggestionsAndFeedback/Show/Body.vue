<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div
                                style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 24px;">LIHAT SARAN</h5>
                            </div>
                        </div>
                        <div style="padding: 40px;">
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
                                        <div class="header" v-if="data.suggestion.user !== undefined">
                                            <img class="avatar" :src="data.suggestion.user.biodata.profile_picture" v-if="$store.state.user.data.role === 'admin' && data.suggestion.user !== null">
                                            <div class="from" v-if="$store.state.user.data.role === 'admin'">
                                                <span>{{ data.suggestion.user.name }}</span>
                                                {{ data.suggestion.user.email }}
                                            </div>
                                            <div class="from" v-else>
                                                <span>Kepada: Admin</span>
                                            </div>
                                            <div class="date"><b>{{ data.date }}</b></div>
                                        </div>
                                        <div class="content" v-html="data.content"></div>
                                    </div>
                                    <div v-if="data.suggestion.user !== undefined">
                                        <div v-if="data.suggestion.reply === null && $store.state.user.data.role === 'admin'">
                                            <div class="col-md-12 col-lg-12 col-sm-12 right-column">
                                                <div class="input-container">
                                                    <textarea v-model="data.reply" v-bind:class="{'input-error': errors.reply != null && errors.reply !== undefined}" @focus="errors.reply = null;" ref="reply" placeholder="Tulis balasan saran disini ..." name="" cols="30" rows="10" style="resize: none; padding: 10px;"></textarea>
                                                </div>
                                                <span class="error-message" v-if="errors.reply != null && errors.reply !== undefined">{{ errors.reply[0] }}</span>
                                                <span class="word-count">{{ data.reply.length }}/3000</span>
                                            </div>
                                            <br/>
                                            <div class="col-md-12 col-lg-12 col-sm-12 right-column" style="margin-top: 10px;">
                                                <button @click="back" class="button-transparent-sm">Batal</button>
                                                <button @click="send" class="button-success-primary-sm"><i class="fa fa-paper-plane"></i>&nbsp&nbspKirim</button>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="details" style="padding: 10px; min-height: 200px;">
                                                <div class="header" v-if="data.suggestion.user !== undefined">
                                                    <div class="from">
                                                        <span>Dari: Admin</span>
                                                    </div>
                                                </div>
                                                <div class="content" v-html="data.suggestion.reply"></div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
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
                suggestion: {},
                reply: ""
            },
            errors: {
                reply: null
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
    },
    methods: {
        retrieve(id){
            const url = this.$url.generateUrl(this.$endpoints.suggestions.retrieve);
            this.$api.get(url(id)).then((response) => {
                this.data.content       = response.data.body.suggestion.content;
                this.data.date          = response.data.body.suggestion.created_at_sentences;
                this.data.suggestion    = response.data.body.suggestion;

                console.log(response)

                this.$nextTick(_ => {})
            }).catch((error) => {
                console.log(error)
            })
        },
        send(){
            if (this.$refs.reply !== undefined) {
                const url = this.$url.generateUrl(this.$endpoints.suggestions.reply);
                const id = this.$router.currentRoute.params.id;
                const reply = this.$refs.reply.value;

                this.$api.put(url(id), {
                    reply
                }).then((response) => {
                    this.data.suggestion.reply = response.data.body.reply;

                    this.$root.$emit("open-toast", {
                        type: "success",
                        background: this.$colors.successPrimary,
                        data: {
                            title: "Success!",
                            message: "Balasan berhasil dikirim",
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
                                message: "Balasan gagal dikirim",
                                icon: "fa fa-times"
                            }
                        });
                    }
                })
            }
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
