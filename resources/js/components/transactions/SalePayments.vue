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
                <b-button size="sm" variant="dark" v-b-modal:add-sale-payment>
                    <i class="fa fa-plus"></i>
                    {{ __("add", "Add") }}
                </b-button>
            </b-col>
        </b-row>
        <b-table
            ref="dt_table"
            small
            bordered
            hover
            striped
            head-variant="dark"
            foot-clone
            foot-variant="light"
            :items="getItems"
            :fields="fields"
            :sort-desc="dt.sortDesc"
            :sort-by="dt.sortBy"
            :per-page="dt.per_page"
            :current-page="dt.current_page">
            <template #foot(payment_amount)="row">
                {{colSum(dt.data,'payment_amount') | currency}}
            </template>
        </b-table>
        <b-modal id="add-sale-payment"
                 header-bg-variant="dark"
                 header-text-variant="light"
                 hide-footer
                 @hidden="resetForm"
                 :title="__('take_payment','Take Payment')">
            <template #default="{hide}">
                <b-form @submit.prevent="handleSubmit(hide)">
                    <b-form-group :label="__('customer','Customer')">
                        <vue-select
                            :required="true"
                            v-model="employee"
                            :init-options="true"
                            @input="e=>{
                                $set(form,'payment_amount',Number(Number(e.balance).toFixed(2)));
                                employeeId=e.id;
                            }"
                            :tag-text="o=>o?[o.id,o.name,o.village].join(' # '):__('not_selected','Not Selected')"
                            :option-text="o=>o?o.id+' | ' + o.name + ' | ' +  o.village +' | ' + ($options.filters.currency(o.balance)):''"
                            :api_url="route('Backend.Customers.SearchWithDues').url()"/>
                    </b-form-group>
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('transaction.income','Amount')">
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
                                    :required="true"
                                    v-model="form.payment_method"
                                    :options="payment_options"/>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                    <b-form-group :label="__('date','Date')">
                        <b-input type="date" :required="true" v-model="form.date"/>
                    </b-form-group>
                    <b-button block variant="dark" type="submit">
                        {{__('submit','SUBMIT')}}
                    </b-button>
                </b-form>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import dt from "@/shared/dt"
    import {isTrue, msgBox, colSum} from "@/partials/datatable";
    import payment_options from "@/shared/payment_options";
    import dayjs from "dayjs"
    import VueSelect from "@/partials/VueSelect";

    const date = dayjs();
    const form_data = {
        payment_method: 'Cash',
        payment_amount: 0,
        date: date.format("YYYY-MM-DD")
    };
    export default {
        name: "PurchasePayments",
        props: {
            date: {
                type: String,
                required: true
            }
        },
        components: {
            VueSelect
        },
        watch: {
            date(value) {
                this.$refs.dt_table.refresh();
            }
        },
        data() {
            return {
                dirty: false,
                employee: null,
                employeeId: null,
                dt, payment_options,
                form: {...form_data},
                fields: [
                    {key: 'id', label: _t('id', 'ID'), name: 'sale_payments.id', sortable: true},
                    {
                        key: 'customer',
                        label: _t('customer', 'Customer'),
                        name: 'customers.name',
                        sortable: true
                    },
                    {
                        key: 'payment_amount',
                        label: _t('transaction.income', 'Amount'),
                        name: 'sale_payments.payment_amount',
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'created_at',
                        label: _t('date', 'Date'),
                        name: 'sale_payments.created_at',
                        formatter: v => this.$options.filters.localTime(v),
                        sortable: true
                    }
                ]
            }
        },
        methods: {
            colSum,
            resetForm() {
                this.$set(this, 'form', {...form_data});
                this.employee = null;
                if (this.dirty) {
                    this.$refs.dt_table.refresh();
                    this.dirty = false;
                }
            },
            getItems(ctx) {
                return axios.post(route('Backend.Payments.Sales.List', {page: ctx.currentPage}).url(), {
                    date: this.date,
                    per_page: ctx.perPage || 10,
                    orderBy: ctx.sortBy || 'id',
                    order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                }).then(res => {
                    this.dt = {...this.dt, ...res.data};
                    return res.data.data;
                }).catch(err => {
                    console.log(err.response);
                    this.$set(this, 'dt', dt);
                    return [];
                });
            },
            msgBox,
            handleSubmit(hide) {
                axios
                    .post(route('Backend.Customers.Payments.Add', {customer: this.employeeId}).url(), this.form)
                    .then(res => {
                        hide();
                        this.msgBox(res.data);
                        this.dirty = true;
                    })
                    .catch(err => {
                        this.msgBox(err.response.data);
                        console.log(err.response);
                    });
            }
        }
    }
</script>


