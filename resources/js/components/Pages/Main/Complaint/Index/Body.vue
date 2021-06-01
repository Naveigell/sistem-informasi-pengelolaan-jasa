<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background: white;">
                        <div style="background-color: #f6f7f8; height: 60px; font-family: InterRegular, Arial, sans-serif;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 40px; font-size: 16px;">COMPLAINT</h5>
                                <div style="font-size: 16px;">
                                    <span style="display: inline-block; padding: 5px 10px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-refresh"></i></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px; min-height: 300px;">
                            <div class="mail-option">
                                <div class="chk-all">
                                    <input v-model="checkboxes.root" @change="toggleCheckAll($event)" type="checkbox" class="mail-checkbox mail-group-checkbox">
                                    &nbsp
                                    <div class="btn-group">
                                        <a class="btn mini all" aria-expanded="false">
                                            All
                                        </a>
                                    </div>
                                </div>

<!--                                <div class="btn-group">-->
<!--                                    <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips">-->
<!--                                        <i class=" fa fa-refresh"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="btn-group hidden-phone">-->
<!--                                    <a data-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">-->
<!--                                        More-->
<!--                                        <i class="fa fa-angle-down "></i>-->
<!--                                    </a>-->
<!--                                    <ul class="dropdown-menu">-->
<!--                                        <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                                <div class="btn-group hidden-phone" @click="openDeleteModal">-->
<!--                                    <a class="btn mini blue" aria-expanded="false">-->
<!--                                        <i class="fa fa-trash"></i>&nbsp Delete-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="btn-group">-->
<!--                                    <a data-toggle="dropdown" href="#" class="btn mini blue">-->
<!--                                        Move to-->
<!--                                        <i class="fa fa-angle-down "></i>-->
<!--                                    </a>-->
<!--                                    <ul class="dropdown-menu">-->
<!--                                        <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
                                <ul class="unstyled inbox-pagination">
                                    <li @click="previous">
                                        <a class="np-btn"><i class="fa fa-angle-left  pagination-left"></i></a>
                                    </li>
                                    <li @click="next">
                                        <a class="np-btn"><i class="fa fa-angle-right pagination-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <table class="table table-inbox table-hover">
                                <tbody>
                                    <tr class="" v-for="(complaint, index) in complaints" @click="moveInto(complaint.id, $event)">
