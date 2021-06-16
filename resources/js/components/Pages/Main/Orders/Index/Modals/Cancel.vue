<template>
    <div>
        <div class="modal-cancel-container" v-if="order !== null">
            <transition name="cancel-transition">
                <div key="modal" class="cancel-container" v-if="onAnimated" id="animated-container">
                    <div class="cancel-content">
                        <div>
                            <div class="icon-close" @click="onClicked($event)">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="icon-container">
                                <i class="fa fa-trash"></i>
                            </div>
                            <div class="cancel-messages">
                                <span class="title">Batal?</span>
                                <br/>
                                <span class="sub-message">
                                    Order ini akan dibatalkan secara permanen.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="padding-left: 7px; padding-right: 7px;">
                        <span class="text-verify">Tulis <b style="color: #000">"{{ order.unique_id }}"</b> untuk mengkonfirmasi.</span>
                        <input class="input-verify" type="text" @keyup="($event) => {button.disabled = $event.target.value !== order.unique_id}">
                    </div>
                    <div class="button-cancel" :class="{'cancel-footer': !button.disabled, 'button-disabled': button.disabled}" @click="onCancel">
                        Batalkan Sekarang
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
    name: "Cancel",
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
        onCancel(){
            if (this.button.disabled) return;

            const self = this;
            const url = this.$url.generateUrl(this.$endpoints.orders.cancel)
            this.$api.put(url(this.order.id_orders)).then(function (response) {
                self.emitToParent("success", "Order berhasil dibatalkan", true);
                self.$emit("response");
                console.log(response)
            }).catch(function (error) {
                self.emitToParent("failed", "Order berhasil dibatalkan", false);
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

.cancel-messages {
    margin-top: 14px;
}

.sub-message {
    font-size: 13px;
    width: 230px;
    margin-top: 14px;
    display: block;
    word-wrap: break-word;
}

.cancel-messages > span {
    color: var(--red-primary);
    font-weight: bold;
}

.cancel-messages > .title {
    font-size: 20px;
}

.cancel-content {
    width: 100%;
    height: 280px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cancel-content > div {
    text-align: center;
}

.button-cancel {
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

.cancel-footer {
    background: var(--red-primary);
    color: #fff;
}

.cancel-footer:hover {
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

.modal-cancel-container {
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

.cancel-container {
    background: white;
    width: 320px;
    /*height: 420px;*/
    position: relative;
    z-index: 39;
    animation: cancel-container-animation .4s ease;
    -o-animation: cancel-container-animation .4s ease;
    -moz-animation: cancel-container-animation .4s ease;
    -webkit-animation: cancel-container-animation .4s ease;
}

@keyframes cancel-container-animation {
    from {
        transform: translateY(-300px);
    }

    to {
        transform: translateY(0px);
    }
}

.cancel-transition-enter-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.cancel-transition-leave-active {
    transition: all .5s ease;
    -o-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -webkit-transition: all .5s ease;
}

.cancel-transition-leave {
    transform: translateY(0px);
    -o-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -webkit-transform: translateY(0px);
}

.cancel-transition-leave-to {
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
