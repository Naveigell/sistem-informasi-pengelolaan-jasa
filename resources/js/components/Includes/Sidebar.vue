<template>
    <aside>
        <div class="sidebar-container">
            <div class="sidebar">
                <span class="sidebar-title">
                    <span>
                        <i class="fa fa-dashboard" style="margin-right: 10px;"></i> Dashboard
                    </span>
                    <span class="sidebar-title-caret">
                        <i class="fa fa-caret-down"></i>
                    </span>
                </span>
                <div class="sidebar-menu">
                    <span class="menu">
                        Data Pelanggan
                    </span>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
export default {
    name: "Sidebar"
}
</script>

<style scoped>
aside {
    background: white;
    width: 220px;
    height: 100vh;
    box-shadow: 2px 0 0 #efefef;
    position: fixed;
    left: 0;
    top: calc(var(--header-height));
}

.sidebar:nth-child(1n + 0) {
    margin-top: 5px;
}

.sidebar-container {
    padding-top: 2px;
    margin-top: 2px;
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

.sidebar-menu span:hover {
    color: var(--blue-primary);
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
