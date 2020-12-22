<template>
    <b-row>
        <b-col md="4" sm="12" v-if="customerOverview">
            <table class="table table-sm table-striped table-bordered">
                <tr>
                    <th>{{__('customer_id','Customer ID')}}</th>
                    <td>: {{sale.customer_id}}</td>
                </tr>
                <tr>
                    <th>{{__('customer_name','Customer Name')}}</th>
                    <td>: {{sale.customer_name}}</td>
                </tr>
                <tr>
                    <th>{{__('payable','Payable')}}</th>
                    <td>: {{sale.payable | currency}}</td>
                </tr>
                <tr>
                    <th>{{__('paid','Paid')}}</th>
                    <td>: {{sale.paid | currency}}</td>
                </tr>
                <tr>
                    <th>{{__('balance','Balance')}}</th>
                    <td>: {{sale.balance | currency}}</td>
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
            sale: {
                type: Object,
                required: true
            },
            customerOverview: {
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
                    {key: 'taken_by', label: _t('taken_by', 'Taken By')},
                    {
                        key: 'created_at',
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.dayjs(v)
                    }
                ]
            }
        },
        mounted() {
            this.getItems((this.sale && this.sale.id) ? this.sale.id : this.$route.params.id);
        },
        methods: {
            getItems(sale_id) {
                axios
                    .post(route("Backend.Payments.Single.Sales.Payments", {sale: sale_id}))
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
