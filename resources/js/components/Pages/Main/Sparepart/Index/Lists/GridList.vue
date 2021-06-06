<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="product-grid-container">
                    <div class="product-grid" v-for="(sparepart, index) in spareparts">
                        <router-link v-bind:to="{ path: '/sparepart/' + sparepart.id }" style="text-decoration: none;">
                            <img width="100%" height="170" :src="sparepart.images[0].picture" alt="sparepart">
                            <hr/>
                            <span class="product-title">
                                {{ sparepart.nama }}
                            </span>
                            <div class="product-info">
                                <span class="product-price">
                                    Rp{{ $currency.indonesian(sparepart.harga) }}
                                </span>
                                <span class="product-stock">
                                    Stok {{ sparepart.stok }}
                                </span>
                            </div>
                            <div class="product-meta">
                                <span class="product-type">
                                    <i class="fas fa-box"></i> {{ sparepart.tipe }}
                                </span>
                            </div>
                            <br/>
                        </router-link>
                        <transition name="product-delete-container-transition">
                            <div key="delete" class="product-delete-container" v-if="onDeleteMode">
                                <span v-on:click="openDeleteModal(sparepart.id, sparepart, index)">
                                    <i class="fa fa-trash"></i> Hapus
                                </span>
                            </div>
                        </transition>
                    </div>
                    <delete-modal @onAnimationEnd="onDeleteModalAnimationEnd" :sparepart="data.sparepart" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";

export default {
    name: "GridList",
    props: ["spareparts", "onDeleteMode"],
    components: {
        "delete-modal": Delete,
    },
    data() {
        return {
            data: {
                id: -1,
                sparepart: null,
                index: -1
            },
            modal: {
                delete: false
            },
        }
    },
    methods: {
        openDeleteModal(id, sparepart, index){
            this.data.id = id;
            this.data.sparepart = sparepart;
            this.data.index = index;
            this.modal.delete = true;
        },
        onDeleteModalAnimationEnd(){
            const self = this;
            const id = setTimeout(function () {
                self.spareparts.splice(self.data.index, 1);
                clearTimeout(id);
            }, 800);
        }
    }
}
</script>

<style scoped>
.product-delete-container-transition-enter-active {
    transition: all .3s ease;
    -o-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -webkit-transition: all .3s ease;
}

.product-delete-container-transition-leave-active {
    transition: all .1s ease;
    -o-transition: all .1s ease;
    -moz-transition: all .1s ease;
    -webkit-transition: all .1s ease;
}

.product-delete-container-transition-enter, .product-delete-container-transition-leave-to {
    opacity: 0;
}

.delete-transition-ended-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.delete-transition-ended-leave {
    opacity: 1;
}

.delete-transition-ended-leave-to {
    opacity: 0;
}

.product-delete-container {
    border-top: 1px solid #dedede;
    width: 184px;
    background: white;
    color: var(--red-primary);
}

.product-delete-container > span {
    display: block;
    text-align: center;
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.product-delete-container > span > i {
    font-size: 16px;
    padding-right: 4px;
}

.grid-container {
    width: 100%;
    height: 100%;
}

.grid {
    padding: 20px;
    margin: 20px;
}

.product-info {
    margin-top: 8px;
    margin-right: 10px;
    margin-left: 10px;
}

.product-type {
    float: right;
    font-size: 12px;
    margin-right: 10px;
    color: #a4a4a4;
}

.product-price {
    color: var(--blue-primary);
    font-weight: bold;
}

.product-stock {
    float: right;
    color: #a4a4a4;
}

.product-meta {
    padding-bottom: 7px;
}

.product-grid-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.product-title {
    margin-left: 10px;
    margin-right: 10px;
    margin-top: 1em;
    color: #222;
    display: block;
    display: -webkit-box;
    max-width: 100%;
    height: 32px;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.15;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-grid:hover {
    /*height: 340px;*/
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.product-grid:hover .product-delete-container {
    display: block;
}

.product-grid {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    display: inline-block;
    width: 186px;
    height: calc(100% + 30px);
    position: relative;
    margin: 5px 5px 12px;
    flex-grow: 0;
    flex-shrink: 1;
    text-decoration: none;
    /*flex-basis: calc(20% - 5px);*/
}

.product-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

hr {
    margin: 0;
}
</style>
