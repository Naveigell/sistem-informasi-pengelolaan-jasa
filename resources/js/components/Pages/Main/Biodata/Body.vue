<template>
    <div class="app-container">
        <div class="body-container">
            <h4>
                <i class="fa fa-user" style="margin-right: 10px"></i>{{ $store.state.user.data == null ? "" : $store.state.user.data.name }}
            </h4>

            <div class="biodata-container">
                <div class="biodata-container-left">
                    <div class="image-container">
                        <div class="image">
<!--                            <img v-bind:src="$basepath + 'img/users/default/placeholder.png'" alt="">-->
                            <img src="https://ecs7.tokopedia.net/img/cache/300/user-1/2020/8/7/65194405/65194405_e6de7f49-67fd-4fcf-b53e-fe1b00d15a14.png" alt="">
                        </div>
                        <button class="button-image">
                            Pilih Avatar
                        </button>
                        <span class="sub-image-text">Ukuran foto maksimal 1MB</span>
                        <span class="sub-image-text">Format gambar yang diterima .jpg, .png, .jpeg</span>
                    </div>
                </div>
                <div class="biodata-container-right">
                    <div class="biodata-container-right-form">
                        <form action="">
                            <h5>Profil Saya</h5>
                            <div class="biodata-table">
                                <span class="biodata-title">Nama</span>
                                <span class="biodata-value">Naufal Sugiarto</span>
                            </div>
                            <div class="biodata-table">
                                <span class="biodata-title">Username</span>
                                <span class="biodata-value">naufalsugiarto832</span>
                            </div>
                            <div class="biodata-table">
                                <span class="biodata-title">Jenis Kelamin</span>
                                <span class="biodata-value">Laki - laki</span>
                            </div>

                            <h5>Kontak Saya</h5>
                            <div class="biodata-table">
                                <span class="biodata-title">Email</span>
                                <span class="biodata-value">naufalsugiarto832@gmail.com</span>
                            </div>
                            <div class="biodata-table">
                                <span class="biodata-title">Nomor Telepon</span>
                                <span class="biodata-value">082122381741</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Body"
}
</script>

<style scoped>
img {
    width: 100%;
    height: 100%;
    cursor: pointer;
}

form {
}

.biodata-title, .biodata-value {
    width: 220px;
    display: inline-block;
    color: #222;
}

.biodata-title {
    /*background: red;*/
}

.biodata-value {
    /*background: blue;*/
    margin-left: 8px;
}

.biodata-value:hover {
    color: var(--blue-primary);
}

.biodata-table {
    margin-top: 22px;
}

.biodata-container {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
}

.biodata-container-left {
    background: var(--body-primary);
    display: block;
    width: 400px;
    height: 400px;
    border: 1px solid #ddd;
}

.biodata-container-right {
    display: block;
    width: 100%;
    height: 400px;
    /*background: blue;*/
}

.image-container {
    width: 100%;
}

.image {
    padding: 20px;
}

.button-image {
    width: 260px;
    height: 35px;
    margin-left: 20px;
    border: 1px solid #ddd;
    background: #fdfdfd;
    outline: none;
}

.button-image:hover {
    background: #f9f9f9;
    transition: all .2s;
}

.sub-image-text:nth-child(even) {
    margin-top: 0;
}

.sub-image-text {
    color: #aaaaaa;
    display: block;
    font-size: 12px;
    text-align: center;
    margin-top: 10px;
}

.biodata-container-right-form {
    margin: 20px;
    width: 100%;
    height: 100%;
}

.biodata-container-right-form h5 {
    font-size: 16px;
    font-weight: bold;
    margin-top: 40px;
}

.biodata-container-right-form h5:first-child {
    font-size: 16px;
    font-weight: bold;
    margin-top: -14px;
}
</style>
