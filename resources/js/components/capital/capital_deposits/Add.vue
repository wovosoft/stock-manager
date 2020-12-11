<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             header-bg-variant="dark"
             header-text-variant="light"
             hide-footer
             no-body
             @shown="()=>{if (!form.payment_method) $set(form,'payment_method','Cash')}"
             :title="__((form.id?'edit':'add')+'_fund',(form.id?'Edit ':'Add ')+'Fund')"
             lazy>
        <b-form @submit.prevent="onSubmit" ref="theForm">
            <b-form-group :label="__('reference','Reference')">
                <b-input
                    type="text"
                    :placeholder="__('reference','Reference')"
                    v-model="form.reference"/>
            </b-form-group>
            <b-form-group :label="__('deposit_amount','Deposit Amount')">
                <b-input-group append="BDT">
                    <b-input
                        type="number"
                        step="any"
                        :required="true"
                        :placeholder="__('deposit_amount','Deposit Amount')"
                        v-model="form.payment_amount"/>
                </b-input-group>
            </b-form-group>
            <b-form-group :label="__('deposit_method','Deposit Method')">
                <b-select
                    @change="form.bank=null,form.check=null,form.transaction_no=null"
                    :required="true"
                    v-model="form.payment_method"
                    :options="payment_options"/>
            </b-form-group>
            <template v-if="form.payment_method==='Bank'">
                <b-form-group :label="__('bank','Bank')">
                    <b-input v-model="form.bank" :placeholder="__('bank_name','Bank Name')" :required="true"/>
                </b-form-group>
                <b-form-group :label="__('check_no','Cheque No.')">
                    <b-input v-model="form.check_no" :placeholder="__('check_no','Cheque No.')" :required="true"/>
                </b-form-group>
                <b-form-group :label="__('transaction_no','Transaction No.')">
                    <b-input v-model="form.transaction_no"
                             :placeholder="__('transaction_no','Transaction No.')"
                             :required="true"/>
                </b-form-group>
            </template>
            <b-button block variant="dark" type="submit">
                {{__('submit','SUBMIT')}}
            </b-button>
        </b-form>

        <!--                <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import payment_options from "@/shared/payment_options";

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Capital.Deposits.Store')
            }
        },
        data() {
            return {
                payment_options
            }
        }
    }
</script>

