<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card :title="__('supplier_funds_deposit','Supplier Funds Deposit')">
                    {{overview.deposit | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('supplier_funds_withdrawn','Supplier Funds Withdrawn')">
                    {{overview.withdrawn | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('supplier_funds_balance','Supplier Funds Balance')">
                    {{overview.balance | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title" v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
        >
            <template v-slot:table>
                <b-table ref="datatable" variant="primary" responsive="md" hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         @refreshed="overview=JSON.parse(headers.fund_summery)"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                         foot-clone
                         foot-variant="light">
                    <template v-slot:foot(deposit_amount)="row">
                        {{colSum(datatable.items,'deposit_amount') | currency}}
                    </template>
                    <template v-slot:foot(withdrawn_amount)="row">
                        {{colSum(datatable.items,'withdrawn_amount') | currency}}
                    </template>
                    <template v-slot:foot(funds_balance)="row">
                        {{colSum(datatable.items,'funds_balance') | currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-dropdown right size="sm">
                            <b-dropdown-item
                                title="Add Fund"
                                v-b-modal:add_fund_modal
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-hand-holding-usd"></i> Add Fund
                            </b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item
                                :to="{name:'SuppliersView',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i> View Supplier
                            </b-dropdown-item>
                            <b-dropdown-item
                                :to="{name:'SuppliersAdd',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i> Edit Supplier
                            </b-dropdown-item>
                            <b-dropdown-item @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i> Delete Supplier
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <b-modal id="add_fund_modal"
                 v-if="currentItem"
                 lazy
                 hide-footer
                 @hidden="currentItem=null"
                 :title="'Add Fund in '+currentItem.name+'\'s Account'"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-fund
                    @success="v=>{if(v) hide();}"
                    @refresh="v=>$refs.datatable.refresh()"
                    v-if="currentItem && currentItem.id"
                    :supplier_id="currentItem.id"/>
            </template>
        </b-modal>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, colCount} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import AddFund from "@/components/suppliers/AddFund";

    export default {
        name: "SuppliersList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            AddFund
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('suppliers', 'Suppliers')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Suppliers.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Suppliers.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Suppliers.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: 'Add',
                        variant: 'dark',
                        to: {name: 'SuppliersAdd'}
                    },
                    {
                        text: 'History',
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'suppliers'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            colCount,
            colSum
        },
        data() {
            return {
                form: {},
                overview: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'name', sortable: true, label: _t('name', 'Name')},
                    {key: 'email', sortable: true, label: _t('email', 'Email')},
                    {key: 'phone', sortable: true, label: _t('phone', 'Phone')},
                    {key: 'company', sortable: true, label: _t('company', 'Company')},
                    {key: 'district', sortable: true, label: _t('district', 'District')},
                    {key: 'thana', sortable: true, label: _t('thana', 'Thana')},
                    {key: 'post_office', sortable: true, label: _t('post_office', 'P.O.')},
                    {key: 'village', sortable: true, label: _t('village', 'Village')},
                    {
                        key: 'deposit_amount',
                        sortable: true,
                        searchable: false,
                        label: _t('deposit', 'Deposit'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'withdrawn_amount',
                        sortable: true,
                        searchable: false,
                        label: _t('withdrawn', 'Withdrawn'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'funds_balance',
                        sortable: true,
                        searchable: false,
                        label: _t('funds_balance', 'Funds Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'shipping_address',
                        label: _t('shipping_address', 'Shipping Address'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || ""),
                        visible: false
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.dayjs(v)
                    },
                    {
                        key: 'updated_at',
                        sortable: true,
                        label: _t('updated_at', 'Updated At'),
                        formatter: v => this.dayjs(v)
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
<style lang="scss">
    table {
        th {
            vertical-align: top !important;
        }
    }
</style>
