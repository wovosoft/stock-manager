<template>
    <b-modal @hidden="()=>{
                if(routerBackOnClose){
                    $router.go(-1);
                }
               $emit('reset',true);
               form={};
            }"
             v-model="visible"
             :size="size"
             header-bg-variant="dark"
             header-text-variant="light"
             body-class="p-2"
             footer-class="p-2"
             :title="__((form.id?'edit':'add')+'_expense',(form.id?'Edit ':'Add ')+'Expense')"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-group :label="__('expense_category','Expense Category')">
                <b-input-group>
                    <vue-select
                        :init-options="true"
                        :required="true"
                        @input="v=>form.expense_category_id=v?v.id:null"
                        v-model="form.expense_category"
                        :api_url="route('Backend.Expenses.Categories.Search').url()">
                        <template v-slot:option="op">
                            {{[op.item.id,op.item.name].join(' # ')}}
                        </template>
                        <template v-slot:tag="op">
                            {{op.tag?[op.tag.id,op.tag.name].join(' # '):__('not_selected','Not Selected')}}
                        </template>
                    </vue-select>
                    <template v-slot:append>
                        <b-button @click="form.expense_category_id=null,form.expense_category=null">x</b-button>
                    </template>
                </b-input-group>
            </b-form-group>
            <b-form-group :label="__('payment_amount','Amount') +' *'">
                <b-input type="number" step="any" v-model="form.amount"
                         :placeholder="__('expense_amount','Expense Amount')" :required="true"/>
            </b-form-group>
            <b-form-group :label="__('reference','Reference')">
                <b-input type="text"
                         :placeholder="__('expense_reference','Expense Reference')"
                         v-model="form.reference"/>
            </b-form-group>
            <b-form-group :label="__('description','Description')">
                <b-form-textarea :placeholder="__('description','Description')" v-model="form.description"/>
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
    import VueSelect from "@/partials/VueSelect";

    export default {
        mixins: [add_form],
        components: {
            VueSelect
        },
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Expenses.Store').url()
            },
            routerBackOnClose: {
                type: Boolean,
                default: () => true
            },
            isVisible: {
                type: Boolean,
                default: () => true
            },
            size: {
                type: String,
                default: () => "lg"
            }
        },
        created() {
            this.$set(this, 'visible', this.isVisible);
        },
        watch: {
            "isVisible": {
                handler(value) {
                    this.$set(this, 'visible', value);
                }
            }
        }
    }
</script>

