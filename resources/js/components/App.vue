<template>
    <div class="sidebar-page has-background-info">
        <!-- Sidebar -->
        <section class="sidebar-layout">
            <b-sidebar position="static" mobile="reduce" :expand-on-hover="false" :reduce="false" :fullheight="true"
                type="is-info" open>
                <div class="px-1 pt-2">
                    <b-menu class="is-custom-mobile">
                        <b-menu-list label="Menu">
                            <b-menu-item icon="home" label="Dashboard" title="Dashboard" tag="router-link" to="/" :active="$route.name=='dashboard'" ></b-menu-item>
                            <b-menu-item icon="account-group" label="Property" title="Property" tag="router-link" to="/property" :active="$route.meta.name=='property'" ></b-menu-item>
                            <b-menu-item icon="office-building-marker" label="Tenants" title="Tenants" tag="router-link" to="/tenant" :active="$route.name=='tenant'" ></b-menu-item>
                        </b-menu-list>
                        <b-menu-list label="Admin">
                            <b-menu-item icon="information-outline" label="Users"></b-menu-item>
                            <b-menu-item icon="information-outline" label="Tenants"></b-menu-item>
                        </b-menu-list>
                    </b-menu>
                </div>
            </b-sidebar>

            <div class="p-3 container">
                <router-view></router-view>
            </div>
        </section>
    </div>
</template>

<script>
    export default {

    }
</script>

<style lang="scss">
    .p-1 {
        padding: 1em;
    }

    .sidebar-page {
        display: flex;
        flex-direction: column;
        width: 100%;
        min-height: 100vh;

        .sidebar-layout {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
        }
    }

    @media screen and (max-width: 768px) {
        .b-sidebar {
            box-shadow: 0px 0px 5px 1px #00808078;

            .sidebar-content {
                &.is-mini-mobile {

                    &:not(.is-mini-expand),
                    &.is-mini-expand:not(:hover) {
                        .menu-list {
                            li {
                                a {
                                    span:nth-child(2) {
                                        display: none;
                                    }
                                }

                                ul {
                                    padding-left: 0;

                                    li {
                                        a {
                                            display: inline-block;
                                        }
                                    }
                                }
                            }
                        }

                        .menu-label:not(:last-child) {
                            margin-bottom: 0;
                        }
                    }
                }
            }
        }
    }

    .is-mini-expand {
        .menu-list a {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>
