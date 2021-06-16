<template>
    <header>
        <div class="left-side">
            <div class="logo-container">

            </div>
        </div>
        <div class="right-side" v-if="$store.state.user.data != null">
            <div class="tools-container">
                <span class="">
                    <i class="fa fa-bell"></i>
                </span>
            </div>
            <div class="separator"></div>
            <div style="position: relative; min-width: 200px;" @mouseleave="dropdown.open = false" @mouseover="dropdown.open = true">
                <div class="account-container">
                    <div class="account">
                        <img v-if="$store.state.user.picture != null" id="account-img" v-bind:src="$store.state.user.picture" alt="">
                    </div>
                    <div>
                        <span class="username" v-html="$store.state.user.data == null ? '(Not Login Yet)' : $store.state.user.data.username"></span>
                        <span class="role" v-if="$store.state.user.data !== null">{{ $store.state.user.data.role }}</span>
                    </div>
                </div>
                <div class="account-dropdown-container elevation-3" @mouseover="dropdown.open = true" @mouseleave="dropdown.open = false" v-if="dropdown.open">
                    <router-link :to="{ path: '/history' }" v-if="$role.isAdmin">
                        History
                    </router-link>
                    <router-link :to="{ path: '/suggestions' }">
                        <span style="display: inline-block; float: left;">Messages</span>
                        <span style="display: inline-block; float: right;"><i class="fa fa-envelope"></i></span>
                        <div style="clear: both;"></div>
                    </router-link>
                    <router-link :to="{ path: '/complaints' }">
                        <span style="display: inline-block; float: left;">Complaints</span>
                        <span style="display: inline-block; float: right;"><i class="fa fa-times-circle"></i></span>
                        <div style="clear: both;"></div>
                    </router-link>
                    <div class="account-dropdown-separator"></div>
                    <a @click="logout">Logout &nbsp <i class="fa fa-sign-out"></i></a>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "Header",
    data(){
        return {
            user: {
                data: null
            },
            dropdown: {
                open: false
            }
        };
    },
    methods: {
        logout(){
            this.$api.get(this.$endpoints.auth.logout).then((response) => {
                this.$store.commit("logout");
                if (this.$router.currentRoute.path !== "/") {
                    this.$router.push({ path: "/" });
                } else {
                    this.$root.$emit("reload-page");
                }
            }).catch((error) => {
                console.error(error)
            });
        }
    }
}
</script>

<style scoped>
img {
    object-fit: cover;
    object-position: center;
}

header {
    height: var(--header-height);
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10;
    width: 100%;
    justify-content: space-between;
    box-shadow: 0 0 2px 2px #ececec;
    background: white;
}

.role {
    color: #30c78d;
    padding: 0 10px;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
    margin-top: 3px;
    background-color: #bff0dd;
    border-width: 1px;
    border-radius: 30px;
}

.separator {
    width: 1px;
    height: 35px;
    background: #dedede;
    margin-right: 20px;
}

.username {
    font-weight: bold;
    margin-right: 14px;
    display: block;
}

.tools-container {
    display: flex;
    justify-content: space-between;
    margin-right: 20px;
}

.tools-container i {
    font-size: 18px;
}

.tools-container span:hover {
    background: #f0f0f0;
}

.tools-container span:nth-child(1) {
    margin-right: 10px;
}

.tools-container span {
    border-radius: 40px;
    cursor: pointer;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

#account-img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.left-side {
    display: flex;
    justify-content: center;
    align-items: center;
}

.right-side {
    display: flex;
    align-items: center;
    margin-right: 40px;
}

.account-container:hover {
    background: #f0f0f0;
}

.account-container {
    padding: 5px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 30px;
}

.account-dropdown-container {
    position: absolute;
    padding: 8px;
    top: 42px;
    background-color: #fff;
    border-radius: 3px;
    box-shadow: 0 0 5px 1px #d4cece;
    width: 100%;
}

.account-dropdown-container > a > span {
    font-family: InterRegular, Arial, sans-serif;
}

.account-dropdown-container > a {
    font-family: InterRegular, Arial, sans-serif;
    font-weight: 600;
    padding: 8px;
    color: #444444;
    cursor: pointer;
    display: block;
    border-radius: 3px;
    text-decoration: none;
}

.account-dropdown-container > a:hover {
    background-color: #edf0f2;
}

.account-dropdown-separator {
    height: 2px;
    background-color: #edf0f2;
    margin-top: 8px;
    margin-bottom: 8px;
}
</style>
