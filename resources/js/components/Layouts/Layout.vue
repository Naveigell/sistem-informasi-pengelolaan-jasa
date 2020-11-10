<template>
    <div>
        <app-header/>
        <side-bar/>
    </div>
</template>

<script>
import Header from "../Includes/Header";
import Sidebar from "../Includes/Sidebar";

export default {
    name: "Layout",
    components: {
        'side-bar': Sidebar,
        'app-header': Header
    }
}
</script>

<style scoped>

</style>
