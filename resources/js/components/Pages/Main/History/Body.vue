<template>
    <div style="padding: 20px;">
        <div v-for="(history, index) in histories" class="row" style="padding: 3px; margin: 5px; border: 1px solid #cacaca;">
            <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1">
                {{ index + 1 }}
            </div>
            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                {{ history.content }}
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                {{ history.created_at }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Body",
    data(){
        return {
            histories: []
        }
    },
    mounted() {
        this.retrieve();
    },
    methods: {
        retrieve(){
            this.$api.get(this.$endpoints.history.data).then((response) => {
                this.histories = response.data.body.histories;
            }).catch((error) => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
