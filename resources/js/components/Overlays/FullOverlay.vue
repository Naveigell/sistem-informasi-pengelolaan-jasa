<template>
    <div class="overlay-container" v-on:click="overlayClicked()">
        <div class="overlay"></div>
    </div>
</template>

<script>
export default {
    name: "FullOverlay",
    mounted() {
        document.body.style.overflow = "hidden";
    },
    methods: {
        overlayClicked(){
            this.$emit("clicked", true);
        }
    }
}
</script>

<style scoped>
    .overlay-container {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(34, 34, 34, .6);
        position: fixed;
        /*opacity: .6;*/
        z-index: 20;
        overflow-y: hidden;
    }
</style>
