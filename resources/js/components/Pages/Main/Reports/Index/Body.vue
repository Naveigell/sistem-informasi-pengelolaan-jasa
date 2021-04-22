<template>
    <div class="app-container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="elevation-2" style="background-color: white;">
                    <div style="background-color: #f6f7f8; height: 43px;">
                        <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                            <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 25px;">LAPORAN</h5>
                        </div>
                    </div>
                    <div style="padding: 30px;">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 7px; font-family: InterRegular, Arial, sans-serif;">
                                <span v-if="info.success" class="label label-success">Download berhasil</span>
                                <span v-if="info.failed" class="label label-danger">Download gagal</span>
                                <h4>Pilih Bulan</h4>
                            </div>
                            <div class="col-md-12">
                                <div class="input-container">
                                    <input v-model="date" type="month" value="">
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 7px;">
                                <button @click="download" class="download-button download-button-blue"><i class="fa fa-download"></i>&nbsp{{ loading.onLoading ? loading.text : "Excel" }}</button>
                                <button class="download-button download-button-red"><i class="fa fa-download"></i>&nbsp{{ loading.onLoading ? loading.text : "Pdf" }}</button>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Body",
    data() {
        return {
            date: "",
            loading: {
                text: "Mengunduh .",
                onLoading: false,
                id: null
            },
            info: {
                success: false,
                failed: false
            }
        }
    },
    methods: {
        startAnimation(){
            this.loading.onLoading = true;
            let offset = 1;
            this.id = setInterval(() => {
                offset++;
                if (offset === 4) {
                    offset = 1;
                }

                switch (offset) {
                    case 1:
                        this.loading.text = "Mengunduh .";
                        break;
                    case 2:
                        this.loading.text = "Mengunduh ..";
                        break;
                    default:
                        this.loading.text = "Mengunduh ...";
                        break;
                }
            }, 500);
        },
        stopAnimation(){
              clearInterval(this.loading.id);
              this.loading.onLoading = false;
        },
        download(){
            if (this.date === "" || this.loading.onLoading) {
                return;
            }
            const date = this.date.split("-");
            const month = date[1];
            const year = Number(date[0]);

            this.startAnimation();

            this.info.failed =
            this.info.success = false;

            const url = this.$url.generateUrl(this.$endpoints.exports.finance.excel);
            this.$api.get(url("finance", "excel"), {
                responseType: "arraybuffer",
                params: {
                    month, year
                }
            }).then((response) => {
                this.$exporter.generate(response.data, "application/excel", "xlsx");
                this.stopAnimation();
                this.info.success = true;
            }).catch((error) => {
                this.stopAnimation();
                this.info.failed = true;
            });
        },
    }
}
</script>

<style scoped>
.input-container input, .input-container textarea, .input-container select {
    width: 100%;
    font-size: 14px;
    outline: none;
    border: 1px solid #cfcfcf;
    border-radius: 3px;
    padding: 7px 7px 7px 9px;
}

label {
    color: #555;
}

.download-button {
    box-sizing: border-box;
    text-align: center;
    /*width: 100%;*/
    padding: 5px 20px;
    height: 42px;
    outline: none;
    border: none;
    border-radius: 3px;
    border-bottom: 4px solid rgba(0, 0, 0, 0.1);
    color: white;
    font-size: 17px;
}

.download-button:active {
    border-bottom: 3px solid rgba(0, 0, 0, 0.1);
    transform: translateY(1px);
}

.download-button-blue {
    background-color: #51ADED;
}

.download-button-blue:hover {
    background-color: #51adff;
}

.download-button-red {
    background-color: #ed5151;
}

.download-button-red:hover {
    background-color: #ff5151;
}

.download-button:focus {
    outline: none;
}
</style>
