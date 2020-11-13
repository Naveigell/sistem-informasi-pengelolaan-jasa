<template>
    <header>
        <div class="left-side">
            <div class="logo-container">
                Logo
            </div>
        </div>
        <div class="right-side" v-if="$store.state.user.data != null">
            <div class="tools-container">
                <span class="">
                    <i class="glyphicon glyphicon-th"></i>
                </span>
                <span class="">
                    <i class="fa fa-bell"></i>
                </span>
            </div>
            <div class="separator"></div>
            <div class="account-container">
                <div class="account">
                    <img id="account-img" v-bind:src="$basepath + 'img/users/default/placeholder.png'" alt="">
                </div>
                <span class="username" v-html="$store.state.user.data == null ? '(Not Login Yet)' : $store.state.user.data.username"></span>
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
            }
        };
    },
    mounted() {
        const self = this;

    }
}
</script>

<style scoped>
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

.separator {
    width: 1px;
    height: 35px;
    background: #dedede;
    margin-right: 20px;
}

.username {
    font-weight: bold;
    margin-right: 14px;
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
</style>
