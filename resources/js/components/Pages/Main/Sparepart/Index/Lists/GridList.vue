<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="product-grid-container">
                    <a v-bind:href="'/sparepart/' + sparepart.id" class="product-grid" v-for="sparepart in spareparts">
                        <div>
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
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "GridList",
    props: ["spareparts"],
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>

<style scoped>
.pages-button {
    padding: 3px 9px;
    background: transparent;
    border: 1px solid #d2d2d2;
    border-radius: 2px;
    outline: none;
}

.pages-button:hover {
    background: #f1f1f1;
}

.pagination-jumper-input {
    border: 1px solid #d2d2d2;
    border-radius: 2px;
    outline: none;
    width: 40px;
    padding: 3px 9px;
}

.pagination-jumper-button {
    background: var(--blue-primary);
    border: 1px solid var(--blue-primary);
    border-radius: 2px;
    outline: none;
    padding: 3px 9px;
    color: white;
}

.pages-active {
    background: var(--blue-primary);
    border: 1px solid var(--blue-primary);
    color: white;
}

.pagination-jumper {
    margin-left: 30px;
}

.page-pagination {
    font-size: 25px;
    cursor: pointer;
}

.pagination {
    margin: 30px 30px 30px 45px;
    display: flex;
    align-items: center;
}

.active-pages {
    display: inline-block;
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
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.product-grid {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    display: inline-block;
    width: 186px;
    height: 300px;
    margin: 5px;
    flex-grow: 0;
    flex-shrink: 1;
    text-decoration: none;
    /*flex-basis: calc(20% - 5px);*/
}

.product-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
</style>
