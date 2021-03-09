<template>
    <aside>
        <div class="sidebar-container">
            <div class="sidebar" v-for="sidebar in sidebars">
                <span class="sidebar-title">
                    <span v-if="!sidebar.isLink">
                        <i v-bind:class="sidebar.icon" style="margin-right: 10px;"></i> {{ sidebar.title }}
                    </span>
                    <a v-else v-bind:href="sidebar.to">
                        <i v-bind:class="sidebar.icon" style="margin-right: 10px;"></i> {{ sidebar.title }}
                    </a>
                    <span class="sidebar-title-caret" v-if="sidebar.hasDropdown">
                        <i class="fa fa-caret-down"></i>
                    </span>
                </span>
                <div class="sidebar-menu" v-if="sidebar.hasDropdown">
                    <a :href="link.to == null ? '#' : link.to" class="menu" v-for="link in sidebar._links">
                        {{ link.name }}
                    </a>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            sidebars: [
                {
                    title: "Dashboard",
                    icon: "fa fa-dashboard",
                    hasDropdown: true,
                    _links: [
                        {
                            name: "Data Pelanggan",
                            isLink: true,
                            to: this.$basepath
                        },
                        {
                            name: "Data Spare Part",
                            isLink: true,
                            to: this.$basepath + "sparepart"
                        },
                        {
                            name: "Data Teknisi",
                            isLink: true,
                            to: this.$basepath + "technician"
                        }
                    ]
                },
                {
                    title: "Biodata",
                    icon: "fa fa-user",
                    hasDropdown: false,
                    isLink: true,
                    to: this.$basepath + "account/biodata"
                },
                {
                    title: "Service",
                    icon: "fa fa-user",
                    hasDropdown: false,
                    isLink: true,
                    to: this.$basepath + "service"
                }
            ]
        };
    }
}
</script>

<style scoped>
aside {
    background: white;
    width: var(--sidebar-width);
    height: 100vh;
    box-shadow: 2px 0 0 #efefef;
    position: fixed;
    left: 0;
    top: calc(var(--header-height));
}

.menu {
    font-size: 13px;
    cursor: pointer;
    color: #222;
    display: block;
}

.sidebar:nth-child(1n + 0) {
    margin-top: 5px;
}

.sidebar-container {
    padding-top: 2px;
    margin-top: 2px;
}

.sidebar-title a:hover {
    color: var(--blue-primary);
}

.sidebar-title a {
    color: #aaaaaa;
    text-decoration: none;
    margin-left: 4px;
}

.sidebar-title:hover {
    color: var(--blue-primary);
}

.sidebar-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    color: #aaaaaa;
    cursor: pointer;
    height: 40px;
}

.sidebar-menu {
    margin-left: 48px;
}

.sidebar-menu .menu:hover {
    color: var(--blue-primary);
    text-decoration: none;
}

.sidebar-menu span {
    font-size: 13px;
    cursor: pointer;
}

.sidebar-title:nth-child(1) {
    padding-left: 20px;
}

.sidebar-title > .sidebar-title-caret {
    margin-right: 20px;
}
</style>
