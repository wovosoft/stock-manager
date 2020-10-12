<template>
    <ul class="list-group">
        <li v-for="(m,mk) in menu" :key="mk" class="p-0 border-0 list-group-item">
            <!-- Automatic Sidebar Menu Toggler-->
            {{fixSidebarToggle(m)}}
            <router-link v-if="m.url"
                         style="border-radius: 0"
                         :to="m.url"
                         @click.native="menuItemClicked(m)"
                         class="text-left py-2 btn btn-block"
                         :class="!isChildren?'btn-dark':'btn-light'"
                         exact exact-active-class="active">
                <i :class="m.icon" style="margin-right: 3px"/>
                {{m.meta ? (m.meta.menu || m.name) : m.name}}
                <i style="font-size: 12px"
                   :class="'float-right fa-1x fa ' + (m.active?'fa-chevron-down':'fa-chevron-left')"
                   v-if="m.children && m.children.length"/>
            </router-link>
            <button v-else
                    style="border-radius: 0"
                    @click="m.active = !m.active"
                    class="text-left py-2 btn btn-block"
                    :class="!isChildren?'btn-dark':'btn-light'">
                <i :class="m.icon" style="margin-right: 3px"></i>
                {{m.meta ? (m.meta.menu || m.name) : m.name}}
                <i style="font-size: 12px"
                   :class="'float-right fa-1x fa ' + (m.active?'fa-chevron-down':'fa-chevron-left')"
                   v-if="m.children && m.children.length"></i>
                <!-- Automatic Sidebar Menu Toggler-->
            </button>
            <b-collapse v-model="m.active" :accordion="'sidebar-accordion-'+accordion_id">
                <template v-if="m.children && m.children.length">
                    <the-sidebar
                        :menu="m.children"
                        @closeSidebar="v=>$emit('closeSidebar',v)"
                        @matched="(item)=>{item.active=true;$emit('matched',m)}"
                        :accordion_id="accordion_id+1"
                        :is-children="true"/>
                </template>
            </b-collapse>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "TheSidebar",
        props: {
            menu: {
                type: Array,
                default: () => []
            },
            isChildren: {
                type: Boolean,
                default: false
            },
            accordion_id: {
                type: Number,
                default: 1
            }
        },

        methods: {
            menuItemClicked(m) {
                m.active = !m.active;
                if (window && (window.outerWidth <= 768)) {
                    this.$emit('closeSidebar', true);
                }
            },
            /**
             *  The function checks matching of a menu against the current route.
             *  By default we cannot recursively access an object from child to parent,
             *  so we need to use vue's event paradigm. This functions test a menu,
             *  if true it emits the event for parent. The parents catches the event
             *  and again emits the same event for its adjacent parent. This looping goes
             *  till the root parent.
             *  and each matched parent changes its active state.
             */
            fixSidebarToggle(m) {
                /**
                 * This functions is still incomplete. It requires to test
                 * for name, path and modes as well. Because sometimes , some routes might not
                 * have the name property. In that case we must check it using the $route.path and
                 * resolved menu's href.
                 *
                 * Currently for simplicity, it is mandatory to have name for each route and menu item.
                 * Also having a name makes it easier and simpler.
                 */
                if (this.$router.resolve(m.url).location.name === this.$route.name) {
                    /*can be set here too. but we omit it here, just to take more control on the event handler.*/
                    // m.active =  true;
                    this.$emit('matched', m);
                }
            }
        }
    }
</script>

<style scoped>

</style>
