<template>
    <div class="app-container">
        <div class="spare-part-body-container">
            <form v-on:submit.prevent>
                <div class="spare-part-image-container">
                    <h4 style="font-weight: bold;">Foto Sparepart</h4>
                    <span>Format gambar harus diantara .jpg, .jpeg dan .png</span>
                    <div v-if="errors.images != null && errors.images !== undefined" style="text-align: center;">
                        <br/>
                        <span class="error-message">{{ errors.images[0] }}</span>
                    </div>
                    <div class="image-container">
                        <div v-for="(item, index) in images" style="display: flex; flex-direction: column; align-items: center">
                            <div v-if="!images[index].contain" :class="{'image-dashed': !disabled, 'image-dashed-disabled': disabled}" v-on:click="chooseImage(index)">
                                <i class="fa" :class="{'image-icon fa-plus-circle': !disabled, 'image-icon-disabled': disabled}"></i>
                            </div>
                            <div v-show="images[index].contain" class="image-fill">
                                <div class="layer" v-if="['admin'].includes($store.state.user.data.role)">
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
                <span style="display: block; text-align: center; margin-top: 60px; color: #aaaaaa;" v-if="['admin'].includes($store.state.user.data.role)">
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
                                    <input :disabled="disabled" v-bind:class="{'input-error': errors.name != null && errors.name !== undefined}" @focus="errors.name = null;" type="text" placeholder="Masukkan nama sparepart" v-model="data.name" maxlength="70">
                                </div>
                                <span class="error-message" v-if="errors.name != null && errors.name !== undefined">{{ errors.name[0] }}</span>
                                <span class="word-count">{{ data.name.length }}/70</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Part Number</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <input v-bind:class="{'input-error': errors.part_number != null && errors.part_number !== undefined}" @focus="errors.part_number = null;" type="text" placeholder="Masukkan part number" v-model="data.part_number" maxlength="50">
                                </div>
                                <span style="display: inline-block; color: #999; line-height: 25px; font-size: 13px;">Jika tidak ada dapat dikosongkan</span>
                                <span class="error-message" v-if="errors.part_number != null && errors.part_number !== undefined">{{ errors.part_number[0] }}</span>
                                <span class="word-count">{{ data.part_number.length }}/50</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Serial Number</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <input v-bind:class="{'input-error': errors.serial_number != null && errors.serial_number !== undefined}" @focus="errors.serial_number = null;" type="text" placeholder="Masukkan serial number" v-model="data.serial_number" maxlength="50">
                                </div>
                                <span style="display: inline-block; color: #999; line-height: 25px; font-size: 13px;">Jika tidak ada dapat dikosongkan</span>
                                <span class="error-message" v-if="errors.serial_number != null && errors.serial_number !== undefined">{{ errors.serial_number[0] }}</span>
                                <span class="word-count">{{ data.serial_number.length }}/50</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Deskripsi</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <textarea :disabled="disabled" v-bind:class="{'input-error': errors.description != null && errors.description !== undefined}" @focus="errors.description = null;" placeholder="Deskripsi sparepart" cols="30" rows="10" style="resize: none" v-model="data.description"></textarea>
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
                                    <select :disabled="disabled" v-bind:class="{'input-error': errors.type != null && errors.type !== undefined}" @focus="errors.type = null" v-model="data.type" name="" id="">
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
                                    <input :disabled="disabled" v-bind:class="{'input-error': errors.stock != null && errors.stock !== undefined}" @focus="errors.stock = null" v-model="data.stock" type="number" placeholder="Stok" value="0">
                                    <span class="error-message" v-if="errors.stock != null && errors.stock !== undefined">{{ errors.stock[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Harga Asli</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container-price" v-bind:class="{'input-error': errors.real_price != null && errors.real_price !== undefined}">
                                    <span>Rp</span>
                                    <span class="separator"></span>
                                    <input :disabled="disabled" v-model="data.real_price" type="number" placeholder="Harga Asli" @focus="errors.real_price = null">
                                </div>
                                <span class="error-message" v-if="errors.real_price != null && errors.real_price !== undefined">{{ errors.real_price[0] }}</span>
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
                                    <input :disabled="disabled" v-model="data.price" type="number" placeholder="Harga" @focus="errors.price = null">
                                </div>
                                <span class="error-message" v-if="errors.price != null && errors.price !== undefined">{{ errors.price[0] }}</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10 right-column">
                                <button @click="back" class="button-transparent-sm">Kembali</button>
                                <button v-if="$role.isAdmin" v-on:click="saveSparepart()" class="button-success-primary-sm">Simpan</button>
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
            id: null,
            images: [
                {
                    contain: false,
                    file: null
                },
                {
                    contain: false,
                    file: null
                },
                {
                    contain: false,
                    file: null
                },
                {
                    contain: false,
                    file: null
                },
                {
                    contain: false,
                    file: null
                }
            ],
            data: {
                id: -1,
                name: "",
                description: "",
                type: "pc",
                stock: 0,
                price: 0,
                part_number: "",
                serial_number: ""
            },
            errors: {
                name: null,
                description: null,
                type: null,
                stock: null,
                price: null,
                part_number: null,
                serial_number: null
            },
            toast: {
                open: false,
                background: this.$colors.errorPrimary,
                data: {
                    title: "Failed!",
                    message: "Edit sparepart gagal",
                    icon: "fa fa-times-circle"
                },
            },
            disabled: true
        }
    },
    mounted() {
        this.id = this.$router.currentRoute.params.id;
        // dont give id null
        if (this.id) {
            this.retrieve();
        }

        this.disabled = !['admin'].includes(this.$store.state.user.data.role);
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
        },
        "data.real_price": function (newVal, oldVal) {
            // return if new value is not a number
            // or new value is less than 0
            // or new value is greater than 9.999.999.999
            if (isNaN(newVal) || newVal < 0 || newVal > 9999999999) {
                this.data.real_price = oldVal;
            }
        },
        "data.part_number": function (newVal, oldVal) {
            // if (newVal === null || oldVal === null)
            //     return;

            if (newVal.length > 50) {
                this.data.part_number = oldVal;
            }
        },
        "data.serial_number": function (newVal, oldVal) {
            // if (newVal === null || oldVal === null)
            //     return;

            if (newVal.length > 50) {
                this.data.serial_number = oldVal;
            }
        },
    },
    methods: {
        chooseImage(index){
            if (this.$refs.input_images !== undefined && ['admin'].includes(this.$store.state.user.data.role)) {
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
                        self.$set(self.images, index, {
                            contain: true,
                            file
                        });
                    };
                    reader.readAsDataURL(file);
                }
            }
        },
        retrieve(){
            const self = this;
            this.$api.get(this.$endpoints.sparepart.get + `/${this.id}`).then(async function (response) {
                const sparepart = response.data.body.sparepart;

                self.data.id = sparepart.id;
                self.data.name = sparepart.nama_spare_part;
                self.data.description = sparepart.deskripsi.cutIfGreaterThan(3000);
                self.data.type = sparepart.tipe === "pc/komputer" ? "pc" : sparepart.tipe;
                self.data.stock = sparepart.stok;
                self.data.price = sparepart.harga;
                self.data.real_price = sparepart.harga_asli;
                self.data.part_number = sparepart.part_number === null ? "" : sparepart.part_number;
                self.data.serial_number = sparepart.serial_number === null ? "" : sparepart.serial_number;

                if (self.$refs.images !== null && sparepart.images !== null) {
                    for (let i = 0; i < sparepart.images.length; i++) {
                        const file = await self.$image.urlToFile(sparepart.images[i].picture).then(res => res);

                        self.$set(self.images, i, {
                            contain: true,
                            file: file
                        });
                        self.$refs.images[i].setAttribute("src", sparepart.images[i].picture);
                    }
                }
            }).catch(function (error) {
                const data = error.response.data;

                if (error.response.status === 422) {
                    self.errors = JSON.parse(JSON.stringify(data.errors.messages));
                }

                console.error(data.errors.messages)
            })
        },
        removeImage(index) {
            this.$set(this.images, index, {
                contain: false,
                file: null
            });
            this.$refs.input_images[index].value = [];
        },
        saveSparepart(){
            const self = this;
            const form = new FormData();

            form.append("id", this.data.id);
            form.append("name", this.data.name);
            form.append("description", this.data.description);
            form.append("type", this.data.type);
            form.append("stock", this.data.stock);
            form.append("price", this.data.price);
            form.append("real_price", this.data.real_price);
            form.append("_method", "PUT");

            if (this.data.part_number.length !== 0) {
                form.append("part_number", this.data.part_number);
            }

            if (this.data.serial_number.length !== 0) {
                form.append("serial_number", this.data.serial_number);
            }

            const images = this.images;
            for (const index in images) {
                if (!images.hasOwnProperty(index))
                    continue;

                if (!images[index].contain) continue;

                const file = images[index].file;
                form.append("images[]", file);
            }

            const headers = {
                'Content-Type': 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2)
            };

            this.$api.post(this.$endpoints.sparepart.put, form, { headers }).then((response) => {
                this.$router.push({
                    name: "sparepart",
                });

                this.$root.$emit("open-toast", {
                    type: "success",
                    background: this.$colors.successPrimary,
                    data: {
                        title: "Success!",
                        message: "Edit sparepart berhasil",
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

.image-dashed-disabled {
    width: 170px;
    height: 170px;
    border: 1px dashed #bababa;
    border-radius: 4px;
    margin-left: 5px;
    margin-right: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-icon {
    color: var(--blue-primary);
    font-size: 40px;
}

.image-icon-disabled {
    color: #bababa;
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
