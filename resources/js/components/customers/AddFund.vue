<template>
    <b-form @submit.prevent="handleSubmit">
        <b-form-group :label="__('payment_amount','Payment Amount')">
            <b-input
                type="number"
                step="any"
                :required="true"
                v-model="form.payment_amount"/>
        </b-form-group>
        <b-form-group :label="__('payment_method','Payment Method')">
            <b-select
                :required="true"
                v-model="form.payment_method"
                :options="['Cash','Card','Bank','Rocket','bKash']"/>
        </b-form-group>
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

    export default {
        props: {
            customer_id: {
                type: Number,
                required: true
            },
            paymentAmount: {
                type: Number,
                default: () => 0
            }
        },
        data() {
            return {
                form: {
                    payment_amount: 0,
                    payment_method: 'Cash',
                    date: dayjs().format("YYYY-MM-DD")
                }
            }
        },
        mounted() {
            this.form.payment_amount = this.paymentAmount;
        },
        methods: {
            handleSubmit() {
                axios.post(route('Backend.Customers.Payments.Add', {customer: this.customer_id}), this.form)
                    .then(res => {
                        this.$root.msgBox(res.data);
                        this.$emit('success', true);
                        this.$emit('refresh', true);
                    })
                    .catch(err => {
                        this.$emit('success', false);
                        this.$root.msgBox(err.response.data);
                        console.log(err.response);
                    });
            }
        }
    }
</script>
