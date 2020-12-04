<template>
    <b-form @submit.prevent="handleSubmit">
        <b-form-row>
            <b-col sm="12" md="6">
                <b-form-group :label="__('year','Year')">
                    <b-form-select
                        :required="true"
                        v-model="form.year"
                        :options="rangeIndexed(2015,2030)"/>
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
                        :options="paymentOptions"/>
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
<script>
    import dayjs from "dayjs"
    import {msgBox, rangeIndexed} from "@/partials/datatable";
    import payment_options from "@/shared/payment_options";
    import {monthOptions} from "@/shared/months";

    export default {
        props: {
            employeeId: {
                type: Number,
                required: true
            },
            paymentOptions: {
                type: Array,
                default: () => payment_options
            },
            salary: {
                type: Number,
                default: 0
            }
        },

        data() {
            return {
                monthOptions,
                form: {
                    payment_amount: 0,
                    payment_method: 'Cash',
                    month: dayjs().format('M'),
                    year: dayjs().format('YYYY'),
                    date: dayjs().format("YYYY-MM-DD")
                }
            }
        },
        mounted() {
            this.$set(this.form, 'payment_amount', this.salary);
        },
        methods: {
            msgBox, rangeIndexed,
            handleSubmit() {
                axios
                    .post(route('Backend.Employees.Salaries.Store', {employee: this.employeeId}).url(), this.form)
                    .then(res => {
                        this.$emit('message', res.data);
                        this.$emit('success', true);
                        this.$emit('refresh', true);
                    })
                    .catch(err => {
                        this.$emit('success', false);
                        this.$emit('message', err.response.data);
                        console.log(err.response);
                    });
            }
        }
    }
</script>
