<template>
    <div class="app-container">
        <div class="spare-part-body-container">
            <div class="top-navigation">
                <ul>
                    <li class="router-active">Semua</li>
                    <li>Harga Terendah</li>
                    <li>Harga Tertinggi</li>
                </ul>
            </div>
            <div class="spare-part-list-container">
                <div class="spare-part-input-container">
                    <div class="spare-part-inputs">
                        <div class="spare-part-input-search">
                            <div class="input-search-container">
                                <span>Nama Sparepart</span>
                                <span class="separator"></span>
                                <input type="text" class="input-search" placeholder="Input"/>
                            </div>
                        </div>
                        <div class="spare-part-input-type">
                            <div class="input-type-container">
                                <span>Tipe Sparepart</span>
                                <span class="separator"></span>
                                <select class="input-type" name="" id="">
                                    <option value="Komputer/pc">Komputer/pc</option>
                                    <option value="Handphone">Handphone</option>
                                    <option value="Printer">Printer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="button-search button-success-primary-md">Cari</button>
                </div>
                <div class="spare-part-tools">
                    <div class="spare-part-tools-left">
                        <h4>20 Spare Part Aktif</h4>
<!--                        <div class="product-count-bar-container">-->
<!--                            <div class="product-count-bar">-->
<!--                                <div class="product-progress-bar-width"></div>-->
<!--                                <span class="counter">12 / 200</span>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="spare-part-tools-right">
                        <div class="spare-part-tools-right-container">
                            <button class="button-add button-success-primary-md">
                                <i class="fa fa-plus"></i>&nbsp Tambah Spare Part
                            </button>
                            <div class="view-model">
                                <div>
                                    <i class="fa fa-list-ul"></i>
                                </div>
                                <div>
                                    <i class="fa fa-list-ul"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <grid/>
            </div>
        </div>
    </div>
</template>

<script>
import GridList from "./Lists/GridList";

export default {
    name: "Body",
    components: {
        "grid": GridList
    }
}
</script>

<style scoped>
.view-model div {
    display: inline-block;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 2px;
    margin: 0;
}

.view-model div:first-child {
    background: white;
}

.view-model div:hover {

}

.view-model {
    display: inline-block;
    margin-left: 7px;
    background: #efefef;
    border-radius: 2px;
    padding: 5px;
}

.spare-part-tools-right-container {
    float: right;
    display: inline-block;
}

.product-count-bar-container {
    display: inline-block;
    margin-left: 15px;
}

.counter {
    position: relative;
    left: 11px;
    top: 3px;
}

.product-progress-bar-width {
    background: #ff6e06;
    border: 1px solid #ff6e06;
    border-radius: 30px;
    position: absolute;
    width: 40px;
    height: 25px;
}

.product-count-bar {
    width: 200px;
    height: 25px;
    /*background: blue;*/
    border: 1px solid #ff6e06;
    border-radius: 30px;
}

.spare-part-tools {
    padding: 20px;
    display: flex;
}

.spare-part-tools-right {
    width: 100%;
}

.spare-part-tools-left {
    display: flex;
    align-items: center;
    width: 100%;
}

.spare-part-tools-left h4 {
    color: #222;
    font-weight: bold;
    font-size: 22px;
    display: inline-block;
}

.button-search {
    margin-left: 20px;
}

.input-search-container, .input-type-container {
    margin: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 3px;
    display: inline-flex;
    padding: 7px 12px;
    align-items: center;
}

.input-search, .input-type {
    margin-left: 10px;
    width: 290px;
    border: none;
    outline: none;
}

.separator {
    height: 22px;
    width: 1px;
    background: #e0e0e0;
    display: inline-block;
    margin-left: 10px;
    opacity: .7;
}

.spare-part-inputs {
    /*background: red;*/
    /*height: 00px;*/
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.spare-part-input-search, .spare-part-input-type {
    width: 100%;
}

.spare-part-input-search {
    height: 100%;
    /*background: blue;*/
}

.spare-part-input-type {
    /*background: green;*/
}

.spare-part-list-container {
    /*height: 700px;*/
}

.top-navigation ul .router-active {
    border-bottom: 4px solid var(--blue-primary);
    color: var(--blue-primary);
    font-weight: bold;
}

.spare-part-body-container {
    background: white;
    border: 1px solid #e5e5e5;
    margin-bottom: 20px;
}

.top-navigation {
    height: 60px;
    border-bottom: 1px solid #d4d4d4;
    display: flex;
    justify-content: flex-start;
}

.top-navigation ul {
    display: flex;
    flex-direction: row;
    height: 100%;
    margin: 0 0 0 10px;
    padding: 0;
}

.top-navigation ul li {
    display: flex;
    cursor: pointer;
    justify-content: center;
    align-items: center;
    bottom: 0;
    border-bottom: 4px solid white;
    list-style: none;
    position: relative;
    padding: 20px 22px 16px 22px;
    height: 100%;
    margin: 0;
}

.top-navigation ul li:hover {
    color: var(--blue-primary);
    transition: .3s;
}
</style>
