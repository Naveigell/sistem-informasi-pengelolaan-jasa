<template>
    <div>
        <div class="modal-delete-container" v-if="order !== null">
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
                                    Order ini akan dihapus secara permanen.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="padding-left: 7px; padding-right: 7px;">
                        <span class="text-verify">Tulis <b style="color: #000">"{{ order.unique_id }}"</b> untuk mengkonfirmasi.</span>
                        <input class="input-verify" type="text" @keyup="($event) => {button.disabled = $event.target.value !== order.unique_id}">
                    </div>
                    <div class="button-delete" :class="{'delete-footer': !button.disabled, 'button-disabled': button.disabled}" @click="onDelete">
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
    props: ["id", "order"],
    components: {
        "full-overlay": FullOverlay
    },
    data(){
        return {
            onAnimated: false,
            button: {
                disabled: true
            }
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
            if (this.button.disabled) return;

            const self = this;
            this.$api.delete(this.$endpoints.orders.delete + `/${this.order.id_service}`).then(function (response) {
                self.emitToParent("success", "Hapus order berhasil", true);
                self.$emit("response");
            }).catch(function (error) {
                self.emitToParent("failed", "Hapus order gagal", false);
            });
        },
        emitToParent(type, message, withAnimation){
            this.$root.$emit("open-toast", {
                type: type,
                background: type === "failed" ? this.$colors.redPrimary : this.$colors.successPrimary,
                data: {
                    title: type === "failed" ? "Failed!" : "Success!",
                    message: message,
                    icon: type === "failed" ? "fa fa-times-circle" : "fa fa-check"
                }
            });
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
    height: 280px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-content > div {
    text-align: center;
}

.button-delete {
    width: 100%;
    height: 54px;
    position: relative;
    cursor: pointer;
    font-size: 17px;
    font-weight: bold;
    text-align: center;
    padding-top: 13px;
}

.button-disabled {
    background: #f5f5f5;
    color: rgba(0, 0, 0, .6);
}

.delete-footer {
    background: var(--red-primary);
    color: #fff;
}

.delete-footer:hover {
    background: var(--red-primary-hover);
}

.input-verify {
    width: 100%;
    margin-bottom: 4px;
    height: 35px;
    outline: none;
    border: 1px solid #d7d7d7;
    border-radius: 3px;
    padding-left: 7px;
    padding-right: 7px;
}

.text-verify {
    margin-bottom: 3px;
    display: block;
    font-weight: bold;
    font-size: 14px;
    color: #777
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
    /*height: 420px;*/
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
