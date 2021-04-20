<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-1 parent-deck">
                    <div class="deck elevation-2">
                        <div class="deck-content-container">
                            <div class="deck-content row">
                                <div class="col-8">
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">{{ total.orders }}</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Total Orders</span>
                                </div>
                                <div class="col-4" style="background-color: transparent; display: flex; align-items: center;">
                                    <div class="deck-icon-container" style="background-color: #edf0f2; width: 100%; text-align: center; padding: 15px; border-radius: 3px;">
                                        <i style="font-size: 30px; color: #5179d6;" class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deck-bottom">
                            <div style="padding-left: 25px; padding-right: 20px;">
                                <span style="color: #5179d6; font-weight: 500;">Lihat Semua Pegawai &nbsp <i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-1 parent-deck">
                    <div class="deck elevation-2">
                        <div class="deck-content-container">
                            <div class="deck-content row">
                                <div class="col-8">
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">{{ total.technicians }}</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Technicians</span>
                                </div>
                                <div class="col-4" style="background-color: transparent; display: flex; align-items: center;">
                                    <div class="deck-icon-container" style="background-color: #edf0f2; width: 100%; text-align: center; padding: 15px; border-radius: 3px;">
                                        <i style="font-size: 30px; color: #5179d6;" class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deck-bottom">
                            <div style="padding-left: 25px; padding-right: 20px;">
                                <span style="color: #5179d6; font-weight: 500;">Lihat Semua Pegawai &nbsp <i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-1 parent-deck">
                    <div class="deck elevation-2">
                        <div class="deck-content-container">
                            <div class="deck-content row">
                                <div class="col-8">
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">{{ total.users }}</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Active Users</span>
                                </div>
                                <div class="col-4" style="background-color: transparent; display: flex; align-items: center;">
                                    <div class="deck-icon-container" style="background-color: #edf0f2; width: 100%; text-align: center; padding: 15px; border-radius: 3px;">
                                        <i style="font-size: 30px; color: #5179d6;" class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deck-bottom">
                            <div style="padding-left: 25px; padding-right: 20px;">
                                <span style="color: #5179d6; font-weight: 500;">Lihat Semua Pegawai &nbsp <i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-1 parent-deck">
                    <div class="deck elevation-2">
                        <div class="deck-content-container">
                            <div class="deck-content row">
                                <div class="col-8">
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">170</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Messages</span>
                                </div>
                                <div class="col-4" style="background-color: transparent; display: flex; align-items: center;">
                                    <div class="deck-icon-container" style="background-color: #edf0f2; width: 100%; text-align: center; padding: 15px; border-radius: 3px;">
                                        <i style="font-size: 30px; color: #5179d6;" class="fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deck-bottom">
                            <div style="padding-left: 25px; padding-right: 20px;">
                                <span style="color: #5179d6; font-weight: 500;">Lihat Semua Pegawai &nbsp <i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="$store.state.user.data.role === 'admin'" class="row" style="margin-bottom: 17px;">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2 summary-container" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">PENDAPATAN DARI BULAN KE BULAN</h5>
                                <div>
                                    <span style="display: inline-block; padding: 3px 8px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-print"></i></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px;">
                            <BarChart v-bind:data="graph.data" :options="graph.options"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2 summary-container" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">PERBAIKAN TERBARU</h5>
                                <div>
                                    <span @click="retrieveOrders" style="display: inline-block; padding: 3px 8px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-refresh"></i></span>
                                    <span style="display: inline-block; padding: 3px 8px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-plus"></i></span>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="repairment in repairments">
                                        <td>
                                            <router-link :to="{ path: '/orders/' + repairment.unique_id }">
                                                {{ repairment.unique_id }}
                                            </router-link>
                                        </td>
                                        <td>{{ repairment.created_at_sentences }}</td>
                                        <td>
                                            <router-link :to="{ path: '/technician' }">
                                                {{ repairment.technician == null ? "-" : repairment.technician.username }}
                                            </router-link>
                                        </td>
                                        <td>
                                            <span class="status" :class="getStatusOrderInfo(repairment.status_service).class">{{ getStatusOrderInfo(repairment.status_service).name }}</span>
                                        </td>
                                        <td>{{ Math.random() > 0.7 ? "-" : "Rp 20.000" }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BarChart from "../../../Shared/Charts/BarChart";
import LineChart from "../../../Shared/Charts/LineChart";

export default {
    name: "Body",
    components: {
        BarChart,
        LineChart,
    },
    data() {
        return {
            graph: {
                data: {},
                options: {}
            },
            total: {
                orders: 0,
                technicians: 0,
                users: 0
            },
            repairments: ['status-danger', 'status-warning', 'status-success', 'status-info'],
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
            ]
        }
    },
    mounted() {
        this.retrieveTotal();
        this.retrieveOrders();
        this.retrieveGraph();
    },
    methods: {
        retrieveGraph(){
            this.$api.get(this.$endpoints.dashboard.graph).then((response) => {
                const data = response.data.body.graph.data;
                const options = response.data.body.graph.options;

                // part of options
                const firstYAxes = options?.scales.yAxes[0];
                const tooltips = options?.tooltips;

                if (firstYAxes !== null) {
                    firstYAxes.ticks.callback = (value, index, values) => {
                        return `Rp. ${this.$currency.indonesian(value)}`;
                    }
                }

                if (tooltips !== null) {
                    tooltips.callbacks = {
                        label: (item, data) => {
                            return "Pemasukan: Rp. " + this.$currency.indonesian(item.yLabel);
                        }
                    }
                }

                this.graph.options = options;
                this.graph.data = data;

            }).catch((error) => {
                console.log(error);
            })
        },
        random(){
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        },
        retrieveTotal(){
            this.$api.get(this.$endpoints.dashboard.total).then((response) => {
                this.total = response.data.body.total;
            }).catch((error) => {
                console.error(error)
            });
        },
        async retrieveOrders() {
            const temporary = this.repairments;
            this.repairments = [];
            const url = this.$url.generateUrl(this.$endpoints.orders.last);

            await this.$api.get(url(10)).then((response) => {
                this.repairments = response.data.body.orders;
            }).catch((error) => {
                console.error(error)
                this.repairments = temporary;
            });
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
.parent-deck {
    margin-bottom: 17px;
}

.deck {
    background: white;
    height: 150px;
    position: relative;
}

.deck-content {
    margin: 10px;
    /*background-color: red;*/
    width: 100%;
    height: calc(100% - 20px);
    font-family: InterRegular, Arial, sans-serif;
}

.deck-content-container {
    height: 72%;
    display: flex;
    align-items: center;
}

.deck-bottom {
    background-color: #f6f7f8;
    height: 28%;
    display: flex;
    align-items: center;
}

.summary-container {
    /*height: 1000px;*/
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

table > tbody > tr > td:first-child > a, table > tbody > tr > td:nth-child(3) > a {
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
