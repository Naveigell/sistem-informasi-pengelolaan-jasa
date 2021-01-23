<template>
    <div>
        <div class="modal-insert-container">
            <transition-group name="insert-transition">
                <div key="modal" class="insert-container" v-if="inAnimation">
                    <div class="icon-close" v-on:click="closeModal(true)">
                        <i class="fa fa-times"></i>
                    </div>
                    <form @submit.prevent>
                        <h2>Edit Jasa</h2>
                        <span class="sub-title">Ganti form dibawah untuk mengubah jasa baru</span> <br/>
                        <div class="input-container">
                            <label for="">Nama Service</label>
                            <input v-bind:class="{'input-error': errors.name != null && errors.name !== undefined}" @focus="errors.name = null;" type="text" placeholder="Nama Service" v-model="data.name">
                            <span class="error-message" v-if="errors.name != null && errors.name !== undefined">{{ errors.name[0] }}</span>
                        </div>
                        <div class="input-container">
                            <label for="">Tipe</label>
                            <select v-bind:class="{'input-error': errors.type != null && errors.type !== undefined}" @focus="errors.type = null" name="" id="" v-model="data.type">
                                <option value="pc">Pc/Komputer</option>
                                <option value="hp">Hp</option>
                                <option value="printer">Printer</option>
                            </select>
                            <span class="error-message" v-if="errors.type != null && errors.type !== undefined">{{ errors.type[0] }}</span>
                        </div>
                        <div class="input-container">
                            <label for="">Deskripsi</label>
                            <textarea v-bind:class="{'input-error': errors.description != null && errors.description !== undefined}" @focus="errors.description = null;" placeholder="Deskripsi" v-model="data.description"></textarea>
                            <span class="error-message" v-if="errors.description != null && errors.description !== undefined">{{ errors.description[0] }}</span>
                        </div>
                        <div>
                            <label for="">Biaya Jasa</label>
                            <div class="input-container-price" v-bind:class="{'input-error': errors.price != null && errors.price !== undefined}">
                                <span>Rp</span>
                                <span class="separator"></span>
                                <input type="number" value="0" v-model="data.price" @focus="errors.price = null;">
                            </div>
                            <span class="error-message" v-if="errors.price != null && errors.price !== undefined">{{ errors.price[0] }}</span>
                        </div>
                        <div v-if="errors.id != null && errors.id !== undefined" style="text-align: center">
                            <span v-on:click="errors.id = null" class="error-message">{{ errors.id[0] }}</span>
                        </div>
                        <button class="button-success-primary-sm" @click="update()">
                            Simpan
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
    name: "Update",
    props: ["d", "index"],
    components: { FullOverlay },
    data(){
        return {
            inAnimation: false,
            data: {
                id: -1,
                name: "test",
                type: "pc",
                description: "test11",
                price: "1"
            },
            errors: {
                name: null,
                description: null,
                type: null,
                stock: null,
                price: null
            }
        }
    },
    watch: {
        "data.name": function (newVal, oldVal) {
            if (newVal.length > 30) {
                this.data.name = oldVal;
            }
        },
        "data.description": function (newVal, oldVal) {
            if (newVal.length > 255) {
                this.data.description = oldVal;
            }
        },
        "data.type": function (newVal, oldVal) {
            const arr = ["pc", "hp", "printer"];
            if (!arr.includes(newVal)) {
                this.data.type = oldVal;
            }
        },
        "data.price": function (newVal, oldVal) {
            // return if new value is not a number
            // or new value is less than 0
            // or new value is greater than 99.999.999
            if (isNaN(newVal) || newVal < 0 || newVal > 99999999) {
                this.data.price = oldVal;
            }
        }
    },
    mounted() {
        this.inAnimation = true;
        this.convertData();
    },
    methods: {
        closeModal(withAnimation) {
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
        update() {
            this.$api.put(this.$endpoints.service.update, this.data).then((response) => {
                if (response.status === 200) {
                    const data = response.data.body[0];

                    this.$emit("onUpdate", {
                        name: data.name,
                        description: data.description,
                        price: data.price,
                        type: data.type === "pc" ? "pc/komputer" : data.type
                    });

                    this.closeModal(true);
                    this.$root.$emit("openToast", {
                        title: "Success!",
                        message: "Jasa berhasil diubah",
                        icon: "fa fa-check",
                        background: this.$colors.successPrimary
                    });
                }
            }).catch((error) => {
                const data = error.response.data;

                if (error.response.status === 422) {
                    this.errors = JSON.parse(JSON.stringify(data.errors.messages));
                } else if (this.$math.status(error) === 5) {
                    this.$root.$emit("openToast", {
                        title: "Error!",
                        message: "Jasa gagal diubah",
                        icon: "fa fa-exclamation-triangle",
                        background: this.$colors.errorPrimary
                    });
                }
            })
        },
        emitToParent(type, message, withAnimation) {
            this.$emit("response", {type, message});
            this.closeModal(withAnimation);
        },
        convertData(){
            this.data.id = this.d.id_jasa;
            this.data.name = this.d.nama_jasa;
            this.data.description = this.d.deskripsi;
            this.data.price = this.d.biaya_jasa;
            this.data.type = this.d.tipe === "pc/komputer" ? "pc" : this.d.tipe;
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
    height: 520px;
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
