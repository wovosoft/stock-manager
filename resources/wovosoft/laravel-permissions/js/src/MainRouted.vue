<template>
    <b-card title="Card Title" no-body>
        <b-card-header header-tag="nav" style="padding-top: 0">
            <b-nav card-header tabs>
                <!-- <b-nav-item>'s with child routes. Note the trailing slash on the first <b-nav-item> -->
                <b-nav-item :to="{name:'UsersList'}" exact exact-active-class="active">
                    {{__('user_management','Users Management')}}
                </b-nav-item>
                <b-nav-item :to="{name:'UserRoles'}" exact exact-active-class="active">
                    {{__('role_management','Roles Management')}}
                </b-nav-item>
                <b-nav-item :to="{name:'UserPermissions'}" exact exact-active-class="active">
                    {{__('permission_management','Permissions Management')}}
                </b-nav-item>
                <b-nav-item :to="{name:'UserAbilityTest'}" exact exact-active-class="active">
                    {{__('check_users_ability',' Check Users Ability')}}
                </b-nav-item>
                <b-nav-item :to="{name:'RoleAbilityTest'}" exact exact-active-class="active">
                    {{__('check_roles_ability','Check Roles Ability')}}
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
