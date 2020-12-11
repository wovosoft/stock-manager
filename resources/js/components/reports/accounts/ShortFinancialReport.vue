<template>
    <div id="short_financial_reports">
        <b-card body-class="p-1">
            <template #header>
                <b-row>
                    <b-col>
                        <h5>{{__('short_financial_report','Short Financial Report')}}</h5>
                    </b-col>
                    <b-col class="text-right">
                        <b-button size="sm" target="_blank" variant="dark" @click="getItems">
                            <i class="fa fa-sync"></i>
                        </b-button>
                        <b-button size="sm" target="_blank" variant="dark"
                                  :href="route('Backend.Reports.ShortFinancialReport',{pdf:'pdf'})">
                            {{__('export','Export')}}
                        </b-button>
                    </b-col>
                </b-row>
            </template>
            <h2>{{__('capital','Capital')}}</h2>
            <b-table
                small
                hover
                bordered
                striped
                :fields="[
                        {key:'key',formatter:v=>__(v,startCase(v)),thClass:'d-none'},
                        {key:'value',formatter:v=>$options.filters.currency(v),thClass: 'd-none'}
                    ]"
                :items="obj2Table(pluck(report,['capital_deposit','capital_withdraw','capital_balance']))"/>
            <h2>{{__('purchase_amount','Purchase Amount')}}</h2>
            <b-table
                small
                hover
                bordered
                striped
                :fields="[
                        {key:'key',formatter:v=>__(v,startCase(v)),thClass:'d-none'},
                        {key:'value',formatter:v=>$options.filters.currency(v),thClass: 'd-none'}
                    ]"
                :items="obj2Table(pluck(report,['purchase_payable','purchase_payment','purchase_return','purchase_balance']))"/>

            <h2>{{__('sale_amount','Sale Amount')}}</h2>
            <b-table
                small
                hover
                bordered
                striped
                :fields="[
                        {key:'key',formatter:v=>__(v,startCase(v)),thClass:'d-none'},
                        {key:'value',formatter:v=>$options.filters.currency(v),thClass: 'd-none'}
                    ]"
                :items="obj2Table(pluck(report,['sales_payable','sale_payment','sale_return','sale_balance']))"/>

            <h2>{{__('others','Others')}}</h2>
            <b-table
                small
                hover
                bordered
                striped
                :fields="[
                        {key:'key',formatter:v=>__(v,startCase(v)),thClass:'d-none'},
                        {key:'value',formatter:v=>$options.filters.currency(v),thClass: 'd-none'}
                    ]"
                :items="obj2Table(pluck(report,['expense','employee_salary']))">
            </b-table>
            <hr>
            <table class="table table-dark">
                <tr>
                    <td>
                        {{__('remaining','Remaining')}}
                    </td>
                    <td>
                        {{report.balance | currency}}
                    </td>
                </tr>
            </table>

            <!--            <table class="table table-sm table-striped table-bordered table-hover">-->
            <!--                <tbody>-->
            <!--                <tr v-for="x in Object.keys(report)" :key="x">-->
            <!--                    <td>{{__(x,startCase(x))}}</td>-->
            <!--                    <td>{{report[x] | currency}}</td>-->
            <!--                </tr>-->
            <!--                </tbody>-->
            <!--            </table>-->
        </b-card>
    </div>
</template>

<script>
    import {startCase, pluck, obj2Table} from "@/partials/datatable";

    export default {
        name: "ShortFinancialReport",
        data() {
            return {
                report: {}
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
            startCase,
            pluck,
            obj2Table,
            getItems() {
                axios.post(route('Backend.Reports.ShortFinancialReport'))
                    .then(res => {
                        this.$set(this, 'report', res.data);
                    })
                    .catch(err => {
                        this.$set(this, 'report', {});
                        console.log(err.response.data);
                    });
            }
        }
    }
</script>

<style>
    #short_financial_reports td {
        width: 50%;
    }

    #short_financial_reports table:not(:last-child) tr:last-child td {
        color: red;
    }
</style>
