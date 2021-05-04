<template>
    <div class="app-container">
        <div class="technician-body-container">
            <div class="top-navigation">
                <ul>
                    <li class="router-active">Semua</li>
                </ul>
            </div>
            <div class="technician-list-container">
                <div class="technician-input-container">
                    <div class="technician-inputs">
                        <div class="technician-input-search">
                            <div class="input-search-container">
                                <span>Nama Teknisi</span>
                                <span class="separator"></span>
                                <input v-model="search.query" type="text" class="input-search" placeholder="Input"/>
                            </div>
                        </div>
                    </div>
                    <button @click="searchTechnicians()" class="button-search button-success-primary-md">Cari</button>
                </div>
                <div class="technician-tools">
                    <div class="technician-tools-left">
                        <h4>{{ paginator.totalData }} Teknisi Aktif</h4>
                    </div>
                    <div class="technician-tools-right" v-if="this.$role.isAdmin">
                        <div class="technician-tools-right-container">
                            <button @click="modal.insert.open = true" class="button-add button-success-primary-md" style="padding: 10px 20px;">
                                <i class="fa fa-plus"></i>&nbsp Tambah Teknisi
                            </button>
                            <div class="view-model">
                                <div>
                                    <i class="fa fa-list-ul"></i>
                                </div>
                                <div>
                                    <i class="fa fa-list-ul"></i>
                                </div>
                            </div>
                            <button class="button-add button-danger-md" v-on:click="mode.onDeleteMode = !mode.onDeleteMode; overlay.full = true;" style="margin-left: 7px;">
                                {{ mode.onDeleteMode ? "Batal Hapus" : "Hapus" }}
                            </button>
                        </div>
                    </div>
                </div>
                <grid v-bind:technicians="technicians" :on-delete-mode="mode.onDeleteMode"/>
                <div class="pagination">
                    <span @click="retrievePreviousUrl()" class="to-left-page-pagination page-pagination"><i class="fa fa-angle-left"></i></span>
                    <div class="active-pages" style="margin-left: 12px;">
                        <button @click="jumpIntoPage(i)" v-for="i in paginator.totalPage" v-if="i === 1 || i === paginator.totalPage || i === paginator.currentPage || i === paginator.currentPage - 1 || i === paginator.currentPage + 1" class="pages-button" v-bind:class="{'pages-active': paginator.currentPage === i}">{{ i }}</button>
                        <span v-else-if="(i === paginator.currentPage - 2 || i === paginator.currentPage + 2) && !(i === 1 || i === paginator.totalPage)">&nbsp...&nbsp</span>
                    </div>
                    <span @click="retrieveNextUrl()" class="to-left-page-pagination page-pagination" style="margin-left: 12px;"><i class="fa fa-angle-right"></i></span>
                    <div class="pagination-jumper">
                        <span>Ke halaman : </span>
                        <input v-model="jumper.jumperInput" type="text" class="pagination-jumper-input" placeholder="1">
                        <button @click="jumpIntoPage(jumper.jumperInput)" class="pagination-jumper-button">Pergi</button>
                    </div>
                </div>
            </div>
        </div>
        <Insert v-if="modal.insert.open" @onAnimationEnd="closeModal(modal.insert)" @response="reload"/>
    </div>
</template>

<script>
import GridList from "./Lists/GridList";
import Insert from "./Modals/Insert";

export default {
    name: "Body",
    components: {
        grid: GridList,
        Insert,
    },
    data(){
        return {
            technicians: [],
            url: {
                endpoints: {
                    current: this.$endpoints.technicians.data,
                    next: null,
                    previous: null
                },
                uri: ""
            },
            jumper: {
                jumperInput: ""
            },
            paginator: {
                perPage: 10,
                currentPage: 1,
                lastPage: 1,
                totalPage: 1,
                totalData: 0
            },
            search: {
                query: "",
                onSearch: false
            },
            mode: {
                onDeleteMode: false
            },
            overlay: {
                full: false
            },
            modal: {
                insert: {
                    open: false
                }
            },
        }
    },
    mounted() {
        this.retrieveUrl(this.url.endpoints.current);
    },
    methods: {
        closeModal(modal) {
            modal.open = false;
        },
        reload(){
            this.retrieveUrl(this.url.endpoints.current);
        },
        retrieveNextUrl(){
            const next = this.url.endpoints.next;
            if (next !== null) {
                this.retrieveUrl(next);
            }
        },
        retrievePreviousUrl(){
            const previous = this.url.endpoints.previous;
            if (previous !== null) {
                this.retrieveUrl(previous);
            }
        },
        retrieveUrl(url, data = {}){
            const self = this;

            this.$api.get(url, data).then(function (response) {
                const res = response.data.body;

                self.technicians = res.technicians;

                self.url.endpoints.next     = res.pages.next_url;
                self.url.endpoints.previous = res.pages.previous_url;
                self.url.endpoints.current  = res.pages.current_url;
                self.url.uri                = res.pages.uri;

                self.paginator.currentPage  = res.pages.current_page;
                self.paginator.lastPage     = res.pages.last_page;
                self.paginator.perPage      = res.pages.per_page;
                self.paginator.totalPage    = Math.ceil(res.total / res.pages.per_page);
                self.paginator.totalData    = res.total;

                self.search.onSearch        = res.search;
            }).catch(function (error) {
                console.error(error)
            });
        },
        jumpIntoPage(index) {
            //
            // if in search mode, use params
            //

            if (this.search.onSearch) {
                this.retrieveUrl(this.$endpoints.technicians.search, {
                    params: {
                        q: this.search.query,
                        p: index
                    }
                });
            } else {
                let url = this.$url.generateUrl(this.url.uri + "/:page");

                this.retrieveUrl(url(index));
            }
        },
        searchTechnicians(){
            this.retrieveUrl(this.$endpoints.technicians.search, {
                params: {
                    q: this.search.query,
                }
            });
        }
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

.technician-tools-right-container {
    float: right;
    display: inline-block;
}

.pages-button {
    padding: 3px 9px;
    background: transparent;
    border: 1px solid #d2d2d2;
    border-radius: 2px;
    outline: none;
    margin: 2px;
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

.pages-active, .pages-active:hover {
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

.technician-tools {
    padding: 20px;
    display: flex;
}

.technician-tools-right {
    width: 100%;
}

.technician-tools-left {
    display: flex;
    align-items: center;
    width: 100%;
}

.technician-tools-left h4 {
    color: #222;
    font-weight: bold;
    font-size: 22px;
    display: inline-block;
}

.button-search {
    margin-left: 20px;
}

.input-search-container {
    margin: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 3px;
    display: inline-flex;
    padding: 7px 12px;
    align-items: center;
}

.input-search {
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

.technician-inputs {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.technician-input-search {
    width: 100%;
}

.technician-input-search {
    height: 100%;
    /*background: blue;*/
}

.technician-list-container {
    /*height: 700px;*/
}

.top-navigation ul .router-active {
    border-bottom: 4px solid var(--blue-primary);
    color: var(--blue-primary);
    font-weight: bold;
}

.technician-body-container {
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
    -o-transition: .3s;
    -moz-transition: .3s;
    -webkit-transition: .3s;
}
</style>
