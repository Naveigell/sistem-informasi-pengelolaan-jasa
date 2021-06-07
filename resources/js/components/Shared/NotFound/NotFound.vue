<template>
    <div style="background: #f9f9f9">
        <div style="height: 320px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="position: relative; padding-top: 5px; padding-bottom: 5px;">
                <i id="main-icon" class="fa fa-search-minus"></i>
                <i id="second-icon" class="fa fa-times"></i>
                <i id="third-icon" class="fa fa-times"></i>
            </div>
            <span>{{ message ? message : "Data tidak ditemukan" }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound",
    props: ["message"]
}
</script>

<style scoped>
#main-icon {
    font-size: 70px;
}

#second-icon {
    position: absolute;
    left: 0;
    bottom: 0;
    font-size: 17px;
}

#third-icon {
    position: absolute;
    right: 0;
    top: 0;
    font-size: 17px;
}

i {
    color: #d6dadb;
}

span {
    display: block;
    margin-top: 15px;
    font-family: InterRegular, Arial, sans-serif;
    font-size: 15px;
    color: #808080;
}
</style>
