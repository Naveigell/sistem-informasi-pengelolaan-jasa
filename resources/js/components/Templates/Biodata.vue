<template>
    <div>
        <full-loading v-if="loading.fullLoading"/>
        <biodata-component v-else/>
    </div>
</template>

<script>
import BiodataComponent from "../Pages/Main/Biodata/Biodata";

export default {
    name: "Biodata",
    components: {
        "biodata-component": BiodataComponent
    },
    data(){
        return {
            hasLoggedIn: false,
            loading: {
                fullLoading: true
            }
        };
    },
}
</script>

<style scoped>

</style>
