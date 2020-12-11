<template>
    <b-row>
        <b-col md="4" sm="12" v-if="supplierOverview">
            <table class="table table-sm">
                <tr>
                    <th>{{__('supplier_id','Supplier ID')}}</th>
                    <td>: {{purchase.supplier_id}}</td>
                </tr>
                <tr>
                    <th>{{__('supplier_name','Supplier Name')}}</th>
                    <td>: {{purchase.supplier_name}}</td>
                </tr>
                <tr>
                    <th>{{__('payable','Payable')}}</th>
                    <td>: {{purchase.payable | currency}}</td>
                </tr>
                <tr>
                    <th>{{__('paid','Paid')}}</th>
                    <td>: {{purchase.paid | currency}}</td>
                </tr>
                <tr>
                    <th>{{__('balance','Balance')}}</th>
                    <td>: {{purchase.balance | currency}}</td>
                </tr>
            </table>
        </b-col>
        <b-col>
            <b-table
                small
                head-variant="dark"
                :items="items"
                :fields="fields">
            </b-table>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        props: {
            purchase: {
                type: Object,
                required: true
            },
            supplierOverview: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                items: [],
                fields: [
                    {key: 'id', label: _t('id', 'ID')},
                    {key: 'payment_method', label: _t('payment_method', 'Method')},
                    {
                        key: 'payment_amount',
                        label: _t('payment_amount', 'Payment Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'bank', label: _t('bank', 'Bank')},
                    {key: 'check', label: _t('check', 'Check')},
                    {key: 'transaction_no', label: _t('transaction_no', 'Transaction No.')},
                    {key: 'given_by', label: _t('given_by', 'Given By')},
                    {
                        key: 'created_at',
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.dayjs(v)
                    }
                ]
            }
        },
        mounted() {
            this.getItems(this.purchase && this.purchase.id ? this.purchase.id : this.$route.params.id);
        },
        methods: {
            getItems(purchase_id) {
                axios
                    .post(route("Backend.Payments.Single.Purchases.Payments", {purchase: purchase_id}))
                    .then(res => {
                        this.$set(this, 'items', res.data);
                    })
                    .catch(err => {
                        this.$set(this, 'items', []);
                        console.log(err.response);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
