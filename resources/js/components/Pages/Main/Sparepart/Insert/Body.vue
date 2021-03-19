<template>
    <div class="app-container" style="margin-bottom: 100px;">
        <div class="spare-part-body-container">
            <form v-on:submit.prevent>
                <div class="spare-part-image-container">
                    <h4 style="font-weight: bold;">Foto Sparepart</h4>
                    <span>Format gambar harus diantara .jpg, .jpeg dan .png</span>
                    <div class="image-container">
                        <div v-for="(item, index) in images" style="display: flex; flex-direction: column; align-items: center">
                            <div v-if="!images[index]" class="image-dashed" v-on:click="chooseImage(index)">
                                <i class="fa fa-plus-circle"></i>
                            </div>
                            <div v-show="images[index]" class="image-fill">
                                <div class="layer">
                                    <div class="insert-overlay"></div>
                                    <div class="remove-image-overlay">
                                        <span v-on:click="removeImage(index)"><i class="fa fa-times-circle"></i></span>
                                    </div>
                                </div>
                                <img
                                    ref="images"
                                    src=""
                                    alt="View">
                            </div>
                            <span style="margin-top: 10px;">Foto {{ index + 1 }}</span>
                            <input v-on:change="onImageChange($event, index)" ref="input_images" type="file" accept="image/jpeg, image/png, image/jpg" hidden>
                        </div>
                    </div>
                </div>
                <span style="display: block; text-align: center; margin-top: 60px; color: #aaaaaa;">
                    Ukuran maksimal gambar yang diperbolehkan <br/> adalah 10 MB atau 10.000KB
                </span>
                <div class="spare-part-information-container">
                    <h4 style="font-weight: bold;">Informasi Sparepart</h4>
                    <div class="information-container">
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Nama Sparepart</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <input v-bind:class="{'input-error': errors.name != null && errors.name !== undefined}" @focus="errors.name = null;" type="text" placeholder="Masukkan nama sparepart" v-model="data.name" maxlength="70">
                                </div>
                                <span class="error-message" v-if="errors.name != null && errors.name !== undefined">{{ errors.name[0] }}</span>
                                <span class="word-count">{{ data.name.length }}/70</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Deskripsi</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <textarea v-bind:class="{'input-error': errors.description != null && errors.description !== undefined}" @focus="errors.description = null;" placeholder="Deskripsi sparepart" name="" cols="30" rows="10" style="resize: none" v-model="data.description"></textarea>
                                </div>
                                <span class="error-message" v-if="errors.description != null && errors.description !== undefined">{{ errors.description[0] }}</span>
                                <span class="word-count">{{ data.description.length }}/3000</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Tipe Sparepart</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <select v-bind:class="{'input-error': errors.type != null && errors.type !== undefined}" @focus="errors.type = null" v-model="data.type" name="" id="">
                                        <option value="pc">Pc/Komputer</option>
                                        <option value="hp">Handphone</option>
                                        <option value="printer">Printer</option>
                                    </select>
                                    <span class="error-message" v-if="errors.type != null && errors.type !== undefined">{{ errors.type[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Stok</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <input v-bind:class="{'input-error': errors.stock != null && errors.stock !== undefined}" @focus="errors.stock = null" v-model="data.stock" type="number" placeholder="Stok" value="0">
                                    <span class="error-message" v-if="errors.stock != null && errors.stock !== undefined">{{ errors.stock[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Harga</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container-price" v-bind:class="{'input-error': errors.price != null && errors.price !== undefined}">
                                    <span>Rp</span>
                                    <span class="separator"></span>
                                    <input v-model="data.price" type="number" placeholder="Harga" @focus="errors.price = null">
                                </div>
                                <span class="error-message" v-if="errors.price != null && errors.price !== undefined">{{ errors.price[0] }}</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10 right-column">
                                <button @click="back" class="button-transparent-sm">Batal</button>
                                <button v-on:click="saveSparepart()" class="button-success-primary-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <toast @toastEnded="toast.open = false" v-if="toast.open" :icon="toast.data.icon" :background="toast.background" :title="toast.data.title" :timer="2000" :subtitle="toast.data.message"/>
    </div>
</template>

<script>
import TopRightToast from "../../../../Toasts/TopRightToast";

export default {
    name: "Body",
    components: {
        "toast": TopRightToast
    },
    data(){
        return {
            images: [false, false, false, false, false],
            data: {
                name: "",
                description: "",
                type: "pc",
                stock: 0,
                price: 0
            },
            errors: {
                name: null,
                description: null,
                type: null,
                stock: null,
                price: null
            },
            toast: {
                open: false,
                background: this.$colors.errorPrimary,
                data: {
                    title: "Failed!",
                    message: "Tambah sparepart gagal",
                    icon: "fa fa-times-circle"
                },
            }
        }
    },
    watch: {
        "data.name": function (newVal, oldVal) {
            if (newVal.length > 70) {
                this.data.name = oldVal;
            }
        },
        "data.description": function (newVal, oldVal) {
            if (newVal.length > 3000) {
                this.data.description = oldVal;
            }
        },
        "data.type": function (newVal, oldVal) {
            const arr = ["pc", "hp", "printer"];
            if (!arr.includes(newVal)) {
                this.data.type = oldVal;
            }
        },
        "data.stock": function (newVal, oldVal) {
            // return if new value is not a number
            // or new value is less than 0
            // or new value is greater than 99.999
            if (isNaN(newVal) || newVal < 0 || newVal > 99999) {
                this.data.stock = oldVal;
            }
        },
        "data.price": function (newVal, oldVal) {
            // return if new value is not a number
            // or new value is less than 0
            // or new value is greater than 9.999.999.999
            if (isNaN(newVal) || newVal < 0 || newVal > 9999999999) {
                this.data.price = oldVal;
            }
        }
    },
    methods: {
        chooseImage(index){
            if (this.$refs.input_images !== undefined) {
                this.$refs.input_images[index].click();
            }
        },
        onImageChange(event, index){
            const file = event.target.files[0];
            const self = this;

            if (this.$refs.input_images !== undefined && this.$refs.images !== undefined) {
                if (file !== undefined) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const result = e.target.result;

                        self.$refs.images[index].setAttribute("src", result);
                        self.$set(self.images, index, true);
                    };
                    reader.readAsDataURL(file);
                }
            }
        },
        removeImage(index) {
            this.$set(this.images, index, false);
            this.$refs.input_images[index].value = [];
        },
        saveSparepart(){
            const self = this;
            const form = new FormData();

            form.append("name", this.data.name);
            form.append("description", this.data.description);
            form.append("type", this.data.type);
            form.append("stock", this.data.stock);
            form.append("price", this.data.price);

            const images = this.$refs.input_images;
            for (const index in images) {
                if (!images.hasOwnProperty(index))
                    continue;

                const file = images[index].files;
                if (file.length > 0) {
                    form.append("images[]", file[0]);
                }
            }

            const headers = {
                'Content-Type': 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2)
            };

            this.$api.post(this.$endpoints.sparepart.insert, form, { headers }).then((response) => {
                this.$router.push({
                    name: "sparepart",
                });

                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Tambah sparepart berhasil",
                        icon: "fa fa-check"
                    }
                });
            }).catch((error) => {
                const data = error.response.data;

                if (error.response.status === 422) {
                    self.errors = JSON.parse(JSON.stringify(data.errors.messages));
                } else if (error.response.status === 500) {
                    this.toast.open = true;
                }
            });
        }
    }
}
</script>

