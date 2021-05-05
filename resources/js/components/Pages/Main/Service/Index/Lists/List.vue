<template>
    <div>
        <div class="list">
            <div class="title-container col-md-2">
                <span class="title">{{ data.nama_jasa }}</span>
                <div class="tag-container">
                    <button v-on:click="updateActivation()" style="min-width: 60px;" class="button-green-primary-tag tag" @mouseleave="hover.buttonActive = !hover.buttonActive" @mouseover="hover.buttonActive = !hover.buttonActive" :class="{'button-danger-primary-tag': !hover.buttonActive, 'button-green-primary-tag': hover.buttonActive}">
                        {{ hover.buttonActive ? "Aktif" : "Nonaktif" }}
                    </button>
                </div>
            </div>
            <div class="type-container col-md-3 text-center">
                <span>{{ data.tipe.capitalize() }}</span>
            </div>
            <div class="description-container col-md-5 text-center">
                <div class="description">
                    {{ data.deskripsi }}
                </div>
            </div>
            <div class="action-container col-md-2">
                <span style="color: var(--warning-primary)" v-on:click="modal.update.open = true"><i class="fa fa-pencil-square-o"></i></span>
                <span style="color: var(--red-primary)" v-on:click="modal.delete.open = true"><i class="fa fa-trash"></i></span>
            </div>
        </div>
        <Delete :data="data" :index="index" v-if="modal.delete.open" @onAnimationEnd="closeModal(modal.delete)"/>
        <Update :d="data" :index="index" v-if="modal.update.open" @onAnimationEnd="closeModal(modal.update)" @onUpdate="onUpdate"/>
    </div>
</template>

<script>
import Delete from "../Modals/Delete";
import Update from "../Modals/Update";

export default {
    name: "List",
    props: ["id", "index", "list"],
    components: { Delete, Update },
    data(){
        return {
            data: this.list,
            hover: {
                buttonActive: this.list.aktif
            },
            modal: {
                delete: {
                    open: false
                },
                update: {
                    open: false
                }
            },
        }
    },
    methods: {
        updateActivation(){
            const self = this;
            this.$api.patch(this.$endpoints.service.activation, {
                id: this.data.id_jasa
            }).then(function (response) {
                if (response.status === 204 || response.status === 200) {
                    self.hover.buttonActive = !self.hover.buttonActive;
                    self.data.aktif = self.data.aktif === 0 ? 1 : 0;
                    self.$emit("updateList", {
                        data: self.data,
                        index: self.index
                    });
                }
            }).catch(function (error) {
                console.error(error)
                self.$emit("error", {
                    background: this.$colors.errorPrimary,
                    title: "Error!",
                    message: "Status gagal diupdate",
                    icon: "fa fa-exclamation-triangle"
                });
            })
        },
        onUpdate(data){
            this.list.biaya_jasa = data.price;
            this.list.deskripsi = data.description;
            this.list.nama_jasa = data.name;
            this.list.tipe = data.type;
        },
        closeModal(modal) {
            modal.open = false;
        },
    }
}
</script>

<style scoped>
.action-container {
    font-size: 18px;
}

.action-container > span {
    margin-left: 10px;
    cursor: pointer;
}

.action-container > span:hover {
}

.list {
    margin-top: 10px;
    padding: 12px 20px;
    border: 1px solid #d9d9d9;
    border-left: 5px solid var(--blue-primary);
    border-radius: 4px;
    display: flex;
    align-items: center;
    /*justify-content: space-between;*/
}

.price {
    color: var(--orange-primary);
    font-weight: bold;
    font-size: 15px;
}

.description {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    max-width: 200px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.description-hover {
    position: absolute;
    max-width: 500px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.tag-container {
    margin-top: 4px;
}

.tag-container > .tag {
    font-size: 11px;
    cursor: pointer;
    padding-left: 10px;
    padding-right: 10px;
}

.title {
    display: block;
    color: #555;
    font-weight: bold;
}
</style>
