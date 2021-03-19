<template>
    <div>
        <div class="grid-container">
            <div class="grid">
                <div class="user-grid-container">
                    <div class="user-grid" v-for="(user, index) in users" v-if="users.length > 0">
                        <a style="text-decoration: none;">
                            <img v-if="user.biodata !== undefined" :src="user.biodata.profile_picture" width="100%" height="170" alt="users">
                            <hr/>
                            <span class="user-title">
                                {{ user.name }}
                            </span>
                            <div class="user-info">
                                <span class="user-price">
                                    {{ user.username }}
                                </span>
                                <span class="user-stock">
                                    {{ user.biodata === undefined ? '' : user.biodata.nomor_hp === null ? "-" : user.biodata.nomor_hp }}
                                </span>
                            </div>
                            <div class="user-meta">
                                <span class="user-type">
                                    <i class="fas fa-box"></i> User
                                </span>
                            </div>
                            <br/>
                        </a>
                        <transition name="user-delete-container-transition">
                            <div key="delete" class="user-delete-container" v-if="onDeleteMode">
                                <span v-on:click="openDeleteModal(user.id, user, index)">
                                    <i class="fa fa-trash"></i> Hapus
                                </span>
                            </div>
                        </transition>
                    </div>
                    <delete-modal @onAnimationEnd="onDeleteModalAnimationEnd" @response="onDeleteModalResponse" :user="data.user" v-if="modal.delete" v-bind:id="data.id" @closeModal="modal.delete = false"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";

export default {
    name: "GridList",
    props: ["users", "onDeleteMode"],
    components: {
        "delete-modal": Delete,
    },
    data() {
        return {
            data: {
                id: -1,
                user: null,
                index: -1
            },
            modal: {
                delete: false
            },
        }
    },
    methods: {
        openDeleteModal(id, user, index){
            this.data.id = id;
            this.data.user = user;
            this.data.index = index;
            this.modal.delete = true;
        },
        onDeleteModalResponse(obj){
            this.$root.$emit("open-toast", {
                type: obj.type,
                background: obj.type === "failed" ? this.$colors.redPrimary : this.$colors.successPrimary,
                data: {
                    title: obj.type === "failed" ? "Failed!" : "Success!",
                    message: obj.message,
                    icon: obj.type === "failed" ? "fa fa-times-circle" : "fa fa-check"
                }
            });

            if (obj.reload) {
                this.$emit("reload");
            }
        },
        onDeleteModalAnimationEnd(){
        }
    }
}
</script>

<style scoped>

.user-delete-container-transition-enter-active {
    transition: all .3s ease;
    -o-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -webkit-transition: all .3s ease;
}

.user-delete-container-transition-leave-active {
    transition: all .1s ease;
    -o-transition: all .1s ease;
    -moz-transition: all .1s ease;
    -webkit-transition: all .1s ease;
}

.user-delete-container-transition-enter, .user-delete-container-transition-leave-to {
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

.user-delete-container {
    border-top: 1px solid #dedede;
    width: 184px;
    background: white;
    color: var(--red-primary);
}

.user-delete-container > span {
    display: block;
    text-align: center;
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.user-delete-container > span > i {
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

.user-info {
    margin-top: 8px;
    margin-right: 10px;
    margin-left: 10px;
}

.user-type {
    float: right;
    font-size: 12px;
    margin-right: 10px;
    color: #a4a4a4;
}

.user-price {
    color: var(--blue-primary);
    font-size: 15px;
}

.user-stock {
    margin-top: 5px;
    display: block;
    color: #a4a4a4;
}

.user-meta {
    padding-bottom: 7px;
}

.user-grid-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.user-title {
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

.user-grid:hover {
    /*height: 340px;*/
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    -webkit-transition: .1s;
    -moz-transition: .1s;
    -o-transition: .1s;
    transition: .1s;
}

.user-grid:hover .user-delete-container {
    display: block;
}

.user-grid {
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

.user-grid img {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

hr {
    margin: 0;
}
</style>
