<template>
    <div class="application">
        <app-layout :el="body" v-bind:id="id"/>
    </div>
</template>

<script>
import Body from "./Body";

export default {
    name: "Sparepart",
    props: ["id"],
    data() {
        return {
            body: Body
        }
    }
}
</script>

<style scoped>

</style>
