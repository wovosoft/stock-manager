<template>
    <div>
        <b-row class="my-2">
            <b-col>
                <b-input-group size="sm" :prepend="__('per_page','Per Page')">
                    <b-select
                        v-model="dt.per_page"
                        :options="[5,10,20,30,50,80,100,150,500]"/>
                </b-input-group>
            </b-col>
            <b-col class="text-right">
                <b-button size="sm" variant="dark" v-b-modal:add-capital-deposit>
                    <i class="fa fa-plus"></i>
                    {{ __("add", "Add") }}
                </b-button>
            </b-col>
        </b-row>
        <b-table
            ref="capitalDepositsList"
            small
            bordered
            hover
            striped
            head-variant="dark"
            foot-clone
            foot-variant="light"
            :sort-desc.sync="dt.sortDesc"
            :sort-by.sync="dt.sortBy"
            :per-page="dt.per_page"
            :current-page="dt.current_page"
            :api-url="route('Backend.Capital.Deposits.List', {page: dt.current_page, date: date}).url()"
            :fields="fields"
            :items="getItems">
            <template #foot(payment_amount)="row">
                {{colSum(dt.data,'payment_amount') | currency}}
            </template>
        </b-table>

        <dt-footer :datatable="dt"></dt-footer>
        <b-modal id="add-capital-deposit"
                 header-bg-variant="dark"
                 header-text-variant="light"
                 hide-footer
                 @hidden="resetForm"
                 :title="__('deposit_payment','Deposit Payment')">
            <template #default="{hide}">
                <b-form @submit.prevent="handleSubmit(hide)">
                    <b-form-group :label="__('reference','Reference')">
                        <b-input type="text" :placeholder="__('reference','Reference')" v-model="form.reference"/>
                    </b-form-group>
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('payment_amount','Payment Amount')">
                                <b-input
                                    type="number"
                                    step="any"
                                    :required="true"
                                    v-model="form.payment_amount"/>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('payment_method','Payment Method')">
                                <b-select
                                    @change="()=>{
                                        bank=null;
                                        check_no=null;
                                        transaction_no=null
                                    }"
                                    :required="true"
                                    v-model="form.payment_method"
                                    :options="payment_options"/>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                    <template v-if="form.payment_method==='Bank'">
                        <b-form-group :label="__('bank','Bank')">
                            <b-input type="text" :placeholder="__('bank','Bank')" v-model="form.bank"/>
                        </b-form-group>
                        <b-form-group :label="__('check','Check')">
                            <b-input type="text" :placeholder="__('check','Check')" v-model="form.check_no"/>
                        </b-form-group>
                        <b-form-group :label="__('transaction_no','Transaction No')">
                            <b-input type="text" :placeholder="__('transaction_no','Transaction No')"
                                     v-model="form.transaction_no"/>
                        </b-form-group>
                    </template>
                    <b-button block variant="dark" type="submit">
                        {{__('submit','SUBMIT')}}
                    </b-button>
                </b-form>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import {isTrue} from "@/partials/datatable";
    import DtFooter from "@/partials/DtFooter";
    import {startCase, colSum, colCount, msgBox} from "@/partials/datatable";
    import dt from "@/shared/dt";
    import payment_options from "@/shared/payment_options";

    const form_data = {
        reference: '',
        payment_amount: 0,
        payment_method: 'Cash',
        bank: null,
        check_no: null,
        transaction_no: null
    };
    export default {
        name: "CapitalDepost",
        components: {
            DtFooter,
        },
        props: {
            date: {
                type: String,
                required: true
            }
        },
        watch: {
            "date": {
                handler() {
                    this.$refs.capitalDepositsList.refresh();
                }
            }
        },
        data() {
            return {
                dt: {...dt},
                form: {...form_data},
                payment_options,
                fields: [
                    {key: 'id', label: _t('id', 'ID')},
                    {key: 'reference', label: _t('reference', 'Reference')},
                    {
                        key: 'payment_amount', label: _t('payment_amount', 'Payment Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'created_at',
                        label: _t('time', 'Time'),
                        formatter: v => this.$options.filters.localTime(v)
                    },
                ]
            }
        },
        methods: {
            startCase, colSum, colCount, msgBox,
            handleSubmit(hide) {
                axios
                    .post(route('Backend.Capital.Deposits.Store').url(), this.form)
                    .then(res => {
                        hide();
                        this.msgBox(res.data);
                        this.$refs.capitalDepositsList.refresh();
                    })
                    .catch(err => {
                        this.msgBox(err.response.data);
                        console.log(err.response);
                    });
            },
            resetForm() {
                this.$set(this, 'form', {...form_data});
            },
            getItems(ctx) {
                return axios
                    .post(ctx.apiUrl, {
                        date: this.date,
                        per_page: ctx.perPage || 10,
                        orderBy: ctx.sortBy || 'id',
                        order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                    })
                    .then((res) => {
                        this.dt = {...this.dt, ...res.data};
                        return res.data.data;
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.$set(this, 'dt', {...dt});
                        return [];
                    });
            },
        }
    }
</script>

<style scoped>

</style>
