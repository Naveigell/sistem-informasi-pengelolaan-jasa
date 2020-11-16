<template>
    <div class="biodata">
        <full-overlay/>
        <div class="alert-success-biodata-container">
            <div class="alert-success-biodata">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 367.805 367.805" style="enable-background:new 0 0 367.805 367.805;" xml:space="preserve">
                    <g>
                        <path style="fill:#3BB54A;" d="M183.903,0.001c101.566,0,183.902,82.336,183.902,183.902s-82.336,183.902-183.902,183.902 S0.001,285.469,0.001,183.903l0,0C-0.288,82.625,81.579,0.29,182.856,0.001C183.205,0,183.554,0,183.903,0.001z"/>
                        <polygon style="fill:#D4E1F4;" points="285.78,133.225 155.168,263.837 82.025,191.217 111.805,161.96 155.168,204.801 256.001,103.968"/>
                    </g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                </svg>
                <span>Biodata berhasil diubah.</span>
            </div>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../Overlays/FullOverlay";

export default {
    name: "BiodataUpdateSuccess",
    components: {
        'full-overlay': FullOverlay
    },
    mounted() {
        const self = this;
        const countDownID = setInterval(function () {
            clearInterval(countDownID);
            self.$emit('destroyed');
        }, 2100);
    }
}
</script>

<style scoped>
    svg {
        top: 0;
        left: 0;
        width: 50px;
        height: 50px;
    }

    span {
        font-size: 17px;
        margin-top: 10px;
    }

    @keyframes show {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .alert-success-biodata-container {
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        top: 0;
        z-index: 30;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: show .15s linear;
    }

    .alert-success-biodata {
        width: 400px;
        height: 140px;
        background: white;
        border-radius: 4px;
        box-shadow: 0 0 1px #555;
        margin: auto auto;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
