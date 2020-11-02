<template>
    <div class="container">
        <login-component/>
    </div>
</template>

<script>
    import LoginComponent from "./Pages/Login/LoginComponent";

    export default {
        components: {
            'login-component': LoginComponent
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
