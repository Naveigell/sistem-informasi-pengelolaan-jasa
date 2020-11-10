<template>
    <div class="loading-container">
        <div class="loading-icon">
            <div class="loading-icon-small"></div>
        </div>
        <span style="margin-left: 20px" class="loading-text">
            Loading ...
        </span>
    </div>
</template>

<script>
export default {
    name: "FullLoading",
}
</script>

<style scoped>
.loading-container {
    align-items: center;
    height: 100vh;
    display: flex;
    justify-content: center;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: white;
    z-index: 11;
}

.loading-text {
    font-size: 25px;
    font-weight: bold;
}

.loading-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--blue-primary);
    display: flex;
    justify-content: center;
    align-items: center;
    animation: spin 2s infinite;
}

.loading-icon-small {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: white;
    display: inline-block;
    animation: spin-small 1s infinite;
}

@keyframes spin-small {
    0% {
        width: 30px;
        height: 30px;
    }
    50% {
        width: 25px;
        height: 25px;
    }
    100% {
        width: 30px;
        height: 30px;
    }
}

@keyframes spin {
    0% {
        transform: rotateY(0deg);
    }
    50% {
        transform: rotateY(360deg);
    }
    100% {
        transform: rotateY(0deg);
    }
}
</style>
