<template>
    <div class="sidebar-page">
        <section class="sidebar-layout">
            <b-sidebar position="static" mobile="reduce" :expand-on-hover="false" :reduce="false" :fullheight="true"
                type="is-info" open>
                <div class="p-1">
                    <b-menu class="is-custom-mobile">
                        <b-menu-list label="Menu">
                            <b-menu-item icon="information-outline" label="Property" tag="router-link" to="/property" :active="$route.name=='property'" ></b-menu-item>
                            <b-menu-item icon="information-outline" label="Tenants" tag="router-link" to="/tenant" :active="$route.name=='tenant'" ></b-menu-item>
                        </b-menu-list>
                        <b-menu-list label="Admin">
                            <b-menu-item icon="information-outline" label="Users"></b-menu-item>
                            <b-menu-item icon="information-outline" label="Tenants"></b-menu-item>
                        </b-menu-list>
                    </b-menu>
                </div>
            </b-sidebar>

            <div class="pt-1 px-3 container">
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
