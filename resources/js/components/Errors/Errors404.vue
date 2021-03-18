<template>
    <div class="error-body">
        <h1>404 not found</h1>
        <router-link :to="{ path: '/' }">Kembali ke beranda</router-link>
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
