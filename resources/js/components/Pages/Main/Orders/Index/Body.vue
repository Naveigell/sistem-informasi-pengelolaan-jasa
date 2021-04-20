<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background: white;">
                        <div style="background-color: #f6f7f8; height: 60px; font-family: InterRegular, Arial, sans-serif;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 40px; font-size: 16px;">LIST ORDER</h5>
                                <div style="font-size: 16px;">
                                    <form style="display: inline-block; margin-right: 5px; background-color: #e0e5e8; padding: 5px 10px; border-radius: 3px;" action="" v-on:submit.prevent>
                                        <div>
                                            <input v-model="search.query" v-on:keyup.enter="searchOrder" class="search-input" type="text" style="border: none; display: inline-block; background-color: transparent; outline: none;" placeholder="Search ORDER ID ...">
                                            <div style="background-color: #e0e5e8; display: inline-block;">
                                                <span>
                                                    <i class="fa fa-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                    <span v-on:click="reload" style="display: inline-block; padding: 5px 10px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-refresh"></i></span>
                                    <router-link :to="{ path: '/orders/add' }" style="display: inline-block; padding: 5px 10px; border-radius: 3px; background: #e0e5e8; cursor: pointer; color: #000" v-if="$store.state.user.data.role !== 'teknisi'">
                                        <i class="fa fa-plus"></i>
                                    </router-link>
                                    <div style="display: inline-block; position: relative;">
                                        <div v-on:click="dropdown.open = !dropdown.open; rendered = true;" style="padding: 5px 10px; width: 160px; border-radius: 3px; background: #d9e2f6; color: #25499c; cursor: pointer;">
                                            <span><i class="fa fa-clock-o"></i></span>
                                            <span style="font-weight: 500;">&nbsp{{ statuses.selected === "semua" ? "Semua Status" : statuses.selected.capitalize() }}&nbsp</span>
                                            <span style="display: inline-block; float: right"><i class="fa fa-caret-down"></i></span>
                                        </div>
                                        <div v-if="rendered" class="status-dropdown-container elevation-3 dropdown-animation" v-bind:class="{'dropdown-animation-show': dropdown.open, 'dropdown-animation-hide': !dropdown.open}">
                                            <span v-for="(status, index) in statuses.list" @click="chooseStatus(index)">{{ status === "semua" ? "Semua Status" : status.capitalize() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px;">
                            <table class="table table-striped borderless">
                                <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>DIBUAT</th>
                                    <th>TEKNISI</th>
                                    <th>STATUS</th>
                                    <th>HARGA</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(repairment, index) in repairments">
                                        <td>
                                            <router-link :to="{ path: '/orders/' + repairment.unique_id }">
                                                {{ repairment.unique_id }}
                                            </router-link>
                                        </td>
                                        <td>{{ repairment.created_at_sentences }}</td>
                                        <td>
                                            <span v-if="repairment.technician == null">-</span>
                                            <router-link v-else :to="{ path: '/technician/' + repairment.technician.username }">
                                                {{ repairment.technician.username }}
                                            </router-link>
                                        </td>
                                        <td>
                                            <span class="status" :class="getStatusOrderInfo(repairment.status_service).class">{{ getStatusOrderInfo(repairment.status_service).name }}</span>
                                            <span class="status status-danger" v-if="repairment.complaint !== null ? (repairment.complaint.dikerjakan_teknisi === 0 || repairment.complaint.disetujui_user === 0) : false">Komplain</span>
                                        </td>
                                        <td>{{ pricesString(repairment) }}</td>
                                        <td v-if="$store.state.user.data.role === 'admin'">
                                            <button class="button-warning-primary-tag">
                                                <i class="fa fa-print"></i>
                                            </button>
                                            <button @click="openDeleteModal(repairment)" class="button-danger-primary-tag">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <td v-else-if="$store.state.user.data.role === 'teknisi' && repairment.status_service === 'menunggu'">
                                            <div v-if="repairment.take">
                                                <button class="button-green-primary-tag" @click="take(index)">
                                                    <i class="fa fa-check"></i> Iya
                                                </button>
                                                <button class="button-danger-primary-tag" @click="toggleTakeButton(index, false)">
                                                    <i class="fa fa-times"></i> Tidak
                                                </button>
                                            </div>
                                            <button class="button-success-primary-tag" v-else @click="toggleTakeButton(index, true)">
                                                Ambil
                                            </button>
                                        </td>
                                        <td v-else-if="($store.state.user.data.role === 'teknisi' && repairment.status_service !== 'menunggu') || $store.state.user.data.role === 'user'">
                                            <router-link :to="{ path: '/orders/' + repairment.unique_id }" class="button-warning-primary-tag">
                                                Lihat
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <span @click="retrievePreviousUrl" class="page-pagination">
                                    <span><i class="fa fa-angle-left"></i></span>
                                </span>
                                <span @click="jumpIntoPage(i)" v-for="i in paginator.totalPage" v-if="i === 1 || i === paginator.totalPage || i === paginator.currentPage || i === paginator.currentPage - 1 || i === paginator.currentPage + 1" v-bind:class="{'page-active': paginator.currentPage === i}" class="page-pagination page-button">
                                    <span>{{ i }}</span>
                                </span>
                                <span v-else-if="(i === paginator.currentPage - 2 || i === paginator.currentPage + 2) && !(i === 1 || i === paginator.totalPage)">&nbsp...&nbsp</span>
                                <span @click="retrieveNextUrl" class="page-pagination">
                                    <span><i style="font-weight: bold;" class="fa fa-angle-right"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Delete @response="reload" v-if="modal.delete.open" :order="modal.delete.data" @closeModal="modal.delete.open = false;"/>
    </div>
</template>

<script>
import Delete from "./Modals/Delete";

export default {
    name: "Body",
    components: {
        Delete
    },
    data() {
        return {
            repairments: [],
            repairments_info: [
                {
                    name: "Menunggu",
                    class: "status-danger",
                    enum: "menunggu"
                },
                {
                    name: "Sedang Dicek",
                    class: "status-danger",
                    enum: "dicek"
                },
                {
                    name: "Perbaikan",
                    class: "status-warning",
                    enum: "perbaikan"
                },
                {
                    name: "Selesai",
                    class: "status-info",
                    enum: "selesai"
                },
                {
                    name: "Pembayaran",
                    class: "status-success",
                    enum: "pembayaran"
                },
                {
                    name: "Terima",
                    class: "status-success",
                    enum: "terima"
                }
            ],
            url: {
                endpoints: {
                    current: this.$endpoints.orders.data,
                    next: null,
                    previous: null
                },
                uri: ""
            },
            paginator: {
                perPage: 12,
                currentPage: 1,
                lastPage: 1,
                totalPage: 1,
                totalData: 0
            },
            search: {
                query: "",
                onSearch: false
            },
            dropdown: {
                open: false
            },
            rendered: false,
            statuses: {
                list: ["semua", "menunggu", "dicek", "perbaikan", "selesai", "pembayaran", "diterima"],
                selected: "semua"
            },
            modal: {
                delete: {
                    open: false,
                    data: {
                        id: -1,
                        order: {}
                    }
                }
            }
        }
    },
    mounted() {
        this.retrieveUrl(this.url.endpoints.current);
    },
    methods: {
        pricesString(item){
            switch (item.status_service) {
                case "selesai":
                case "pembayaran":
                case "terima":
                    return `Rp. ${this.$currency.indonesian(item.price)}`;
                default:
                    return "-";
            }
        },
        take(index){
            const id = this.repairments[index].id_service;
            this.$api.post(this.$endpoints.orders.take, {
                id
            }).then((response) => {
                const data = this.repairments[index];
                data.technician     = response.data.body.technician;
                data.status_service = response.data.body.status;

                this.$set(this.repairments, index, data);
            }).catch((error) => {})
        },
        toggleTakeButton(index, take){
            const data = this.repairments[index];
            data.take = take;

            this.$set(this.repairments, index, data);
        },
        openDeleteModal(data){
            this.modal.delete.open = true;
            this.modal.delete.data = data;
        },
        chooseStatus(index){
            this.statuses.selected = this.statuses.list[index];
            this.dropdown.open = false;

            this.searchOrder();
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
        reload(){
            this.jumpIntoPage(this.paginator.currentPage);
        },
        retrieveUrl(url, data = {}) {
            this.repairments = [];

            this.$api.get(url, data).then((response) => {
                this.repairments = response.data.body.orders;

                this.url.endpoints.next     = response.data.body.pages.next_url;
                this.url.endpoints.previous = response.data.body.pages.previous_url;
                this.url.uri                = response.data.body.pages.uri;

                this.paginator.currentPage  = response.data.body.pages.current_page;
                this.paginator.lastPage     = response.data.body.pages.last_page;
                this.paginator.perPage      = response.data.body.pages.per_page;
                this.paginator.totalPage    = Math.ceil(response.data.body.total / response.data.body.pages.per_page);
                this.paginator.totalData    = response.data.body.total;

                this.search.onSearch        = response.data.body.search;

                if (this.$store.state.user.data.role === "teknisi") {
                    this.addTakeOrderBehaviour();
                }

                console.log(response.data.body.orders)
            }).catch((error) => {

            })
        },
        searchOrder(){
            if (this.search.query.length === 0 && this.statuses.selected === "semua") {
                this.retrieveUrl(this.url.endpoints.current);
            } else {
                let params = {};

                if (this.search.query.length > 0) {
                    params["id"] = this.search.query;
                }

                if (this.statuses.selected !== "semua") {
                    params["status"] = this.statuses.selected;
                }

                this.retrieveUrl(this.$endpoints.orders.search, { params });
            }
        },
        addTakeOrderBehaviour(){
            this.repairments = this.repairments.map((item) => {
                if (item.status_service === "menunggu") {
                    item.take = false;
                }
                return item;
            });
        },
        jumpIntoPage(index) {
            if (this.search.onSearch) {
                const querystring = this.$querystring.parse({
                    id: this.search.query,
                    status: this.statuses.selected === "semua" ? "all" : this.statuses.selected,
                    page: index.toString()
                });

                this.retrieveUrl(this.$endpoints.orders.search + querystring);
            } else {
                let url = this.$url.generateUrl(this.url.uri + "/:page");

                this.retrieveUrl(url(index));
            }
        },
        getStatusOrderInfo(status){
            if (status !== undefined) {
                for (const info of this.repairments_info) {
                    if (info.enum === status) {
                        return info;
                    }
                }
            }

            return {};
        }
    }
}
</script>

<style scoped>
@keyframes showdropdown {
    0% {
        transform: translateY(20%);
        opacity: 0;
        visibility: hidden;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }
}

@keyframes hidedropdown {
    0% {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }
    100% {
        transform: translateY(20%);
        opacity: 0;
        visibility: hidden;
    }
}

.dropdown-animation-show {
    animation: showdropdown 0.45s ease forwards;
    -o-animation: showdropdown 0.45s ease forwards;
    -moz-animation: showdropdown 0.45s ease forwards;
    -webkit-animation: showdropdown 0.45s ease forwards;
}

.dropdown-animation-hide {
    animation: hidedropdown 0.45s ease forwards;
    -o-animation: hidedropdown 0.45s ease forwards;
    -moz-animation: hidedropdown 0.45s ease forwards;
    -webkit-animation: hidedropdown 0.45s ease forwards;
}

.status-dropdown-container {
    position: absolute;
    padding: 3px;
    top: 36px;
    left: 0;
    background-color: #fff;
    border-radius: 3px;
    box-shadow: 0 0 5px 1px #d4cece;
    width: 100%;
}

.status-dropdown-container > span {
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
    padding: 12px;
    color: #444444;
    cursor: pointer;
    display: block;
    border-radius: 3px;
    text-decoration: none;
}

.status-dropdown-container > span:hover {
    background-color: #edf0f2;
}

.page-pagination {
    display: inline-block;
    width: 35px;
    height: 35px;
    border-radius: 3px;
    background: #e0e5e8;
    cursor: pointer;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: bold;
    font-size: 15px;
    margin-right: 2px;
    position: relative;
    overflow-x: hidden;
}

.page-button {
    margin-right: 2px;
    margin-left: 2px;
}

.page-active {
    background: #5179d6;
    color: #fff;
}

.page-pagination > span {
    display: block;
    margin: 0;
    padding: 0;
    position: relative;
    text-align: center;
    top: 50%;
    transform: translateY(-50%);
}

.borderless td, .borderless th {
    border: none;
}

.table-striped > tbody > tr {
    margin-top: 20px;
    margin-bottom: 20px;
}

table > tbody > tr > td {
    padding-bottom: 20px;
    padding-top: 20px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
    color: #6c757d;
}

table > tbody > tr > td:first-child, table > thead > tr > th:first-child {
    padding-left: 20px;
}

table > tbody > tr > td:first-child, table > tbody > tr > td:nth-child(3) > a, table > tbody > tr > td:first-child > a {
    color: #5179d6;
    text-decoration: none;
}

table > thead > tr > th {
    padding-bottom: 10px;
    padding-top: 10px;
    color: #000;
    letter-spacing: 1px;
    line-height: 25px;
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f1f4f5;
}

.table-striped > tbody > tr:nth-of-type(even) {
    background-color: #fff;
}

.status {
    padding: 5px 9px;
    border-width: 1px;
    border-radius: 3px;
}

.status-info {
    color: #5cace5;
    background-color: #e0effa;
}

.status-danger {
    color: #e56767;
    background-color: #fbeaea;
}

.status-warning {
    color: #e5ae67;
    background-color: #fbf4ea;
}

.status-success {
    color: #30c78d;
    background-color: #bff0dd;
}
</style>
