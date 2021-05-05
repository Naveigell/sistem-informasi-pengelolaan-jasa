<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="admin-grid-container">
                    <div class="admin-grid" v-for="(admin, index) in admins" v-if="admins.length > 0">
                        <router-link :to="{ path: '/admins/' + admin.username }" style="text-decoration: none;">
                            <img v-if="admin.biodata !== undefined" width="100%" height="170" :src="admin.biodata.profile_picture" alt="admins">
                            <hr/>
                            <span class="admin-title">
                                {{ admin.name }}
                            </span>
                            <div class="admin-info">
                                <span class="admin-price">
                                    {{ admin.username }}
                                </span>
                                <span class="admin-stock">
                                    {{ admin.biodata === undefined ? '' : admin.biodata.nomor_hp === null ? "-" : admin.biodata.nomor_hp }}
                                </span>
                            </div>
                            <div class="admin-meta">
                                <span class="admin-type">
                                    <i class="fas fa-box"></i> Admin
                                </span>
                            </div>
                            <br/>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "GridList",
    props: ["admins"],
}
</script>

<style scoped>
.admin-delete-container-transition-enter-active {
    transition: all .3s ease;
    -o-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -webkit-transition: all .3s ease;
}

.admin-delete-container-transition-leave-active {
    transition: all .1s ease;
    -o-transition: all .1s ease;
    -moz-transition: all .1s ease;
    -webkit-transition: all .1s ease;
}

.admin-delete-container-transition-enter, .admin-delete-container-transition-leave-to {
    opacity: 0;
}

.delete-transition-ended-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.delete-transition-ended-leave {
    opacity: 1;
}

.delete-transition-ended-leave-to {
    opacity: 0;
}

.admin-delete-container {
    border-top: 1px solid #dedede;
    width: 184px;
    background: white;
    color: var(--red-primary);
}

.admin-delete-container > span {
    display: block;
    text-align: center;
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.admin-delete-container > span > i {
    font-size: 16px;
    padding-right: 4px;
}

.grid-container {
    width: 100%;
    height: 100%;
}

.grid {
    padding: 20px;
    margin: 20px;
}

.admin-info {
    margin-top: 8px;
    margin-right: 10px;
    margin-left: 10px;
}

.admin-type {
    float: right;
    font-size: 12px;
    margin-right: 10px;
    color: #a4a4a4;
}

.admin-price {
    color: var(--blue-primary);
    font-size: 15px;
}

.admin-stock {
    margin-top: 5px;
    display: block;
    color: #a4a4a4;
}

.admin-meta {
    padding-bottom: 7px;
}

.admin-grid-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.admin-title {
    margin-left: 10px;
    margin-right: 10px;
    margin-top: 1em;
    color: #222;
    display: block;
    display: -webkit-box;
    max-width: 100%;
    height: 32px;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.15;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.admin-grid:hover {
    /*height: 340px;*/
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.admin-grid:hover .admin-delete-container {
    display: block;
}

.admin-grid {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    display: inline-block;
    width: 186px;
    height: calc(100% + 30px);
    position: relative;
    margin: 5px 5px 12px;
    flex-grow: 0;
    flex-shrink: 1;
    text-decoration: none;
    /*flex-basis: calc(20% - 5px);*/
}

.admin-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

hr {
    margin: 0;
}
</style>
