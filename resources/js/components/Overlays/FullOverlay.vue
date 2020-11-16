<template>
    <div class="overlay-container">
        <div class="overlay"></div>
    </div>
</template>

<script>
export default {
    name: "FullOverlay"
}
</script>

<style scoped>
    .overlay-container {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #222;
        position: absolute;
        opacity: .6;
        z-index: 20;
    }
</style>
