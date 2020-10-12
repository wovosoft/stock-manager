<template>
    <b-navbar toggleable="lg" type="dark" variant="dark" fixed="top"
              style="z-index: 1039;border-bottom: 1px solid lightgray;">
        <div class="navbar-brand" style="width: 210px;">
            <router-link class="text-white" :to="{name:'Dashboard'}"
                         style="text-decoration: none;vertical-align: middle">
                {{siteName}}
            </router-link>
            <button type="button"
                    class="navbar-toggler d-inline-block py-0 float-md-right float-left"
                    @click="$emit('toggleMobileSidebar')"
                    size="sm">
                <i class="navbar-toggler-icon"></i>
            </button>
        </div>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
            <!-- Right aligned nav items -->
            <b-navbar-nav>
                <template v-for="(mm,mm_key) in menubar_menu">
                    <b-nav-item-dropdown v-if="mm.children" :text="mm.name" :key="mm_key+'dd'">
                        <b-dropdown-item v-for="(mmc,mmc_key) in mm.children" :key="mmc_key" :to="mmc.url">
                            {{mmc.name}}
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item v-else :to="mm.url" :key="mm_key+'ni'">{{mm.name}}</b-nav-item>
                </template>
            </b-navbar-nav>
            <b-navbar-nav align="center" id="main-loader" class="d-none"
                          style="position: absolute;left: 50%;transform: translateX(-50%);">
                <div class="spinner-border text-white" style="z-index: 99999;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown :text="__('language','Language')" right>
                    <b-dropdown-item
                        @click="changeLanguage(id)"
                        :active="Number(language)===Number(id)"
                        v-for="(id,lang) in list_languages"
                        :key="id">
                        {{lang}}
                    </b-dropdown-item>
                </b-nav-item-dropdown>

                <b-nav-item-dropdown right>
                    <!-- Using 'button-content' slot -->
                    <template v-slot:button-content>
                        <em>{{user.name}}</em>
                    </template>
                    <!--                    <b-dropdown-item href="#">Profile</b-dropdown-item>-->
                    <b-dropdown-item @click.prevent="logout">
                        Sign Out
                    </b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    import {msgBox} from "@/partials/datatable";
    import menubar_menu from "@/menubar_menu";

    export default {
        name: "TheNavbar",
        props: {
            siteName: {
                type: String,
                default: (_s('site_name') || 'WovoSoft')
            }
        },
        data() {
            return {
                list_languages: listLanguages(),
                user: _u(),
                language: _s('language'),
                menubar_menu
            }
        },
        methods: {
            msgBox,
            logout() {
                document.getElementById("logout-form").submit();
            },
            changeLanguage(id) {
                if (!id) {
                    return false;
                }
                console.log(id)
                axios.post(route('Backend.Settings.setCurrentLanguage').url(), {
                    language_id: id
                }).then(res => {
                    this.msgBox(res.data);
                    window.location.reload();
                }).catch(err => {
                    console.log(err.response);
                    this.msgBox(err.response.data);
                });
            }
        }
    }
</script>

<style scoped>

</style>
