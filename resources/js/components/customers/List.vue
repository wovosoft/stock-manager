<template>
    <div>
        <b-row class="mb-3">
            <b-col md="3" sm="12">
                <b-card :title="__('sales_amount','Sales Amount')">
                    {{fund_summery.payable | currency}}
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card :title="__('received_amount','Received')">
                    {{fund_summery.paid | currency}}
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card :title="__('returned_total','Returned Total')">
                    {{fund_summery.returned | currency}}
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card :title="__('balance','Balance')">
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
            <template #header_dropdowns>
                <b-checkbox size="sm" @change="changeApiUrl" inline
                            :title="__('customers_with_due','Customers With Due')" switch>
                    {{__('with_due','With Due')}}
                </b-checkbox>
                <b-button size="sm" variant="dark" @click="$refs.datatable.refresh()">
                    <i class="fa fa-sync"></i>
                </b-button>
            </template>
            <template v-slot:table>
                <b-table
                    ref="datatable"
                    @refreshed="fund_summery=JSON.parse(headers.fund_summery||'{}')"
                    v-bind="commonDtOptions(the)">
                    <template v-slot:foot(payable)="row">
                        {{colSum(datatable.items,'payable') | currency}}
                    </template>
                    <template v-slot:foot(paid)="row">
                        {{colSum(datatable.items,'paid') | currency}}
                    </template>
                    <template v-slot:foot(returned)="row">
                        {{colSum(datatable.items,'returned') | currency}}
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
                                :title="__('payment_history','Payment History')"
                                v-b-modal:payment_history
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-money-check"></i>
                            </b-button>
                            <b-dropdown right size="sm">
                                <b-dropdown-item
                                    :title="__('returns_history','Returns History')"
                                    v-b-modal:returns-modal
                                    @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-retweet"></i>
                                    {{__('returns_history','Returns History')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('view','View')"
                                    :to="{name:'CustomersView',params:{id:row.item.id}}"
                                    @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-eye"></i> {{__('view','View')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('edit','Edit')"
                                    :to="{name:'CustomersAdd',params:{id:row.item.id}}"
                                    @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-edit"></i> {{__('edit','Edit')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('delete','Delete')"
                                    @click="trash(row.item.id)">
                                    <i class="fa fa-trash"></i> {{__('delete','Delete')}}
                                </b-dropdown-item>
                            </b-dropdown>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>

        <b-modal id="add_fund_modal"
                 v-if="currentItem"
                 v-bind="{...BasicModalOptions,size:'sm',bodyClass:'p-2',hideFooter:true}"
                 @hidden="currentItem={}"
                 :title="__('add_payment','Add Payment')">
            <template v-slot:default="{hide}">
                <add-fund
                    @success="v=>{if(v) hide();}"
                    @refresh="v=>$refs.datatable.refresh()"
                    v-if="currentItem && currentItem.id"
                    :payment-amount="Number(Number(currentItem.balance).toFixed(2))"
                    :customer_id="currentItem.id"/>
            </template>
        </b-modal>
        <b-modal id="payment_history"
                 v-bind="{...BasicModalOptions,bodyClass:'p-2'}"
                 @hidden="currentItem={}"
                 :title="__('payment_history','Payment History')">
            <payments :customer-id="currentItem.id"></payments>
        </b-modal>
        <b-modal id="returns-modal"
                 v-bind="BasicModalOptions"
                 @hidden="currentItem={}"
                 :title="__('returns_history','Returns History')">
            <returns :customer-id="currentItem.id"></returns>
        </b-modal>
        <router-view @reset="currentItem={}"
                     @refreshDatatable="()=>$refs.datatable.refresh()"
                     :item="currentItem"></router-view>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {
        colCount,
        colSum,
        commonDtOptions,
        BasicModalOptions,
        isTrue
    } from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import AddFund from "@/components/customers/AddFund";
    import Payments from "@/components/customers/Payments";
    import Returns from "@/components/customers/Returns";

    export default {
        name: "CustomersList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            AddFund,
            Payments,
            Returns
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('customers', 'Customers')
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
            colCount, colSum, commonDtOptions,
            changeApiUrl(value) {
                if (isTrue(value)) {
                    this.api_url = route('Backend.Customers.ListWithDues').url();
                } else {
                    this.api_url = route('Backend.Customers.List').url();
                }
                this.$refs.datatable.refresh();
            }
        },
        data() {
            return {
                api_url: route('Backend.Customers.List').url(),
                the: this,
                BasicModalOptions,
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
                        label: _t('customers.paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'returned',
                        searchable: false,
                        sortable: true,
                        label: _t('returned', 'Returned'),
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
