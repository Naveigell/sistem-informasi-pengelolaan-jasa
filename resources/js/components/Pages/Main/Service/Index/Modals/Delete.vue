<template>
    <div>
        <div class="modal-delete-container">
            <transition-group name="delete-transition">
                <div key="modal" class="delete-container" v-if="inAnimation">
                    <div class="icon-close" v-on:click="closeModal(true)">
                        <i class="fa fa-times"></i>
                    </div>
                    <form @submit.prevent>
                        <div class="delete-content">
                            <div>
                                <div class="icon-container">
                                    <i class="fa fa-trash"></i>
                                </div>
                                <div class="delete-messages">
                                    <span class="title">Hapus?</span>
                                    <br/>
                                    <span class="sub-message">
                                    {{ data.nama_jasa }} akan dihapus secara permanen.
                                </span>
                                </div>
                            </div>
                        </div>
                        <button class="button-danger-md" @click="del()">
                            Hapus
                        </button>
                    </form>
                </div>
                <FullOverlay key="overlay" v-if="inAnimation" @clicked="closeModal(true)"/>
            </transition-group>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "Delete",
    props: ["data", "index"],
    components: {
        FullOverlay
    },
    data() {
        return {
            inAnimation: false,
        }
    },
    mounted() {
        this.inAnimation = true;
        // console.log(this.data)
    },
    methods: {
        closeModal(withAnimation, afterModalCloseCallback) {
            this.inAnimation = false;

            const self = this;
            const id = setTimeout(function () {
                if (withAnimation) {
                    if (afterModalCloseCallback != null) {
                        afterModalCloseCallback();
                    }
                    self.$emit("onAnimationEnd");
                }

                self.$emit("closeModal");
                document.body.style.overflow = "visible";
                clearTimeout(id);
            }, 500);
        },
        del(){
            this.closeModal(true, () => {
                this.$api.delete(this.$endpoints.service.delete + `/${this.data.id_jasa}`).then((response) => {
                    if (response.status === 204)
                        this.$root.$emit("jasaDeleted", {
                            index: this.index
                        });
                }).catch((error) => {
                    this.$root.$emit("openToast", {
                        title: "Error!",
                        message: "Jasa gagal dihapus",
                        icon: "fa fa-exclamation-triangle",
                        background: this.$colors.errorPrimary
                    });
                });
            });
        }
    }
}
</script>

<style scoped>
form {
    padding: 3px 16px;
}

form > button {
    margin-top: 14px;
    width: 100%;
    height: 38px;
    font-weight: bold;
}

.icon-container > i {
    font-size: 60px;
    color: var(--red-primary);
}

.icon-close {
    position: absolute;
    right: 7px;
    top: 3px;
    color: var(--red-primary);
    cursor: pointer;
    z-index: 4;
}

.icon-close > i {
    font-size: 30px;
}

.icon-close > i:hover {
    color: var(--red-primary-hover);
}

.delete-messages {
    margin-top: 14px;
}

.sub-message {
    font-size: 13px;
    width: 230px;
    margin-top: 14px;
    display: block;
    word-wrap: break-word;
}

.delete-messages > span {
    color: var(--red-primary);
    font-weight: bold;
}

.delete-messages > .title {
    font-size: 20px;
}

.delete-content {
    width: 100%;
    height: 350px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-content > div {
    text-align: center;
}

.icon-close {
    position: absolute;
    right: 11px;
    top: 7px;
    color: var(--red-primary);
    cursor: pointer;
}

.icon-close > i {
    font-size: 28px;
}

.icon-close > i:hover {
    color: var(--red-primary-hover);
}

.modal-delete-container {
    position: fixed;
    z-index: 35;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-container {
    background: white;
    border-radius: 4px;
    width: 330px;
    height: 420px;
    position: relative;
    z-index: 39;
    overflow-y: auto;
}

.delete-transition-enter-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.delete-transition-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.delete-transition-enter, .delete-transition-leave-to {
    opacity: 0;
}
</style>
