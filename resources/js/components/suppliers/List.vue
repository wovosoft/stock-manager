<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card :title="__('purchases_amount','Purchases Amount')">
                    {{fund_summery.payable | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('purchases_paid','Purchases Paid')">
                    {{fund_summery.paid | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('purchases_balance','Purchases Balance')">
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


                    <template v-slot:foot(payable)="row">
                        {{colSum(datatable.items,'payable') | currency}}
                    </template>
                    <template v-slot:foot(paid)="row">
                        {{colSum(datatable.items,'paid') | currency}}
                    </template>
                    <template v-slot:foot(balance)="row">
                        {{colSum(datatable.items,'balance') | currency}}
                    </template>

                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button
                                variant="dark"
                                :title="__('take_payment','Take Payment')"
                                v-b-modal:add_fund_modal
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-money-bill"></i>
                            </b-button>
                            <b-button
                                variant="primary"
                                :title="__('view','View')"
                                :to="{name:'SuppliersView',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button
                                variant="warning"
                                :title="__('edit','Edit')"
                                :to="{name:'SuppliersAdd',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button
                                variant="danger"
                                :title="__('delete','Delete')"
                                @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>

        <b-modal id="add_fund_modal"
                 v-if="currentItem"
                 lazy
                 hide-footer
                 @hidden="currentItem=null"
                 :title="__('add_payment','Add Payment')"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-fund
                    @success="v=>{if(v) hide();}"
                    @refresh="v=>$refs.datatable.refresh()"
                    v-if="currentItem && currentItem.id"
                    :payment-amount="Number(Number(currentItem.balance).toFixed(2))"
                    :supplier_id="currentItem.id"/>
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
    import AddFund from "@/components/suppliers/AddFund";

    export default {
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
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'SuppliersAdd'}
                    },
                    {
                        text: _t('history', 'History'),
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
                        key: 'payable',
                        searchable: false,
                        sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'paid',
                        searchable: false,
                        sortable: true,
                        label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'balance',
                        sortable: true,
                        searchable: false,
                        label: _t('balance', 'Balance'),
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
