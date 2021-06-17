<template>
    <aside>
        <div class="sidebar-container">
            <div class="sidebar" v-for="sidebar in sidebars">
                <span class="sidebar-title" v-if="show(sidebar)">
                    <span v-if="!sidebar.isLink">
                        <i v-bind:class="sidebar.icon" style="margin-right: 10px;"></i> {{ sidebar.title }}
                    </span>
                    <router-link :to="{ path: sidebar.to }" v-else>
                        <i v-bind:class="sidebar.icon" style="margin-right: 10px;"></i> {{ sidebar.title }}
                    </router-link>
                    <span class="sidebar-title-caret" v-if="sidebar.hasDropdown">
                        <i class="fa fa-caret-down"></i>
                    </span>
                </span>
                <div class="sidebar-menu" v-if="sidebar.hasDropdown">
                    <router-link :key="index" v-if="show(link)" class="menu" v-for="(link, index) in sidebar._links" :to="{ path: link.to }">{{ link.name }}</router-link>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
export default {
    name: "Sidebar",
    methods: {
        show(obj){
            if (obj.roles === undefined)
                return false;

            return obj.roles.includes(this.$store.state.user.data.role);
        }
    },
    data() {
        return {
            sidebars: [
                {
                    title: "Home",
                    icon: "fa fa-home",
                    hasDropdown: true,
                    _links: [
                        {
                            name: "Dashboard",
                            isLink: true,
                            to: "/",
                            roles: ["admin", "teknisi", "pelanggan"]
                        },
                        {
                            name: "Data Pelanggan",
                            isLink: true,
                            to: "/user",
                            roles: ["admin"]
                        },
                        {
                            name: "Data Spare Part",
                            isLink: true,
                            to: "/sparepart",
                            roles: ["admin", "teknisi"]
                        },
                        {
                            name: "Data Admin",
                            isLink: true,
                            to: "/admins",
                            roles: ["admin", "pelanggan"]
                        },
                        {
                            name: "Data Teknisi",
                            isLink: true,
                            to: "/technician",
                            roles: ["admin", "pelanggan"]
                        }
                    ],
                    roles: ["admin", "teknisi", "pelanggan"]
                },
                {
                    title: "Instansi",
                    icon: "fa fa-building",
                    hasDropdown: false,
                    isLink: true,
                    to: "/agency",
                    roles: ["admin", "teknisi"]
                },
                {
                    title: "Biodata",
                    icon: "fa fa-user",
                    hasDropdown: false,
                    isLink: true,
                    to: "/account/biodata",
                    roles: ["admin", "teknisi", "pelanggan"]
                },
                {
                    title: "Jasa",
                    icon: "fa fa-wrench",
                    hasDropdown: false,
                    isLink: true,
                    to: "/service",
                    roles: ["admin"]
                },
                {
                    title: "Orders",
                    icon: "fa fa-shopping-cart",
                    hasDropdown: false,
                    isLink: true,
                    to: "/orders",
                    roles: ["admin", "teknisi", "pelanggan"]
                },
                {
                    title: "Laporan",
                    icon: "fa fa-print",
                    hasDropdown: false,
                    isLink: true,
                    to: "/reports",
                    roles: ["admin"]
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
    text-decoration: none;
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
