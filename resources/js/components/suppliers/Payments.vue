<template>
    <dt-table
        :title="title"
        v-model="search"
        :fields="fields"
        :datatable="datatable"
        v-if="api_url"
        :custom_buttons="custom_buttons">
        <template v-slot:table>
            <b-table ref="datatable" v-bind="commonDtOptions(the)">
                <template #cell(action)="row">
                    <b-button-group size="sm">
                        <b-button variant="primary"
                                  target="_blank"
                                  :href="route('Backend.Payments.Purchases.Invoice',{purchasePayment:row.item.id,pdf:'html'})"
                                  :title="__('invoice','Invoice')">
                            <i class="fa fa-eye"></i>
                        </b-button>
                        <b-button variant="dark"
                                  target="_blank"
                                  :href="route('Backend.Payments.Purchases.Invoice',{purchasePayment:row.item.id,pdf:'pdf'})"
                                  :title="__('invoice','Invoice')">
                            <i class="fa fa-file-invoice"></i>
                        </b-button>
                        <b-button variant="danger"
                                  target="_blank"
                                  @click="trash(row.item.id,'datatable',route('Backend.Payments.Purchases.Delete'))"
                                  :title="__('trash','Trash')">
                            <i class="fa fa-trash"></i>
                        </b-button>
                    </b-button-group>
                </template>
                <template v-slot:foot(payment_amount)="row">
                    {{colSum(datatable.items,'payment_amount') | currency}}
                </template>
            </b-table>
        </template>
    </dt-table>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, commonDtOptions} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";

    export default {
        name: "SupplierPaymentList",
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
            supplierId: {
                type: Number,
                required: true
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        methods: {
            colSum,
            commonDtOptions
        },
        mounted() {
            this.api_url = route('Backend.Suppliers.Payments', {supplier: this.supplierId});
        },
        data() {
            return {
                the: this,
                options: {},
                api_url: null,
                fields: [
                    {key: 'id', label: _t('id', 'ID'), name: 'purchase_payments.id', sortable: true},
                    {key: 'name', label: _t('name', 'Name'), name: 'suppliers.name', sortable: true},
                    {
                        key: 'payment_method',
                        label: _t('method', 'Method'),
                        name: 'purchase_payments.payment_method',
                        sortable: true
                    },
                    {
                        key: 'payment_amount',
                        label: _t('amount', 'Amount'),
                        name: 'purchase_payments.payment_amount',
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'bank', label: _t('bank', 'Bank'), name: 'purchase_payments.bank', sortable: true},
                    {key: 'check', label: _t('check', 'Check'), name: 'purchase_payments.check', sortable: true},
                    {
                        key: 'transaction_no',
                        label: _t('transaction_no', 'Txn. No.'),
                        name: 'purchase_payments.transaction_no', sortable: true
                    },
                    {
                        key: 'created_at',
                        label: _t('date', 'Date'),
                        name: 'purchase_payments.created_at',
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
