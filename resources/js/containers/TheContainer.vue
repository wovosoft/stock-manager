<template>
    <div>
        <the-navbar :site-name="site_name"
                    @toggleMobileSidebar="mobile_sidebar = !mobile_sidebar"
                    :bp-width="width"></the-navbar>
        <div class="container-fluid" id="the_container">
            <div class="row">
                <div class="col p-0 sidebar"
                     :class="[mobile_sidebar?'sidebar-opened':'sidebar-closed']">
                    <the-sidebar
                        @closeSidebar="v=>{if(v) mobile_sidebar=false;}"
                        @matched="(i)=>{i.active=true;}"
                        class="h-100 bg-dark sidebar-content overflow-auto"
                        :menu="menu"/>
                    <div class="backdrop" @click="mobile_sidebar=false"
                         v-if="(isSm || isXs) && backdrop && mobile_sidebar"/>
                </div>
                <div class="col p-2 main-content">
                    <breadcrumb v-if="!$route.meta.disable_breadcrumb"/>
                    <router-view/>
                </div>
            </div>
        </div>
        <the-footer :sidebar-opened="mobile_sidebar"></the-footer>
    </div>
</template>

<script>
    import TheNavbar from "./TheNavbar";
    import TheSidebar from "./TheSidebar";
    import menu from "../menu";
    import Breadcrumb from "../components/Breadcrumb";
    import TheFooter from "@/containers/TheFooter";
    // import('@/../sass/app.scss')
    export default {
        name: "TheContainer",
        components: {
            TheFooter,
            TheNavbar,
            TheSidebar,
            Breadcrumb
        },
        props: {
            backdrop: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                site_name: _s('site_name') || 'WovoSoft',
                mobile_sidebar: window.outerWidth > 768,
                width: 0,
                menu,
                sidebar_width: 230,
            }
        },
        created() {
            window.addEventListener("resize", this.getWindowSize);
            this.getWindowSize();
        },
        mounted() {
            let resizeTimer;
            let the = this;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                setTimeout(function () {
                    if (window.outerWidth <= 768) {
                        the.$set(the, 'mobile_sidebar', false);
                    } else {
                        the.$set(the, 'mobile_sidebar', true);
                    }
                }, 250);
            });
        },
        destroyed() {
            window.removeEventListener("resize", this.getWindowSize);
        },
        computed: {
            breakpoint() {
                if (this.width > 1200) {
                    return "xl";
                } else if (this.width > 576 && this.width <= 768) {
                    return "sm";
                } else if (this.width > 768 && this.width <= 992) {
                    return "md";
                } else if (this.width > 992 && this.width <= 1200) {
                    return "lg";
                } else if (this.width <= 576) {
                    return "xs";
                }
                return null;
            },
            isXs() {
                return this.breakpoint === "xs";
            },
            isSm() {
                return this.breakpoint === "sm";
            },
            isMd() {
                return this.breakpoint === "md";
            },
            isXl() {
                return this.breakpoint === "xl";
            }
        },
        methods: {
            getWindowSize(e) {
                this.width = window.innerWidth;
            }
        }
    }
</script>

<style scoped lang="scss">
    #the_container {
        min-height: calc(100vh - 55px - 40px);
        /*border:2px solid red;*/
        margin-top: 55px;
    }

    $slide_duration: .5s;
    $position_top: 55px;
    $sidebar_width: 230px;
    .sidebar-content {
        position: fixed;
        z-index: 100;
        width: $sidebar_width;
        box-shadow: 0 0 5px 0 #1b1e21;
    }

    .sidebar-closed {
        margin-left: -$sidebar_width;
        transition: all 0.3s ease-in-out;
    }

    .sidebar-opened {
        transition: margin-left 0.3s ease-in-out;
        margin-left: 0;
    }

    @media (min-width: 768px) {
        .sidebar {
            max-width: $sidebar_width;
        }
    }

    .sidebar {
        .backdrop {
            bottom: 0;
            top: 55px;
            right: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.3);
            position: fixed;
            z-index: 5;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            z-index: 10;
        }
        .sidebar-closed {
            width: 230px;
        }
    }
</style>
