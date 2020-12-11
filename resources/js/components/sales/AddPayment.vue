<template>
    <div>
        <b-alert variant="danger" v-if="form.payment_amount===0" show>
            {{__('payment_is_completed_for_this_sale',
            'Payment is completed for this Sale. No further action required.')}}
        </b-alert>
        <b-form v-else @submit.prevent="handleSubmit">
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
                    :options="payment_options"/>
            </b-form-group>
            <b-form-group :label="__('date','Date')">
                <b-input type="date" :required="true" v-model="form.date"/>
            </b-form-group>
            <b-button block variant="dark" type="submit">
                {{__('submit','SUBMIT')}}
            </b-button>
        </b-form>
    </div>
</template>
<script>
    import dayjs from "dayjs"
    import payment_options from "@/shared/payment_options";

    export default {
        props: {
            sale: {
                type: Object,
                required: true
            },
            payment_options: {
                type: Array,
                default: () => payment_options
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
            this.form.payment_amount = this.sale.balance;
        },
        methods: {
            handleSubmit() {
                if (Number(this.form.sale_payment) === 0) {
                    alert("Payment Amount Can't be 0");
                    return false;
                }
                axios.post(route('Backend.Payments.Sales.Store', {sale: this.sale.id}), this.form)
                    .then(res => {
                        this.$emit('msgBox', res.data);
                        this.$emit("success", true);
                        this.$emit('refresh', true);
                    })
                    .catch(err => {
                        this.$emit("success", false);
                        this.$emit('msgBox', err.response.data);
                        console.log(err.response);
                    });
            }
        }
    }
</script>
