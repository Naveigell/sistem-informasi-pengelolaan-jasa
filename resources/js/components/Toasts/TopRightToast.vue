<template>
    <div>
        <transition name="slide-fade" v-on:after-enter="afterEnter()" v-on:after-leave="afterLeave()">
            <div v-if="inAnimation" class="toaster-container" :style="{'background': containerBackground}">
                <div class="toaster-icon">
                    <i :class="icon"></i>
                </div>
                <div class="toaster-message">
                    <div class="message">
                        <span class="title">{{ title }}</span>
                        <span class="sub-title">{{ subtitle }}</span>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: "TopRightToast",
    props: ["background", "title", "subtitle", "timer", "icon"],
    data(){
        return {
            inAnimation: false,
            containerBackground: this.background
        }
    },
    mounted() {
        this.inAnimation = true;

        const color = this.background.substring(1, this.background.length);
        if (color.length === 6) {
            const rgb = this.$color.hexToRgb(color);
            this.containerBackground = `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.9)`;
        }
    },
    methods: {
        afterEnter(){
            if (this.timer == null) return;

            const self = this;
            const id = setTimeout(function () {
                self.inAnimation = false;
                clearTimeout(id);
            }, this.timer);
        },
        afterLeave(){
            this.$emit("toastEnded");
        }
    }
}
</script>

<style scoped>
.slide-fade-enter-active {
    transition: .8s;
}
.slide-fade-leave-active {
    transition: .8s;
}
.slide-fade-enter {
    transform: translateX(100%);
    opacity: 0;
}

.slide-fade-enter-to {
    transform: translateX(0px);
    opacity: 1;
}

.slide-fade-leave {
    transform: translateX(0px);
    opacity: 1;
}

.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

.toaster-container {
    position: fixed;
    top: 10px;
    right: 10px;
    width: 300px;
    height: 85px;
    background: var(--success-primary);
    border-radius: 4px;
    z-index: 100;
    /*opacity: 0.3;*/
}

.toaster-icon {
    width: 20%;
    height: 100%;
    display: flex;
    float: left;
    justify-content: center;
    align-items: center;
}

.toaster-icon > i {
    font-size: 22px;
    color: white;
}

.toaster-message {
    display: flex;
    align-items: center;
    width: 80%;
    height: 100%;
    float: right;
}

.message {
    line-height: 21px;
    color: white;
}

.title {
    display: block;
    font-size: 17px;
    font-weight: bold;
}

.sub-title {
    display: block;
}
</style>