<style scoped>
img {
    width: 168px;
    height: 168px;
    border-radius: 4px;
    object-position: center;
}

.word-count {
    margin-top: 5px;
    display: inline-block;
    color: #999;
    float: right;
}

.error-message {
    margin-top: 5px;
    display: inline-block;
    color: var(--error-primary);
    opacity: 1;
}

.separator {
    height: 22px;
    width: 1px;
    background: #e0e0e0;
    display: inline-block;
    margin-left: 10px;
    opacity: .7;
}

.input-container-price {
    width: 100%;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
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

.layer {
    width: 168px;
    height: 168px;
    position: absolute;
    /*background: #0c0c0c;*/
    border-radius: 4px;
    opacity: 0;
}

.insert-overlay {
    width: 168px;
    height: 168px;
    opacity: 0.6;
    background: #222;
    position: absolute;
}

.remove-image-overlay span {
    color: white;
}

.remove-image-overlay {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    /*background: #242424;*/
}

.spare-part-information-container {
    margin-top: 60px;
}

.spare-part-body-container {
    background: white;
    border: 1px solid #e5e5e5;
    margin-bottom: 20px;
    padding: 30px;
}

.image-container {
    margin-top: 30px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-dashed {
    width: 170px;
    height: 170px;
    border: 1px dashed var(--blue-primary);
    border-radius: 4px;
    margin-left: 5px;
    margin-right: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fa-plus-circle {
    color: var(--blue-primary);
    font-size: 40px;
}

.fa-times-circle {
    font-size: 40px;
}

.image-fill {
    width: 170px;
    height: 170px;
    border: 1px solid #a4a4a4;
    border-radius: 4px;
    margin-left: 5px;
    margin-right: 5px;
    cursor: pointer;
}

.image-fill:hover .layer {
    opacity: 1;
    transition: 0.3s all;
    -o-transition: 0.3s all;
    -moz-transition: 0.3s all;
    -webkit-transition: 0.3s all;
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