<!--                                        <td class="inbox-small-cells">-->
<!--                                            <input @change="check" ref="checkboxes" type="checkbox" class="mail-checkbox">-->
<!--                                        </td>-->
<!--                                        <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>-->
                                        <td class="view-message dont-show">{{ $store.state.user.data.role === 'pelanggan' ? "Kepada: Teknisi" : complaint.user.name }} <span v-if="complaint.disetujui_admin === 0" class="label pull-right" v-bind:class="{'label-danger': complaint.dikerjakan_teknisi === 0 && complaint.disetujui_pelanggan === 0, 'label-info': complaint.dikerjakan_teknisi === 1 && complaint.disetujui_pelanggan === 0, 'label-success': complaint.disetujui_pelanggan === 1 && complaint.dikerjakan_teknisi === 1 && complaint.disetujui_admin === 0}">{{ complaint.disetujui_pelanggan === 1 ? "Disetujui pelanggan" : complaint.dikerjakan_teknisi === 1 ? "Selesai dikerjakan" : "complain" }}</span></td>
                                        <td class="view-message" style="text-overflow: ellipsis; overflow-x: hidden; max-width: 700px; white-space: nowrap;">{{ complaint.content.cutIfGreaterThan(30000) }}</td>
                                        <td class="view-message inbox-small-cells"></td>
                                        <td class="view-message text-right">{{ complaint.created_at_sentences }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <YesNoDialogDelete :title="'Hapus?'" :message="'Komplain yang dicentang akan dihapus secara permanen'" v-if="modals.delete.open" @delete="del" @closeModal="modals.delete.open = false"/>
    </div>
</template>

<script>
import YesNoDialogDelete from "../../../../Dialogs/DialogDelete";

export default {
    name: "Body",
    components: {
        YesNoDialogDelete
    },
    data(){
        return {
            complaints: [],
            pagination_items: [],
            checkboxes: {
                root: ""
            },
            modals: {
                delete: {
                    open: false
                }
            }
        };
    },
    mounted() {
        this.retrieveAll();
    },
    methods: {
        moveInto(id, event){
            if (event.target.type !== "checkbox") {
                this.$router.push(`complaints/${id}`);
            }
        },
        retrieveAll(last_id, next){
            const params = {};

            if (last_id !== null) {
                params.id = last_id;
                params.next = next;
            }

            this.$api.get(this.$endpoints.complaints.data, { params }).then((response) => {
                this.complaints = response.data.body.complaints;

                if (last_id === undefined && next === undefined) {
                    this.pagination_items.push(this.complaints[0].id);
                }

                this.$nextTick(() => {});
                this.toggleCheckAll(null, false);
            }).catch((error) => {
                console.error(error);
            })
        },
        next(){
            if (this.complaints.length <= 0) {
                this.pagination_items = [];
                this.retrieveAll();
            } else {
                let last_id = this.complaints[this.complaints.length - 1].id;
                this.pagination_items.push(--last_id);
                this.retrieveAll(last_id, true);
            }
        },
        previous() {
            if (this.complaints.length <= 0) {
                this.pagination_items = [];
                this.retrieveAll();
            } else {
                let first_id = this.pagination_items[0];
                if (this.pagination_items.length > 1) {
                    first_id = this.pagination_items[this.pagination_items.length - 2];
                }

                if (this.pagination_items.length > 1) {
                    this.pagination_items.pop();
                }

                this.retrieveAll(first_id, false);
            }
        },
        toggleCheckAll(event, toggle) {
            // if checked is null, it's mean the user not click checkbox all feature
            const checked = event === null ? null : event.target.checked;
            if (checked === null) {
                this.checkboxes.root = false;
            }

            if (this.$refs.checkboxes !== undefined) {
                this.$refs.checkboxes.map(item => item.checked = checked === null ? toggle : checked);
            }
        },
        isAllCheckboxChecked(){
            return this.$refs.checkboxes.findIndex((item) => {
                return !item.checked;
            }) === -1;
        },
        isSomeCheckboxChecked(){
            return this.$refs.checkboxes.findIndex((item) => {
                return item.checked;
            }) > -1;
        },
        check(){
            if (this.$refs.checkboxes !== undefined) {
                this.checkboxes.root = this.isAllCheckboxChecked();
            }
        },
        del(){
            const ids = [];
            this.$refs.checkboxes.map((item, index) => {
                if (item.checked) {
                    ids.push(this.complaints[index].id);
                }
            });

            if (ids.length > 0) {
                this.$api.delete(this.$endpoints.complaints.delete, { params: { ids } }).then((response) => {
                    this.$root.$emit("open-toast", {
                        type: "success",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Success!",
                            message: "Hapus saran berhasil",
                            icon: "fa fa-check"
                        }
                    });
                    this.retrieveAll();
                }).catch((error) => {
                    this.$root.$emit("open-toast", {
                        type: "failed",
                        background: this.$colors.redPrimary,
                        data: {
                            title: "Failed!",
                            message: error.response.data.errors.messages.message,
                            icon: "fa fa-times-circle"
                        }
                    });
                });
            }
        },
        openDeleteModal(){
            if (this.isSomeCheckboxChecked()) {
                this.modals.delete.open = true;
            }
        }
    }
}
</script>

