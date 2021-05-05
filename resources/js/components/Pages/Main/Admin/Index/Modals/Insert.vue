<template>
    <div>
        <div class="modal-insert-container">
            <transition-group name="insert-transition">
                <div key="modal" class="insert-container" v-if="inAnimation">
                    <div class="icon-close" v-on:click="closeModal(true)">
                        <i class="fa fa-times"></i>
                    </div>
                    <form @submit.prevent>
                        <h2>Tambah Admin</h2>
                        <span class="sub-title">Isi form dibawah untuk menambah admin baru</span> <br/>
                        <div class="input-container">
                            <label for="">Nama</label>
                            <input v-bind:class="{'input-error': errors.name != null && errors.name !== undefined}" @focus="errors.name = null;" type="text" placeholder="Nama Admin" v-model="data.name">
                            <span class="error-message" v-if="errors.name != null && errors.name !== undefined">{{ errors.name[0] }}</span>
                        </div>
                        <div class="input-container">
                            <label for="">Username</label>
                            <input v-bind:class="{'input-error': errors.username != null && errors.username !== undefined}" @focus="errors.username = null;" type="text" placeholder="Username Admin" v-model="data.username">
                            <span class="error-message" v-if="errors.username != null && errors.username !== undefined">{{ errors.username[0] }}</span>
                        </div>
                        <div class="input-container">
                            <label for="">Jenis Kelamin</label>
                            <select v-bind:class="{'input-error': errors.gender != null && errors.gender !== undefined}" @focus="errors.gender = null" name="" id="" v-model="data.gender">
                                <option value="Laki - laki">Laki - laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <span class="error-message" v-if="errors.gender != null && errors.gender !== undefined">{{ errors.gender[0] }}</span>
                        </div>
                        <div class="input-container">
                            <label for="">Email</label>
                            <input v-bind:class="{'input-error': errors.email != null && errors.email !== undefined}" @focus="errors.email = null;" type="text" placeholder="Email Admin" v-model="data.email">
                            <span class="error-message" v-if="errors.email != null && errors.email !== undefined">{{ errors.email[0] }}</span>
                        </div>
                        <div class="input-container">
                            <span>Password otomatis akan bernilai 123456</span>
                        </div>
                        <button class="button-success-primary-sm" @click="save()">
                            Tambah
                        </button>
                    </form>
                </div>
                <FullOverlay key="overlay" v-if="inAnimation" @clicked="closeModal(true)"/>
            </transition-group>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "Insert",
    components: { FullOverlay },
    data(){
        return {
            inAnimation: false,
            data: {
                name: "",
                username: "",
                email: "",
                gender: "Laki - laki",
            },
            errors: {
                name: null,
                username: null,
                email: null,
                gender: null,
            }
        }
    },
    watch: {
        "data.name": function (newVal, oldVal) {
            if (newVal.length > 60) {
                this.data.name = oldVal;
            }
        },
        "data.username": function (newVal, oldVal) {
            if (newVal.length > 40) {
                this.data.username = oldVal;
            }
        },
        "data.email": function (newVal, oldVal) {
            if (newVal.length > 255) {
                this.data.email = oldVal;
            }
        },
        "data.gender": function (newVal, oldVal) {
            const arr = ["Laki - laki", "Perempuan"];
            if (!arr.includes(newVal)) {
                this.data.gender = oldVal;
            }
        },
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
        save(){
            this.$api.post(this.$endpoints.admins.insert, this.data).then((response) => {
                this.emitToParent("success", "Admin berhasil ditambahkan", true);
                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Admin berhasil ditambahkan",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                const data = error.response.data;

                if (error.response.status === 422) {
                    this.errors = JSON.parse(JSON.stringify(data.errors.messages));
                } else if (this.$math.status(error) === 5) {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: "Terjadi masalah pada server",
                            icon: "fa fa-times-circle"
                        }
                    });
                }

                console.log(error)
            })
        },
        emitToParent(type, message, withAnimation){
            this.$emit("response");
            this.closeModal(withAnimation);
        },
    }
}
</script>

<style scoped>
form {
    padding: 10px 25px 30px;
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
    margin-top: 14px;
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
