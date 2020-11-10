<template>
    <div class="app-container">
        {{ CurrentComponent }}
    </div>
</template>

<script>
export default {
    name: "Container",
    props: ["CurrentComponent"],
}
</script>

<style scoped>
</style>
