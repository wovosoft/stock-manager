<template>
    <div>
        <dt-table :title="__(title,startCase(title))" v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
        >
            <template v-slot:table>
                <b-table ref="datatable" v-bind="commonDtOptions()">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'CollectionsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'CollectionsEdit',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger"
                                      :title="__('delete','Delete')"
                                      @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {commonDtOptions} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";

    export default {
        name: "CollectionsList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('collections', 'Collections')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Collections.List')
            },
            trash_url: {
                type: String,
                // default: () => route('Backend.Collections.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Collections.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'CollectionsAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'collections'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            commonDtOptions() {
                return commonDtOptions(this);
            }
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {
                        key: 'customer_id', sortable: true, label: _t('name', 'Name'),
                        formatter: (i, v, r) => r.customer ? [r.customer.id, r.customer.name].join('#') : null
                    },
                    {
                        key: 'previous_balance',
                        sortable: true,
                        label: _t('previous_balance', 'Previous Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'payment_amount',
                        sortable: true,
                        label: _t('payment_amount', 'Payment Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'current_balance',
                        sortable: true,
                        label: _t('current_balance', 'Current Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'status',
                        sortable: true,
                        label: _t('status', 'Status'),
                        formatter: v => v ? _t(v) : null
                    },
                    {
                        key: 'reference',
                        sortable: true,
                        label: _t('reference', 'Reference'),
                    },

                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        sortable: true,
                        label: _t('updated_at', 'Updated At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'action',
                        sortable: false,
                        label: _t('action', 'Action'),
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    },
                ]
            }
        }
    }
</script>
