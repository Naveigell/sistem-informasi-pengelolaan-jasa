<template>
    <div class="error-body">
        <h1>404 not found</h1>
        <a href="/">Kembali ke beranda</a>
    </div>
</template>

<script>
export default {
    name: "Errors404"
}
</script>

<style scoped>
h1 {
    font-size: 30px;
}

.error-body {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}
</style>
