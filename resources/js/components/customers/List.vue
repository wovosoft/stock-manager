<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card :title="__('customer_funds_deposits','Customer Funds Deposit')">
                    {{fund_summery.deposit | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('customer_funds_withdrawn','Customer Funds Withdrawn')">
                    {{fund_summery.withdrawn | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('customer_funds_balance','Customer Funds Balance')">
                    {{fund_summery.balance | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table
            :title="title"
            v-model="search"
            :fields="fields"
            :datatable="datatable"
            enable-date-range
            @refreshDatatable="$refs.datatable.refresh()"
            :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable"
                         @refreshed="fund_summery=JSON.parse(headers.fund_summery||'{}')"
                         variant="primary"
                         responsive="md"
                         hover
                         bordered
                         small
                         striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         foot-variant="light"
                         foot-clone
                         :current-page="datatable.current_page">
                    <template v-slot:foot(deposit_amount)="row">
                        {{colSum(datatable.items,'deposit_amount') | currency}}
                    </template>
                    <template v-slot:foot(withdrawn_amount)="row">
                        {{colSum(datatable.items,'withdrawn_amount') | currency}}
                    </template>
                    <template v-slot:foot(funds_balance)="row">
                        {{colSum(datatable.items,'funds_balance') | currency}}
                    </template>
                    <template v-slot:foot(sales_payable)="row">
                        {{colSum(datatable.items,'sales_payable') | currency}}
                    </template>
                    <template v-slot:foot(sales_paid)="row">
                        {{colSum(datatable.items,'sales_paid') | currency}}
                    </template>
                    <template v-slot:foot(sales_balance)="row">
                        {{colSum(datatable.items,'sales_balance') | currency}}
                    </template>
                    <template v-slot:foot(final_balance)="row">
                        {{colSum(datatable.items,'final_balance') | currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-dropdown right size="sm">
                            <b-dropdown-item
                                :title="__('add_fund','Add Fund')"
                                v-b-modal:add_fund_modal
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-hand-holding-usd"></i> {{__('add_fund','Add Fund')}}
                            </b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item
                                :title="__('view','View')"
                                :to="{name:'CustomersView',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i> {{__('view_customer','View Customer')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('edit','Edit')"
                                :to="{name:'CustomersAdd',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i> {{__('edit_customer','Edit Customer')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('delete','Delete')"
                                @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i> {{__('delete_customer','Delete Customer')}}
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
                    :customer_id="currentItem.id"/>
            </template>
        </b-modal>
        <router-view @reset="currentItem={}"
                     @refreshDatatable="()=>$refs.datatable.refresh()"
                     :item="currentItem"></router-view>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colCount, colSum} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import AddFund from "@/components/customers/AddFund";

    export default {
        name: "CustomersList",
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
                default: _t('customers', 'Customers')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Customers.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Customers.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Customers.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'CustomersAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'customers'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            colCount, colSum
        },
        data() {
            return {
                form: {},
                fund_summery: {},
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
                        searchable: false,
                        sortable: true,
                        label: _t('deposit', 'Deposit'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'withdrawn_amount',
                        searchable: true,
                        sortable: false,
                        label: _t('withdrawn', 'Withdrawn'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'funds_balance',
                        searchable: false,
                        sortable: true,
                        label: _t('funds_balance', 'Funds Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'sales_payable',
                        searchable: false,
                        sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'sales_paid',
                        searchable: false,
                        sortable: true,
                        label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'sales_balance',
                        sortable: true,
                        searchable: false,
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'final_balance',
                        sortable: true,
                        searchable: false,
                        label: _t('final_balance', 'Final Balance'),
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
