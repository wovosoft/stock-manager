<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true),$emit('refreshDatatable',true)"
             v-model="visible"
             v-bind="{...BasicModalOptions,size:'md'}"
             :title="__((form.id?'edit':'add')+'_collection',(form.id?'Edit ':'Add ')+'Collection')">
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-group :label="__('select_customer','Select Customer')">
                <b-input-group>
                    <vue-select
                        :init-options="true"
                        size="md"
                        :required="true"
                        @input="(v) =>{
                            form.previous_balance=v?v.balance:0;
                            form.customer_id=v?v.id:null;
                        }"
                        v-model="form.customer"
                        :tag-text="(op) =>op? [op.id, op.name].join(' # '): __('not_selected','Not Selected')"
                        :option-text="(op) =>op? [op.id, op.name, op.village].join(' # '): __('not_selected','Not Selected')"
                        :api_url="route('Backend.Customers.Search')"
                    />
                    <template #append>
                        <b-button variant="dark" :title="__('reset','Reset')"
                                  @click="()=>{
                                      form.customer=null;
                                      form.customer_id=null;
                                      form.previous_balance=0;
                                  }">
                            <b-icon-x/>
                        </b-button>
                    </template>
                </b-input-group>
            </b-form-group>
            <b-form-group :label="__('previous_balance','Previous Balance')">
                <div class="form-control bg-light">{{form.previous_balance|currency}}</div>
            </b-form-group>
            <b-form-group :label="__('payment_amount','Payment Amount')">
                <b-input
                    required
                    type="number"
                    step="any"
                    :min="0"
                    v-model="form.payment_amount"
                    :placeholder="__('payment_amount','Payment Amount')"/>
            </b-form-group>
            <b-form-group :label="__('current_balance','Current Balance')">
                <div class="form-control bg-light">{{currentBalance|currency}}</div>
            </b-form-group>
            <b-form-group :label="__('reference','Reference')">
                <b-input
                    type="text"
                    v-model="form.reference"
                    :placeholder="__('payment_reference','Payment Reference')"/>
            </b-form-group>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="onSubmit">
                {{__('submit','SUBMIT')}}
            </b-button>
            <b-button @click="cancel()">
                {{__('cancel','CANCEL')}}
            </b-button>
        </template>
        <!--        <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import {BasicModalOptions} from "@/partials/datatable";
    import VueSelect from "@/partials/VueSelect";

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Collections.Store')
            }
        },
        components: {VueSelect},
        computed: {
            currentBalance() {
                return Number(this.form.previous_balance || 0) - Number(this.form.payment_amount || 0);
            }
        },
        data() {
            return {
                BasicModalOptions
            }
        }
    }
</script>

