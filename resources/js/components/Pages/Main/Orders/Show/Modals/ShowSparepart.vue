<template>
    <div>
        <div style="display: flex; justify-content: center; align-items: center; position: fixed; z-index: 35; top: 0; bottom: 0; left: 0; right: 0;">
            <div style="background: white; position: relative; overflow-y: auto; z-index: 36; min-height: 140px; max-height: 300px; width: 800px; border-radius: 5px; padding: 20px;">
                <div style="height: 100%;">
                    <div v-for="sparepart in spareparts" style="padding: 30px; border: 1px solid #c6c6c6; border-radius: 5px; height: 100px; margin-bottom: 7px; display: flex; align-items: center; justify-content: flex-start;">
                        <img :src="sparepart.images[0].picture" alt="">
                        <div class="content" style="margin-left: 20px; display: block; height: 70px;">
                            <h5>{{ sparepart.nama }}</h5>
                            <span style="font-family: InterRegular, Arial, sans-serif; font-weight: bold; color: #6F6F6F; display: block;">x{{ sparepart.jumlah }}</span>
                            <span style="font-family: InterRegular, Arial, sans-serif; font-weight: bold; color: #6F6F6F; display: block; margin-top: 3px;">Rp{{ $currency.indonesian(sparepart.harga) }}</span>
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
    props: ["spareparts"],
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
