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
                <input v-on:focus="errors.email = errors.password = null" v-model="input.email" class="input-form-text" v-bind:class="{'input-form-text-error': errors.email != null}" style="margin-top: 40px;" placeholder="Email ..." id="email" type="email">
                <span v-bind:class="{'sub-message': errors.email == null, 'sub-message-error': errors.email != null}">
                    {{ errors.email == null ? "Masukkan email disini. Cth: oneya@solutions.com" : errors.email[0] }}
                </span>
                <input v-on:focus="errors.email = errors.password = null" v-model="input.password" class="input-form-text" v-bind:class="{'input-form-text-error': errors.password != null}" placeholder="Password ..." id="password" type="password">
                <span v-bind:class="{'sub-message': errors.password == null, 'sub-message-error': errors.password != null}">
                    {{ errors.password == null ? "Masukkan passwordmu disini." : errors.password[0] }}
                </span>
                <div class="option">
                    <span>
                        <input id="remember-me" type="checkbox">
                        <label for="remember-me" style="position: relative; bottom: 3px; left: 4px; cursor: pointer; font-weight: normal">Ingat Saya</label>
                    </span>
                    <a id="forget-password" href="">Lupa password?</a>
                </div>
                <div v-if="errors.server != null" style="display: block; text-align: center">
                    <br>
                    <span style="" class="sub-message-error">
                        {{ errors.server }}
                    </span>
                </div>
                <button v-on:click="login($event)" id="login" v-bind:class="{'input-form-button': !loading.buttonLoading, 'input-form-button-loading': loading.buttonLoading}">
                    <span v-if="!loading.buttonLoading">Masuk</span>
                    <span v-else class="loading"></span>
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
                },
                errors: {
                    email: null,
                    password: null,
                    server: null
                },
                loading: {
                    buttonLoading: false
                }
            };
        },
        methods: {
            async login(evt){
                const self = this;
                this.loading.buttonLoading = true;

                const response = function (response) {
                    if (response.status === 200) {
                        self.$root.$emit('event-login', true);
                    }
                };

                const error = function (error) {
                    const status = self.$math.status(error);

                    if (status === 4) {
                        self.errors = error.response.data.errors.messages;
                        self.errors.server = null;
                    } else if (status === 5) {
                        self.errors.server = error.response.data.errors.messages.server[0];
                    }
                };

                await this.$api.post(this.$endpoints.auth.login, {
                    email: this.input.email,
                    password: this.input.password
                }).then(response).catch(error);

                this.loading.buttonLoading = false;
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

.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 4px solid white;
    border-radius: 50%;
    border-top: 4px solid gray;
    position: relative;
    top: 2px;
    animation: spinning .6s infinite linear;
}

@keyframes spinning {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

input[type="checkbox"] {
    width: 17px;
    height: 17px;
    border-radius: 0px;
    cursor: pointer;
}

.input-form-text {
    padding: 10px 14px;
    border: none;
    border-left: 4px solid var(--blue-primary);
    background: #efefef;
    outline: none;
    transition: all 0s;
}

.input-form-text-error {
    border-left-color: var(--red-primary);
    transition: all 0.4s;
}

.sub-message {
    font-size: 13px;
    color: #aaa;
}

.sub-message-error {
    font-size: 13px;
    color: var(--red-primary);
    animation: submessageerror 0.2s ease-out;
    -o-animation: submessageerror 0.2s ease-out;
    -moz-animation: submessageerror 0.2s ease-out;
    -webkit-animation: submessageerror 0.2s ease-out;
    position: relative;
}

.option {
    /*background: red;*/
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 22px;
}

.input-form-text:nth-child(1n + 1) {
    margin-top: 11px;
}

.input-form-button {
    margin-top: 22px;
    width: 100%;
    padding: 12px;
}

.input-form-button-loading {
    margin-top: 22px;
    width: 100%;
    padding: 9.5px;
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
