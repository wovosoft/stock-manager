<template>
    <b-card :title="title" footer-class="pb-0" body-class="p-1">
        <template v-slot:header>
            <dt-header
                :enable-date-range="enableDateRange"
                :custom_buttons="custom_buttons"
                :datatable="datatable"
                :no-search="noSearch"
                :fields="fields"
                v-bind:value="value"
                @refreshDatatable="v=>$emit('refreshDatatable',v)"
                :column-dd-size="columnDdSize"
                @input="$emit('input',$event)"
            >
                <template v-slot:header_searches>
                    <slot name="header_dropdowns"></slot>
                </template>
                <template v-slot:bottom_panel>
                    <slot name="header_bottom_panel"></slot>
                </template>
            </dt-header>
        </template>
        <slot name="table"></slot>
        <template v-slot:footer>
            <dt-footer :datatable="datatable"></dt-footer>
        </template>
    </b-card>
</template>

<script>
    import DtHeader from "./DtHeader";
    import DtFooter from "./DtFooter";


    export default {
        components: {
            DtHeader,
            DtFooter
        },
        props: {
            title: {
                type: String,
                default: ""
            },
            fields: {
                type: Array,
                default: () => []
            },
            datatable: {
                type: Object,
                default: () => {
                    return {
                        per_page: 10,
                        current_page: 1,
                        total: 0,
                        from: 0,
                        to: 0,
                    }
                }
            },
            value: {
                type: String,
                default: ''
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
            columnDdSize: {
                type: String,
                default: 'sm'
            },
            enableDateRange: {
                type: Boolean,
                default: false
            },
            tableRef: {
                type: String,
                default: 'datatable'
            },
            noSearch: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
