<template>
    <div>
        <div class="modal-delete-container" v-if="sparepart !== null">
            <transition name="delete-transition">
                <div key="modal" class="delete-container" v-if="onAnimated" id="animated-container">
                    <div class="delete-content">
                        <div>
                            <div class="icon-close" @click="onClicked($event)">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="icon-container">
                                <i class="fa fa-trash"></i>
                            </div>
                            <div class="delete-messages">
                                <span class="title">Hapus?</span>
                                <br/>
                                <span class="sub-message">
                                    {{ sparepart.nama }} akan dihapus secara permanen.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="delete-footer" @click="onDelete()">
                        Hapus Sekarang
                    </div>
                </div>
            </transition>
            <transition name="overlay-transition">
                <full-overlay v-if="onAnimated" @clicked="onClicked($event)"/>
            </transition>
        </div>
    </div>
</template>

<script>
import FullOverlay from "../../../../../Overlays/FullOverlay";

export default {
    name: "Delete",
    props: ["id", "sparepart"],
    components: {
        "full-overlay": FullOverlay
    },
    data(){
        return {
            onAnimated: false
        }
    },
    mounted() {
        this.onAnimated = true;
    },
    methods: {
        onClicked(event) {
            this.closeModal();
        },
        onDelete(){
            const self = this;
            this.$api.delete(this.$endpoints.sparepart.delete + `/${this.sparepart.id}`).then(function (response) {
                self.emitToParent("success", "Hapus sparepart berhasil", true);
            }).catch(function (error) {
                self.emitToParent("failed", "Hapus sparepart gagal", false);
                console.error(error)
            });
        },
        emitToParent(type, message, withAnimation){
            this.$emit("response", { type, message });
            this.closeModal(withAnimation);
        },
        closeModal(withAnimation){
            this.onAnimated = false;

            const self = this;
            const id = setTimeout(function () {
                if (withAnimation) {
                    self.$emit("onAnimationEnd");
                }

                self.$emit("closeModal");
                document.body.style.overflow = "visible";
                clearTimeout(id);
            }, 500);
        },
    }
}
</script>

<style scoped>
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
    height: calc(100% - 14%);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-content > div {
    text-align: center;
}

.delete-footer {
    width: 100%;
    height: 14%;
    position: relative;
    background: var(--red-primary);
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    font-weight: bold;
    text-align: center;
    padding-top: 13px;
}

.delete-footer:hover {
    background: var(--red-primary-hover);
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
    width: 320px;
    height: 390px;
    position: relative;
    z-index: 39;
    animation: delete-container-animation .4s ease;
    -o-animation: delete-container-animation .4s ease;
    -moz-animation: delete-container-animation .4s ease;
    -webkit-animation: delete-container-animation .4s ease;
}

@keyframes delete-container-animation {
    from {
        transform: translateY(-300px);
    }

    to {
        transform: translateY(0px);
    }
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

.delete-transition-leave {
    transform: translateY(0px);
    -o-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -webkit-transform: translateY(0px);
}

.delete-transition-leave-to {
    transform: translateY(-600px);
    -o-transform: translateY(-600px);
    -moz-transform: translateY(-600px);
    -webkit-transform: translateY(-600px);
}

.overlay-transition-enter-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.overlay-transition-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;

}

.overlay-transition-enter, .overlay-transition-leave-to {
    opacity: 0;
}
</style>
