<template>
    <div>
        <b-card :header="__('customer_balance_sheet','Customer Balance Sheet')" body-class="p-2">
            <vue-select
                :required="true"
                @input="customerSelected"
                v-model="form.customer"
                :api_url="route('Backend.Customers.Search').url()">
                <template v-slot:option="op">
                    {{[op.item.id,op.item.name,op.item.phone,op.item.email].join(' # ')}}
                </template>
                <template v-slot:tag="op">
                    {{op.tag?[op.tag.id,op.tag.name,op.tag.phone,op.tag.email].join(' # ')
                    :__('not_selected','Not Selected')}}
                </template>
            </vue-select>
            <b-table v-if="output"
                     head-variant="dark"
                     bordered
                     hover
                     striped
                     small
                     :fields="[
                         {key:'key',label:__('key','Key')},
                         {key:'value',label:__('value','Value')},
                     ]"
                     :items="obj2Table(output)">
                <template v-slot:cell(key)="row">
                    {{__(row.item.key,startCase(row.item.key))}}
                </template>
                <template v-slot:cell(value)="row">
                    <template
                        v-if="['funds_deposit','funds_withdrawn','funds_balance','deposit_amount','withdrawn_amount','sales_payable','sales_paid','sales_balance','final_balance'].includes(row.item.key)">
                        <strong :class="{'text-danger':['funds_balance','sales_balance'].includes(row.item.key)}">
                            {{row.item.value|currency}}
                        </strong>
                    </template>
                    <template v-else>
                        {{row.item.value}}
                    </template>
                </template>
            </b-table>
            <template v-slot:footer v-if="form.customer">
                <b-button size="sm"
                          variant="primary"
                          v-b-modal:add_fund_modal
                          :title="__('add_more_fund','Add More Fund')">
                    {{__('add_fund','Add Fund')}}
                </b-button>
                <b-button size="sm"
                          v-b-modal:due_sales_modal
                          :title="__('make_due_sales_payment_from_available_fund','Make Due Sales Payment From Available Fund')"
                          variant="dark">
                    {{__('make_due_payments','Make Due Payments')}}
                </b-button>
            </template>
        </b-card>
        <b-modal id="add_fund_modal"
                 v-if="form.customer"
                 lazy
                 hide-footer
                 :title="__('add_fund','Add Fund')"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-fund
                    @success="v=>{if(v) hide();}"
                    @refresh="v=>getCustomer(form.customer.id)"
                    v-if="form.customer && form.customer.id"
                    :customer_id="form.customer.id"/>
            </template>
        </b-modal>
        <b-modal id="due_sales_modal"
                 body-class="p-1"
                 v-if="output"
                 lazy
                 size="xl"
                 hide-footer
                 title="Due Sales"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <due-sales
                    @message="v=>msgBox(v)"
                    @success="v=>{if(v) getCustomer(output.id)}"
                    :customer-record="output"/>
            </template>
        </b-modal>
    </div>
</template>
<script>
    import VueSelect from "@/partials/VueSelect";
    import {obj2Table, startCase} from '@/partials/datatable';
    import AddFund from "@/components/customers/AddFund";
    import DueSales from "@/components/sales/DueSales";
    import {msgBox} from "@/partials/datatable";

    export default {
        components: {
            VueSelect,
            AddFund,
            DueSales
        },
        data() {
            return {
                form: {},
                output: {}
            }
        },
        methods: {
            msgBox,
            obj2Table,
            startCase,
            customerSelected(v) {
                this.form.customer_id = v ? v.id : null;
                if (v && v.id) {
                    this.getCustomer(v.id);
                }
            },
            getCustomer(id) {
                axios.post(route("Backend.Balance.Customers.Single").url(), {
                    customer_id: id
                }).then(res => {
                    this.$set(this, 'output', res.data);
                    // console.log(res.data);
                }).catch(err => {
                    this.$set(this, 'output', {});
                    console.log(err.response.data);
                });
            }
        }
    }
</script>
