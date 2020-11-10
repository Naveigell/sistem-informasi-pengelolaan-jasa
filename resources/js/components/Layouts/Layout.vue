<template>
    <div class="application">
        <app-header/>
        <app-sidebar/>
        <component :is="el">
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
        }
    }
}
</script>

<style scoped>
</style>
