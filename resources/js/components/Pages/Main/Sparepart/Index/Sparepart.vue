<template>
    <div class="application">
        <app-layout :el="body"/>
    </div>
</template>

<script>
import Body from "./Body";

export default {
    name: "Sparepart",
    data() {
        return {
            body: Body
        }
    }
}
</script>

<style scoped>

</style>
