<template>
    <div style="padding: 10px; background-color: white; font-family: InterRegular, Arial, sans-serif;">
        <header style="display: flex; justify-content: space-between; align-items: center; height: 170px;">
            <div>
                <img @load="setImageLoaded(true)" width="330px" height="120px" :src="this.$basepath + 'img/logo/oneya_half.jpg'" alt="">
            </div>
            <div v-if="Object.keys(data).length > 0">
                <span style="font-weight: bold; font-size: 32px;">{{ data.unique_id }}</span>
            </div>
        </header>
        <div style="text-align: center;">
            <h2 style="font-weight: bold; font-size: 32px;">Formulir Service</h2>
        </div>
        <div style="font-family: InterRegular, Arial, sans-serif; margin-top: 40px; padding: 20px; height: calc(100vh - 20%);" v-if="Object.keys(data).length > 0">
            <form action="">
                <br/>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        NAMA
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.nama_pemilik }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        EMAIL
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.user.email }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        ALAMAT
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.alamat_pemilik }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        NO HP
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.user.biodata.nomor_hp === null ? "-" : data.user.biodata.nomor_hp }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        NAMA PERANGKAT
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.nama_perangkat }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        TIPE PERANGKAT
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.jenis_perangkat.toUpperCase() }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        MERK
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp {{ data.merk }}
                    </div>
                </div>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        KODE PERBAIKAN
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        : &nbsp <b>{{ data.unique_id }}</b>
                    </div>
                </div>
                <br><br>
                <div class="row" style="font-size: 28px; margin-bottom: 6px;">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        ALASAN PERBAIKAN
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-4">
                        :
                    </div>
                </div>
                <br>
                <div class="row" style="border: 1px solid rgba(0, 0, 0, 0.2); font-size: 28px; padding: 20px; height: 100%;">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 500px;">
                        {{ data.keluhan }}
                    </div>
                </div>
                <span style="font-size: 20px; color: #dddddd; display: block; padding: 0; margin: 10px 0 0;">Gunakan email mu untuk masuk ke sistem informasi oneya solutions dan melihat perkembangan perbaikan perangkatmu</span>
            </form>
        </div>
<!--        <button v-if="!inPrint" @click="print">Print</button>-->
    </div>
</template>

<script>
export default {
    name: "Body",
    data(){
        return {
            inPrint: false,
            imageLoaded: false,
            dataLoaded: false,
            data: {}
        }
    },
    mounted() {
        this.retrieve();
    },
    methods: {
        print(){
            if (this.dataLoaded && this.imageLoaded) {
                window.print();
            }
        },
        retrieve(){
            const id    = this.$router.currentRoute.params.unique_id;
            const url   = this.$url.generateUrl(this.$endpoints.orders.print);

            this.$api.get(url(id)).then((response) => {
                this.data = response.data.body.order;
                this.setDataLoaded(true);
            }).catch((error) => {
                this.back();
            });
        },
        setImageLoaded(value){
            this.imageLoaded = value;
            this.print();
        },
        setDataLoaded(value) {
            this.dataLoaded = value;
            this.print();
        }
    },
}
</script>

<style scoped>
[v-cloak] {
    visibility: hidden;
}
</style>
