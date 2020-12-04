<template>
    <dt-table
        ref="datatable"
        :title="title"
        v-model="search"
        :fields="fields"
        :datatable="datatable"
        v-if="api_url"
        :custom_buttons="custom_buttons">
        <template v-slot:table>
            <b-table ref="customer_payments" v-bind="commonDtOptions(the)">
                <template #cell(action)="row">
                    <b-button-group size="sm">
                        <b-button variant="primary"
                                  target="_blank"
                                  :href="route('Backend.Payments.Sales.Invoice',{salePayment:row.item.id,pdf:'html'}).url()"
                                  :title="__('invoice','Invoice')">
                            <i class="fa fa-eye"></i>
                        </b-button>
                        <b-button variant="dark"
                                  target="_blank"
                                  :href="route('Backend.Payments.Sales.Invoice',{salePayment:row.item.id,pdf:'pdf'}).url()"
                                  :title="__('invoice','Invoice')">
                            <i class="fa fa-file-invoice"></i>
                        </b-button>
                        <b-button variant="danger"
                                  target="_blank"
                                  @click="trash(row.item.id,'customer_payments',route('Backend.Payments.Sales.Delete').url())"
                                  :title="__('trash','Trash')">
                            <i class="fa fa-trash"></i>
                        </b-button>
                    </b-button-group>
                </template>
                <template #foot(payment_amount)="row">
                    {{colSum(datatable.items,'payment_amount') | currency}}
                </template>
            </b-table>
        </template>
    </dt-table>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, commonDtOptions, msgBox} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";

    export default {
        name: "CustomerPaymentList",
        components: {
            DtHeader,
            DtFooter,
            DtTable
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('payment_history', 'Payment History')
            },
            customerId: {
                type: Number,
                required: true
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },

        },
        methods: {
            msgBox,
            colSum,
            commonDtOptions
        },
        mounted() {
            this.api_url = route('Backend.Customers.Payments', {customer: this.customerId}).url();
        },
        data() {
            return {
                the: this,
                options: {},
                api_url: null,
                fields: [
                    {key: 'id', label: _t('id', 'ID'), name: 'sale_payments.id', sortable: true},
                    {key: 'name', label: _t('name', 'Name'), name: 'customers.name', sortable: true},
                    {
                        key: 'payment_method',
                        label: _t('method', 'Method'),
                        name: 'sale_payments.payment_method',
                        sortable: true
                    },
                    {
                        key: 'payment_amount',
                        label: _t('amount', 'Amount'),
                        name: 'sale_payments.payment_amount',
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'bank', label: _t('bank', 'Bank'), name: 'sale_payments.bank', sortable: true},
                    {key: 'check', label: _t('check', 'Check'), name: 'sale_payments.check', sortable: true},
                    {
                        key: 'transaction_no',
                        label: _t('transaction_no', 'Txn. No.'),
                        name: 'sale_payments.transaction_no', sortable: true
                    },
                    {
                        key: 'created_at',
                        label: _t('date', 'Date'),
                        name: 'sale_payments.created_at',
                        formatter: v => this.$options.filters.localDateTime(v),
                        sortable: true
                    },
                    {
                        key: 'action',
                        label: _t('action', 'Action'),
                        sortable: false,
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    }
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
