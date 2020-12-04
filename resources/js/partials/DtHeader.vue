<template>
    <div>
        <div class="row">
            <div class="col" style="min-width: 150px;max-width: 200px;">
                <b-input-group :size="perPageSize" :prepend="__('per_page','Per Page')">
                    <b-form-select
                        class="form-control"
                        @change="v=>setPerPage(v)"
                        v-model="datatable.per_page"
                        :options="range()">
                    </b-form-select>
                </b-input-group>
            </div>
            <div class="col" style="min-width: 150px" v-if="!noSearch">
                <b-form-input
                    type="search"
                    v-model="search"
                    :size="searchSize"
                    @keydown.esc="()=>{$event.target.value='';$emit('input','')}"
                    @change="datatable.current_page=1"
                    @input="$emit('input', search)"
                    :placeholder="__('type_and_hit_enter_to_search_the_table','Type and Hit Enter to Search the table, ESC to clear')"/>
            </div>
            <div class="col" v-if="enableDateRange">
                <b-input-group :size="searchSize">
                    <b-form-input type="date"
                                  :title="__('starting_date','Starting Date')"
                                  @change="$emit('refreshDatatable')"
                                  v-model="datatable.search_columns.starting_date"/>
                    <b-form-input type="date"
                                  @change="$emit('refreshDatatable')"
                                  :disabled="!datatable.search_columns.starting_date"
                                  :min="datatable.search_columns.starting_date"
                                  :title="__('ending_date','Ending Date')"
                                  v-model="datatable.search_columns.ending_date"/>
                    <template v-slot:append>
                        <b-button @click="()=>{
                            $set(datatable.search_columns,'starting_date',undefined);
                            $set(datatable.search_columns,'ending_date',undefined);
                            $emit('refreshDatatable');
                        }">
                            x
                        </b-button>
                    </template>
                </b-input-group>
            </div>
            <div class="col text-right">
                <slot name="header_searches"></slot>
                <b-button-group v0i :size="customButtonSize" v-if="custom_buttons && custom_buttons.length">
                    <template v-for="(btn,btn_key) in custom_buttons">
                        <b-button
                            v-if="btn.to"
                            :title="btn.title"
                            :variant="btn.variant?btn.variant:'dark'"
                            :to="btn.to"
                            exact exact-active-class="active"
                            :key="btn_key">
                            <i :class="btn.icon" v-if="btn.icon"></i> {{btn.text}}
                        </b-button>
                        <b-button
                            v-else-if="btn.cb"
                            :title="btn.title"
                            :variant="btn.variant?btn.variant:'dark'"
                            @click="btn.cb"
                            exact exact-active-class="active"
                            :key="btn_key">
                            <i :class="btn.icon" v-if="btn.icon"></i> {{btn.text}}
                        </b-button>
                        <b-button
                            v-else
                            :title="btn.title"
                            :variant="btn.variant?btn.variant:'dark'"
                            :key="btn_key"
                            @click="btn.method">
                            <i :class="btn.icon" v-if="btn.icon"></i> {{btn.text}}
                        </b-button>
                    </template>
                </b-button-group>
                <b-dropdown :text="__('columns','Columns')"
                            :size="columnDdSize"
                            right
                            class="columns-dropdown p-0"
                            variant="primary">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(field,key) in fields" :key="key">
                            <b-form-checkbox v-model="field.visible" :value="true"
                                             :uncheched-value="false"
                                             @change="changeVisibility(field,key)"
                            >
                                {{startCase(field.label || field.key)}}
                            </b-form-checkbox>
                        </li>
                    </ul>
                </b-dropdown>
            </div>
        </div>
        <slot name="bottom_panel"></slot>
    </div>
</template>

<script>
    import {range, changeVisibility, startCase, setPerPage, getPerPage} from "./datatable";

    export default {
        props: {
            fields: {
                type: Array,
                default: () => []
            },
            datatable: Object,
            value: {
                type: String,
                default: ""
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
            columnDdSize: {
                type: String,
                default: 'sm'
            },
            customButtonSize: {
                type: String,
                default: 'sm'
            },
            searchSize: {
                type: String,
                default: 'sm'
            },
            perPageSize: {
                type: String,
                default: 'sm'
            },
            enableDateRange: {
                type: Boolean,
                default: false
            },
            noSearch: {
                type: Boolean,
                default: false
            }
        },
        data: () => {
            return {
                search: '',
                the:this
            }
        },
        mounted() {
            this.datatable.per_page = this.getPerPage();
        },
        watch: {
            "datatable.search_columns": {
                deep: true,
                handler(ov, nv) {
                    this.$emit('refreshDatatable', true);
                }
            }
        },
        methods: {
            changeVisibility,
            startCase,
            range,
            setPerPage,
            getPerPage
        }
    }
</script>

<style lang="scss">
    .columns-dropdown {
        .dropdown-menu {
            padding: 0 !important;
            border: 0 !important;
            max-height: 400px;
            overflow-y: auto;
        }

        .list-group-item {
            label {
                cursor: pointer;
            }
        }
    }
</style>
