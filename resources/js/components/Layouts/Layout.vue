<template>
    <div class="application">
        <app-header/>
        <app-sidebar/>
        <component :is="el" v-bind:id="id">
            <slot></slot>
        </component>
    </div>
</template>

<script>
export default {
    name: "Layout",
    props: {
        el: {
            type: [String, Object],
            default: 'div',
        },
        id: {
            type: [String, Number],
            default: null
        }
    }
}
</script>

<style scoped>
</style>
