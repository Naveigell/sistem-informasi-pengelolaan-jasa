<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-1 parent-deck">
                    <div class="deck elevation-2">
                        <div class="deck-content-container">
                            <div class="deck-content row">
                                <div class="col-8">
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">32</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Pending Orders</span>
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
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">142</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Pending Orders</span>
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
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">142</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Pending Orders</span>
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
                                    <h3 style="font-weight: bolder; font-size: 30px; font-family: InterRegular, Arial, sans-serif;">170</h3>
                                    <span style="font-family: InterRegular, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #515151;">Pending Orders</span>
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
            <div class="row" style="margin-bottom: 17px;">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2 summary-container" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">PENDAPATAN MINGGU INI</h5>
                            </div>
                        </div>
                        <div style="padding: 20px;">
                            <BarChart v-bind:data="data"/>
                        </div>
                    </div>
                </div>
<!--                <div class="col-sm-12 col-md-12 col-lg-4">-->
<!--                    <div class="elevation-2 summary-container" style="background-color: white;">-->
<!--                        11111111111111111-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2 summary-container" style="background-color: white;">
                        <div style="background-color: #f6f7f8; height: 43px;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">PERBAIKAN TERBARU</h5>
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
                                        <td>ORD.00965</td>
                                        <td>12 menit lalu</td>
                                        <td>ditya.jelita</td>
                                        <td>
                                            <span class="status" :class="['status-danger', 'status-warning', 'status-success', 'status-info'].random()">{{ ["Menunggu", "Sedang Dicek", "Pembayaran", "Perbaikan", "Terima"].random() }}</span>
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
import Chart from "../../../Shared/Chart";
import BarChart from "../../../Shared/Charts/BarChart";
import LineChart from "../../../Shared/Charts/LineChart";

export default {
    name: "Body",
    components: {
        BarChart,
        LineChart,
        Chart
    },
    data() {
        return {
            data: {
                labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
                datasets: [
                    {
                        label: 'Minggu Sebelumnya',
                        borderColor: ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                        backgroundColor: ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                        borderWidth: 1,
                        data: [this.random(), this.random(), this.random(), this.random(), this.random(), this.random(), this.random()]
                    },
                    {
                        label: 'Minggu Ini',
                        borderColor: ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                        backgroundColor: ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                        borderWidth: 1,
                        data: [this.random(), this.random(), this.random(), this.random(), this.random(), this.random(), this.random()]
                    },
                ]
            },
            repairments: [
                1, 1,1 ,1 ,1, 1,1 ,1, 1, 1
            ]
        }
    },
    methods: {
        random(){
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        },
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

table > tbody > tr > td:first-child, table > tbody > tr > td:nth-child(3) {
    color: #5179d6;
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
    padding: 5px;
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
