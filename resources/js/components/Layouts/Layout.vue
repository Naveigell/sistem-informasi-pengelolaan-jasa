<template>
    <div class="application">
        <app-header/>
        <app-sidebar/>
        <component :is="el" v-bind:id="id" v-bind:username="username">
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
        },
        username: {
            type: [String, Object],
            default: null
        }
    }
}
</script>

<style scoped>
</style>