<style scoped>
.mail-box aside {
    display: table-cell;
    float: none;
    height: 100%;
    padding: 0;
    vertical-align: top;
}
.user-head .inbox-avatar img {
    border-radius: 4px;
}
.user-head .user-name h5 {
    font-size: 14px;
    font-weight: 300;
    margin-bottom: 0;
    margin-top: 15px;
}
.user-head .user-name h5 a {
    color: #fff;
}
.user-head .user-name span a {
    color: #87e2e7;
    font-size: 12px;
}
ul.inbox-nav li {
    display: inline-block;
    line-height: 45px;
    width: 100%;
}
ul.inbox-nav li a {
    color: #6a6a6a;
    display: inline-block;
    line-height: 45px;
    padding: 0 20px;
    width: 100%;
}
ul.inbox-nav li a:hover, ul.inbox-nav li.active a, ul.inbox-nav li a:focus {
    background: none repeat scroll 0 0 #d5d7de;
    color: #6a6a6a;
}
ul.inbox-nav li a i {
    color: #6a6a6a;
    font-size: 16px;
    padding-right: 10px;
}
ul.labels-info li h4 {
    color: #5c5c5e;
    font-size: 13px;
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 5px;
    text-transform: uppercase;
}
ul.labels-info li {
    margin: 0;
}
ul.labels-info li a {
    border-radius: 0;
    color: #6a6a6a;
}
ul.labels-info li a:hover, ul.labels-info li a:focus {
    background: none repeat scroll 0 0 #d5d7de;
    color: #6a6a6a;
}
ul.labels-info li a i {
    padding-right: 10px;
}
.nav.nav-pills.nav-stacked.labels-info p {
    color: #9d9f9e;
    font-size: 11px;
    margin-bottom: 0;
    padding: 0 22px;
}
.inbox-head h3 {
    display: inline-block;
    font-weight: 300;
    margin: 0;
    padding-top: 6px;
}
.inbox-head .sr-input {
    border: medium none;
    border-radius: 4px 0 0 4px;
    box-shadow: none;
    color: #8a8a8a;
    float: left;
    height: 40px;
    padding: 0 10px;
}
.inbox-head .sr-btn {
    background: none repeat scroll 0 0 #00a6b2;
    border: medium none;
    border-radius: 0 4px 4px 0;
    color: #fff;
    height: 40px;
    padding: 0 20px;
}
.table-inbox {
    border: 1px solid #d3d3d3;
    margin-bottom: 0;
}
.table-inbox tr td {
    padding: 12px !important;
}
.table-inbox tr td:hover {
    cursor: pointer;
}
.table-inbox tr td .fa-star.inbox-started, .table-inbox tr td .fa-star:hover {
    color: #f78a09;
}
.table-inbox tr td .fa-star {
    color: #d5d5d5;
}
.table-inbox tr.unread td {
    background: none repeat scroll 0 0 #f7f7f7;
    font-weight: 600;
}
ul.inbox-pagination {
    float: right;
}
ul.inbox-pagination li {
    float: left;
    cursor: pointer;
}
.mail-option {
    display: inline-block;
    margin-bottom: 10px;
    width: 100%;
}
.mail-option .chk-all, .mail-option .btn-group {
    margin-right: 5px;
}
.mail-option .chk-all, .mail-option .btn-group a.btn {
    background: none repeat scroll 0 0 #fcfcfc;
    border: 1px solid #e7e7e7;
    border-radius: 3px !important;
    color: #afafaf;
    display: inline-block;
    padding: 5px 10px;
}
.inbox-pagination a.np-btn {
    background: none repeat scroll 0 0 #fcfcfc;
    border: 1px solid #e7e7e7;
    border-radius: 3px !important;
    color: #afafaf;
    display: inline-block;
    padding: 5px 15px;
}
.mail-option .chk-all input[type="checkbox"] {
    margin-top: 0;
}
.mail-option .btn-group a.all {
    border: medium none;
    padding: 0;
}
.inbox-pagination a.np-btn {
    margin-left: 5px;
}
.inbox-pagination li span {
    display: inline-block;
    margin-right: 5px;
    margin-top: 7px;
}
.inbox-body .modal .modal-body input, .inbox-body .modal .modal-body textarea {
    border: 1px solid #e6e6e6;
    box-shadow: none;
}
.modal-header h4.modal-title {
    font-family: "Open Sans",sans-serif;
    font-weight: 300;
}
.modal-body label {
    font-family: "Open Sans",sans-serif;
    font-weight: 400;
}
.heading-inbox h4 {
    border-bottom: 1px solid #ddd;
    color: #444;
    font-size: 18px;
    margin-top: 20px;
    padding-bottom: 10px;
}
.sender-info img {
    height: 30px;
    width: 30px;
}
.view-mail a {
    color: #ff6c60;
}
.attachment-mail ul {
    display: inline-block;
    margin-bottom: 30px;
    width: 100%;
}
.attachment-mail ul li {
    float: left;
    margin-bottom: 10px;
    margin-right: 10px;
    width: 150px;
}
.attachment-mail ul li img {
    width: 100%;
}
.attachment-mail ul li span {
    float: right;
}
.fileinput-button input {
    cursor: pointer;
    direction: ltr;
    font-size: 23px;
    margin: 0;
    opacity: 0;
    position: absolute;
    right: 0;
    top: 0;
    transform: translate(-300px, 0px) scale(4);
}
@media (max-width: 767px) {
    .files .btn span {
        display: none;
    }
    .files .preview * {
        width: 40px;
    }
    .files .name * {
        display: inline-block;
        width: 80px;
        word-wrap: break-word;
    }
    .files .progress {
        width: 20px;
    }
    .files .delete {
        width: 60px;
    }
}
ul {
    list-style-type: none;
    padding: 0px;
    margin: 0px;
}

</style>
