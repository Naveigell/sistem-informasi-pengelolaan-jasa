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
                                    <input type="text" placeholder="Masukkan nama sparepart">
                                </div>
                                <span class="word-count">0/70</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Deskripsi</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <textarea placeholder="Deskripsi sparepart" name="" cols="30" rows="10" style="resize: none"></textarea>
                                </div>
                                <span class="word-count">0/500</span>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Tipe Sparepart</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container">
                                    <select name="" id="">
                                        <option value="pc">Pc/Komputer</option>
                                        <option value="hp">Handphone</option>
                                        <option value="printer">Printer</option>
                                    </select>
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
                                    <input type="number" placeholder="Stok" value="0">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2 left-column">
                                <span>* Harga</span>
                            </div>
                            <div class="col-md-10 right-column">
                                <div class="input-container-price">
                                    <span>Rp</span>
                                    <span class="separator"></span>
                                    <input type="number" placeholder="Harga">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10 right-column">
                                <button class="button-transparent-sm">Batal</button>
                                <button class="button-success-primary-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Body",
    data(){
        return {
            images: [false, false, false, false, false]
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
