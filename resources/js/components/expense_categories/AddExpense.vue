<template>
    <form @submit.prevent="hitSubmit" ref="theForm">
        <b-form-group :label="__('amount','Amount') +' *'">
            <b-input type="number" step="any" v-model="form.amount"
                     :placeholder="__('expense_amount','Expense Amount')"
                     :required="true"/>
        </b-form-group>
        <b-form-group :label="__('reference','Reference')">
            <b-input type="text"
                     :placeholder="__('expense_reference','Expense Reference')"
                     v-model="form.reference"/>
        </b-form-group>
        <b-form-group :label="__('description','Description')">
            <b-form-textarea
                :placeholder="__('description','Description')"
                v-model="form.description"/>
        </b-form-group>
        <b-button variant="dark" type="submit" block>
            {{__('submit','SUBMIT')}}
        </b-button>
<!--        <pre v-html="form"></pre>-->
    </form>
</template>

<script>
    import add_form from "@/partials/add_form";

    export default {
        mixins: [add_form],
        props: {
            expenseCategoryId: {
                type: Number,
                required: true
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Expenses.Store')
            }
        },
        mounted() {
            this.$set(this.form, 'expense_category_id', this.expenseCategoryId);
        },
        methods: {
            hitSubmit() {
                if (this.$refs.theForm.reportValidity()) {
                    this.onSubmit();
                }
            },
        }
    }
</script>

<style scoped>

</style>
