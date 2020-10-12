<template>
    <div>
        <h4 class="text-center">
            {{[supplierRecord.id,supplierRecord.name].join(" # ")}}
        </h4>
        <table class="table table-sm table-borderless">
            <tr>
                <th class="w-25">
                    {{__('available_funds','Available Funds')}}
                </th>
                <td>{{supplierRecord.funds_balance|currency}}</td>
            </tr>
            <tr>
                <th>{{__('payment_amount','Payment Amount')}}</th>
                <td>{{totalPaymentAmount|currency}}</td>
            </tr>
            <tr>
                <th>{{__('balance','Balance')}}</th>
                <td>
                    {{(Number(supplierRecord.funds_balance || 0)-(Number(totalPaymentAmount || 0)))|currency}}
                </td>
            </tr>
        </table>
        <b-table
            head-variant="dark"
            hover
            striped
            small
            :items="getItems"
            :fields="fields">
            <template v-slot:cell(paid)="row">
                {{(Number(row.item.paid || 0)+Number(row.item.payment_amount || 0)) | currency}}
            </template>
            <template v-slot:cell(balance)="row">
                {{(Number(row.item.balance || 0) - Number(row.item.payment_amount || 0)) | currency}}
            </template>
            <template v-slot:cell(payment_amount)="row">
                <b-form :ref="'payment-form-'+row.index">
                    <b-input-group>
                        <b-input
                            :required="true"
                            type="number"
                            step="any"
                            :min="0"
                            :max="Number(supplierRecord.funds_balance)"
                            v-model="row.item.payment_amount"
                            :placeholder="__('payment_amount','Payment Amount')"
                        />
                        <template v-slot:append>
                            <b-button @click="$set(row.item,'payment_amount',row.item.balance)">
                                {{__('full','Full')}}
                            </b-button>
                        </template>
                    </b-input-group>
                </b-form>
            </template>
            <template v-slot:cell(action)="row">
                <b-button
                    @click="handlePaymentSubmit('payment-form-'+row.index,row.item)"
                    variant="primary">
                    {{__('submit','SUBMIT')}}
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    //due sales of a certain supplier

    export default {
        props: {
            supplierRecord: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                items: [],
                fields: [
                    {key: 'id', label: _t('id', 'ID')},
                    {key: 'supplier_name', label: _t('supplier_name', 'Supplier Name')},
                    {
                        key: 'payable',
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'paid', label: _t('paid', 'Paid'), formatter: v => this.$options.filters.currency(v)},
                    {
                        key: 'balance',
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'payment_amount', label: _t('payment_amount', 'Payment Amount')},
                    {key: 'action', label: _t('action', 'Action'), tdClass: 'text-right', thClass: 'text-right'}
                ]
            }
        },
        computed: {
            totalPaymentAmount() {
                let total = 0;
                this.items.forEach(item => {
                    total += Number(item.payment_amount || 0);
                });
                return total;
            }
        },
        methods: {
            getItems() {
                return axios.post(route("Backend.Purchases.Due", {supplier: this.supplierRecord.id}).url())
                    .then(res => {
                        this.items = res.data;
                        return res.data;
                    }).catch(err => {
                        console.log(err.response);
                        this.items = [];
                        return [];
                    });
            },
            handlePaymentSubmit(the_form, data) {
                if (this.$refs[the_form].reportValidity()) {
                    let sdata = JSON.parse(JSON.stringify(data));
                    sdata.supplier_id = this.supplierRecord.id;
                    sdata.payment_method = "Credit";
                    axios
                        .post(route('Backend.Payments.Purchases.Store', {purchase: sdata.id}).url(), sdata)
                        .then(res => {
                            this.$emit("success", true);
                            this.$emit("message", res.data);
                            sdata = JSON.parse(JSON.stringify(data));
                            data.payment_amount = 0;
                        })
                        .catch(err => {
                            this.$emit("success", false);
                            this.$emit("message", err.response.data);
                            console.log(err.response.data);
                        });
                }
            }
        }
    }
</script>

<style scoped>

</style>
