<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 24px;">BUAT SARAN</h5>
                            </div>
                        </div>
                        <div style="padding: 40px;">
                            <form @submit.prevent>
                                <div class="spare-part-information-container">
                                    <h4 style="font-weight: bold;">Informasi Saran</h4>
                                    <br/>
                                    <div class="information-container">
                                        <div class="row">
                                            <div class="col-md-1 left-column">
                                                <span>* Kepada</span>
                                            </div>
                                            <div class="col-md-11 right-column">
                                                <div class="input-container">
                                                    <input type="text" value="Admin" maxlength="70" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-1 left-column">
                                                <span>* Isi Saran</span>
                                            </div>
                                            <div class="col-md-11 right-column">
                                                <div class="input-container">
                                                    <textarea v-model="data.text" v-bind:class="{'input-error': errors.text != null && errors.text !== undefined}" @focus="errors.text = null;" ref="text" placeholder="Tulis saran kepada toko disini ..." name="" cols="30" rows="10" style="resize: none; padding: 10px;"></textarea>
                                                </div>
                                                <span class="error-message" v-if="errors.text != null && errors.text !== undefined">{{ errors.text[0] }}</span>
                                                <span class="word-count">{{ data.text.length }}/3000</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11 right-column">
                                                <button @click="back" class="button-transparent-sm">Batal</button>
                                                <button @click="send" class="button-success-primary-sm"><i class="fa fa-paper-plane"></i>&nbsp&nbspKirim</button>
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
    </div>
</template>

<script>
export default {
    name: "Body",
    data(){
        return {
            data: {
                text: ""
            },
            errors: {
                text: null
            }
        }
    },
    watch: {
        "data.text": function (newVal, oldVal) {
            if (newVal.length > 3000) {
                this.data.text = oldVal;
            }
        },
    },
    methods: {
        send(){
            const text = this.$refs.text.value;
            this.$api.post(this.$endpoints.suggestions.insert, { text }).then((response) => {
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Saran berhasil dikirim",
                        icon: "fa fa-check"
                    }
                });
                this.$router.push({
                    name: "suggestions"
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
                            message: "Saran gagal dikirim",
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
.word-count {
    margin-top: 5px;
    display: inline-block;
    color: #999;
    float: right;
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
}

.remove-image-overlay span {
    color: white;
}

.spare-part-information-container {
    margin-top: 0px;
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
