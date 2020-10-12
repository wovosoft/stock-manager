<template>
    <b-card title="Card Title" no-body>
        <b-card-header header-tag="nav" class="pt-0">
            <b-nav card-header tabs>
                <!-- <b-nav-item>'s with child routes. Note the trailing slash on the first <b-nav-item> -->
                <b-nav-item :to="{name:'SalesReportDaily'}" exact exact-active-class="active">
                    {{__('daily','Daily')}}
                </b-nav-item>
            </b-nav>
        </b-card-header>

        <b-card-body>
            <router-view></router-view>
        </b-card-body>
    </b-card>
</template>
<style lang="scss">
    #tabs_list {
        .tab-pane {
            .card {
                border: 0 !important;
            }
        }
    }
</style>
