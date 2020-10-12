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
                <b-button size="sm" variant="dark" v-b-modal:add-salary>
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
            :per-page="dt.per_page"
            :current-page="dt.current_page">
            <template #foot(payment_amount)="row">
                {{colSum(dt.data,'payment_amount') | currency}}
            </template>
        </b-table>
        <b-modal id="add-salary"
                 header-bg-variant="dark"
                 header-text-variant="light"
                 hide-footer
                 @hidden="resetForm"
                 :title="__('send_salary','Send Salary')">
            <template #default="{hide}">
                <b-form @submit.prevent="handleSubmit(hide)">
                    <b-form-group :label="__('employee','Employee')">
                        <vue-select
                            :required="true"
                            v-model="employee"
                            :init-options="true"
                            @input="e=>{
                                $set(form,'payment_amount',e.salary);
                                employeeId=e.id;
                            }"
                            :tag-text="o=>o?[o.id,o.name].join(' # '):__('not_selected','Not Selected')"
                            :option-text="o=>o?[o.id,o.name].join(' # '):''"
                            :api_url="route('Backend.Employees.Search').url()"/>
                    </b-form-group>
                    <b-form-row>
                        <b-col sm="12" md="6">
                            <b-form-group :label="__('year','Year')">
                                <b-form-select
                                    :required="true"
                                    v-model="form.year"
                                    :options="[2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030]"/>
                            </b-form-group>
                        </b-col>
                        <b-col sm="12" md="6">
                            <b-form-group :label="__('month','Month')">
                                <b-form-select
                                    v-model="form.month"
                                    :options="monthOptions"/>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
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
    import months from "@/shared/months";
    import dt from "@/shared/dt"
    import {isTrue, msgBox, colSum} from "@/partials/datatable";
    import {monthOptions} from "@/shared/months";
    import payment_options from "@/shared/payment_options";
    import dayjs from "dayjs"
    import VueSelect from "@/partials/VueSelect";

    const date = dayjs();
    const form_data = {
        year: Number(date.format('YYYY')),
        month: Number(date.format('MM')),
        payment_method: 'Cash',
        payment_amount: 0,
        date: date.format("YYYY-MM-DD")
    };
    export default {
        name: "EmployeeSalaries",
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
                dt, monthOptions, payment_options,
                form: {...form_data},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'name', sortable: true, label: _t('employee', 'Employee')},
                    // {
                    //     key: 'year',
                    //     sortable: true,
                    //     label: _t('year', 'Year'),
                    //     formatter: v => this.$options.filters.localNumber(v)
                    // },
                    // {
                    //     key: 'month', sortable: true,
                    //     label: _t('month', 'Month'),
                    //     formatter: v => months[v - 1]
                    // },
                    {
                        key: 'payment_amount', sortable: true,
                        formatter: v => this.$options.filters.currency(v),
                        label: _t('payment_amount', 'Payment Amount')
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localTime(v)
                    },
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
                return axios.post(route('Backend.Employees.Salaries.List', {page: ctx.currentPage}).url(), {
                    date: this.date,
                    per_page: ctx.perPage || 10,
                    orderBy: ctx.sortBy || 'id',
                    order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                }).then(res => {
                    this.$set(this, 'dt', res.data);
                    return res.data.data;
                }).catch(err => {
                    console.log(err.response);
                    this.$set(this, 'dt', {
                        data: [],
                        per_page: 30,
                        current_page: 1
                    });
                    return [];
                });
            },
            msgBox,
            handleSubmit(hide) {
                axios
                    .post(route('Backend.Employees.Salaries.Store', {employee: this.employeeId}).url(), this.form)
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
<style>
   @level components{
       .card{
           @apply
       }
   }
</style>

