<template>
    <div class="application">
        <app-layout :el="body" v-bind:username="username"/>
    </div>
</template>

<script>
import Body from "./Body";

export default {
    name: "Technician",
    props: ["username"],
    data() {
        return {
            body: Body
        }
    }
}
</script>

<style scoped>

</style>
