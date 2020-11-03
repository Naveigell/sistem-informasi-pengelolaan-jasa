<template>
    <div class="login-container">
        <div class="form-container">
            <form v-on:submit.prevent>
                <h3>Oneya Solutions</h3>
                <div class="sub-title">
                    <span>
                        Selamat Datang di Sistem Informasi Oneya Solutions
                        disini menyediakan berbagai jasa seperti merakit pc,
                        service hp, service printer dan lain sebagainya.
                    </span>
                </div>
                <input v-model="input.email" class="input-form-text" style="margin-top: 40px;" placeholder="Email ..." id="email" type="email">
                <span class="sub-message">Masukkan emailmu disini. Cth: oneya@solutions.com</span>
                <input v-model="input.password" class="input-form-text" placeholder="Password ..." id="password" type="password">
                <span class="sub-message">Masukkan passwordmu disini.</span>
                <div class="option">
                    <span>
                        <input type="checkbox">
                        <span style="position:relative; bottom: 3px; left: 4px;">Ingat Saya</span>
                    </span>
                    <a id="forget-password" href="">Lupa password?</a>
                </div>
                <button v-on:click="login($event)" id="login" class="input-form-button">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LoginComponent",
        data() {
            return {
                input: {
                    email: "",
                    password: ""
                }
            };
        },
        methods: {
            login(evt){
                this.$api.post('/auth/login', {

                }).then(function (response) {
                    console.log(response)
                }).catch(function (error) {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

h3 {
    text-align: center;
    font-size: 27px;
    font-weight: bold;
}

input[type="checkbox"] {
    width: 17px;
    height: 17px;
    border-radius: 0px;
    cursor: pointer;
}

.option {
    /*background: red;*/
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 22px;
}

.sub-message {
    font-size: 13px;
    color: #aaa;
}

.input-form-text {
    padding: 10px 14px;
    border: none;
    border-left: 4px solid var(--blue-primary);
    background: #efefef;
    outline: none;
}

.input-form-text:nth-child(1n + 1) {
    margin-top: 11px;
}

.input-form-button {
    margin-top: 22px;
    width: 100%;
    padding: 12px;
}

.sub-title {
    text-align: center;
    display: flex;
    justify-content: center;
}

.sub-title > span {
    width: 75%;
    line-height: 17px;
    font-size: 12px;
    color: #aaa;
}

.login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: #f8f8f8;
}

.form-container {
    width: 500px;
    height: 530px;
    display: flex;
    justify-content: center;
    padding: 60px;
    box-shadow: 0px 0px 2px #8d8989;
    background: white;
}

#email, #password {
    display: block;
    width: 100%;
}

#forget-password {
    text-decoration: none;
}

#login {
    border-radius: 20px;
    border: none;
    outline: none;
    font-weight: bold;
    color: white;
    background: #1d84ff;
}

#login:hover {
    background: #3690ff;
}
</style>
