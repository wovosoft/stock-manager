<template>
    <footer class="footer bg-dark text-white px-2"
            :class="{'ft-sidebar-opened':sidebarOpened}"
    >
        <slot>
            <b-row>
                <b-col>
                    &copy; {{_settings('site_name')}} - {{(new Date()).getFullYear()}}
                </b-col>
                <b-col class="text-right">
                    Developed By - <a href="https://wovosoft.com" title="WovoSoft" target="_blank">WovoSoft</a>
                </b-col>
            </b-row>
        </slot>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        props: {
            sidebarOpened: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped lang="scss">
    .footer {
        line-height: 40px;
        margin-left: 0;
        transition: margin-left 0.3s ease-in-out;
    }

    @media (min-width: 768px) {
        .ft-sidebar-opened {
            margin-left: 230px;
            transition: margin-left 0.3s ease-in-out;
        }
    }
</style>
