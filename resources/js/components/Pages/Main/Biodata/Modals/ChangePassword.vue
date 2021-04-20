<template>
    <div>
        <div>
            <div class="modal-insert-container">
                <transition-group name="insert-transition">
                    <div key="modal" class="insert-container" v-if="inAnimation">
                        <div class="icon-close" v-on:click="closeModal(true)">
                            <i class="fa fa-times"></i>
                        </div>
                        <form @submit.prevent>
                            <h2>Ganti Password</h2>
                            <span class="sub-title">Masukkan password lama dan baru</span> <br/>
                            <div class="input-container">
                                <input v-bind:class="{'input-error': errors.old_password != null && errors.old_password !== undefined}" @focus="errors.old_password = null;" type="password" placeholder="Password lama" v-model="data.old_password">
                                <span class="error-message" v-if="errors.old_password != null && errors.old_password !== undefined">{{ errors.old_password[0] }}</span>
                            </div>
                            <div class="input-container">
                                <input v-bind:class="{'input-error': errors.new_password != null && errors.new_password !== undefined}" @focus="errors.new_password = null;" type="password" placeholder="Password baru" v-model="data.new_password">
                                <span class="error-message" v-if="errors.new_password != null && errors.new_password !== undefined">{{ errors.new_password[0] }}</span>
                            </div>
                            <div class="input-container">
                                <input v-bind:class="{'input-error': errors.repeat_new_password != null && errors.repeat_new_password !== undefined}" @focus="errors.repeat_new_password = null;" type="password" placeholder="Ulangi password baru" v-model="data.repeat_new_password">
                                <span class="error-message" v-if="errors.repeat_new_password != null && errors.repeat_new_password !== undefined">{{ errors.repeat_new_password[0] }}</span>
                            </div>
                            <button class="button-success-primary-sm" v-on:click="changePassword">
                                Ubah
                            </button>
                            <span class="sub-title" style="margin-top: 10px;">Jangan gunakan password yang mudah ditebak</span>
                        </form>
                    </div>
                    <FullOverlay key="overlay" @clicked="closeModal(true)"/>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../Overlays/FullOverlay";

export default {
    name: "ChangePassword",
    components: {
        FullOverlay
    },
    data(){
        return {
            inAnimation: false,
            errors: {
                old_password: null,
                new_password: null,
                repeat_new_passsword: null,
            },
            data: {
                old_password: "",
                new_password: "",
                repeat_new_password: "",
            }
        }
    },
    mounted() {
        this.inAnimation = true;
    },
    methods: {
        closeModal(withAnimation){
            this.inAnimation = false;

            const self = this;
            const id = setTimeout(function () {
                if (withAnimation) {
                    self.$emit("onAnimationEnd");
                }

                self.$emit("closeModal");
                document.body.style.overflow = "visible";
                clearTimeout(id);
            }, 500);
        },
        changePassword(){
            this.$api.post(this.$endpoints.auth.change_password, {...this.data}).then((response) => {
                console.log(response);
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Password berhasil diubah",
                        icon: "fa fa-check"
                    }
                });
                this.closeModal(true);
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors.messages;
                } else {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: "Terjadi masalah saat mengubah password",
                            icon: "fa fa-times-circle"
                        }
                    });
                }
            });
        }
    }
}
</script>

<style scoped>
form {
    padding: 10px 25px;
}

form > h2 {
    font-weight: bold;
    font-size: 25px;
}

form > .sub-title {
    color: #aaaaaa;
    display: block;
}

form > button {
    width: 100%;
    height: 38px;
    font-weight: bold;
}

.input-container input, .input-container textarea, .input-container select {
    width: 100%;
    font-size: 14px;
    outline: none;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    background: #f2f2f2;
    padding: 7px 7px 7px 9px;
}

.input-container textarea {
    height: 100px;
}

.input-container {
    margin-top: 7px;
    margin-bottom: 7px;
}

.input-container-price {
    width: 100%;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    background: #f2f2f2;
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
    background: #f2f2f2;
}

.input-container > label {
    color: #555;
}

.input-container .input-error, .input-error {
    border: 1px solid var(--error-primary);
}

::placeholder, :-ms-input-placeholder, ::-ms-input-placeholder {
    color: #cfcfcf;
}

.error-message {
    margin-top: 5px;
    display: inline-block;
    color: var(--error-primary);
    opacity: 1;
}

.modal-insert-container {
    position: fixed;
    z-index: 35;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.insert-container {
    background: white;
    border-radius: 4px;
    width: 390px;
    padding-bottom: 10px;
    /*height: 520px;*/
    position: relative;
    z-index: 39;
    overflow-y: auto;
}

.separator {
    height: 22px;
    width: 1px;
    background: #e0e0e0;
    display: inline-block;
    margin-left: 10px;
    opacity: .7;
}

.icon-close {
    position: absolute;
    right: 11px;
    top: 7px;
    color: var(--red-primary);
    cursor: pointer;
}

.icon-close > i {
    font-size: 28px;
}

.icon-close > i:hover {
    color: var(--red-primary-hover);
}

.insert-transition-enter-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.insert-transition-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.insert-transition-enter, .insert-transition-leave-to {
    opacity: 0;
}

textarea {
    resize: none;
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
