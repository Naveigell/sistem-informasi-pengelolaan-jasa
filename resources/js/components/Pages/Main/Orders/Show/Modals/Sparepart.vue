<template>
    <div>
        <div style="display: flex; justify-content: center; align-items: center; position: fixed; z-index: 35; top: 0; bottom: 0; left: 0; right: 0;">
            <div style="background: white; position: relative; z-index: 36; height: 300px; width: 800px; border-radius: 5px; padding: 20px;">
                <div style="height: 100%; overflow-y: scroll;">
                    <div style="padding: 30px; border: 1px solid #c6c6c6; border-radius: 5px; height: 100px; margin-bottom: 7px; margin-right: 3px; display: flex; align-items: center; justify-content: flex-start;" v-for="i in 9">
                        <img src="https://cdn0-production-images-kly.akamaized.net/15LqrrN-hJG4VISdwL7WP85pC4g=/640x360/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1607481/original/000851700_1496032747-RAM.jpg" alt="">
                        <div class="content" style="margin-left: 20px; display: block; height: 70px;">
                            <h5>OPPO RENO 4F RAM 8/128 GARANSI RESMI OPPO INDONESIA - Demo Tanpa Dus</h5>
                            <span style="font-family: InterRegular, Arial, sans-serif; font-weight: bold; color: #6F6F6F;">x6</span>
                        </div>
                    </div>
                </div>
            </div>
            <FullOverlay @clicked="closeModal"/>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "Sparepart",
    components: {
        FullOverlay
    },
    methods: {
        closeModal(){
            this.$emit("close");
            document.body.style.overflow = 'visible';
        }
    }
}
</script>

<style scoped>
img {
    height: 70px;
    width: 70px;
    border: 1px solid #c6c6c6;
    border-radius: 5px;
}
</style>
