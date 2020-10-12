<template>
    <div>
        <b-form @submit.prevent="handleSubmit" ref="the_form">
            <b-form-row>
                <b-col md="4" sm="12">
                    <b-form-group :label="__('starting_date','Starting Date')">
                        <b-input-group>
                            <b-input type="date" v-model="form.starting_date"/>
                            <template v-slot:append>
                                <b-button @click="form.starting_date=null,form.ending_date=null">x</b-button>
                            </template>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="4" sm="12">
                    <b-form-group :label="__('ending_date','Ending Date')">
                        <b-input-group>
                            <b-input :disabled="!form.starting_date"
                                     :min="form.starting_date"
                                     type="date"
                                     v-model="form.ending_date"/>
                            <template v-slot:append>
                                <b-button @click="form.ending_date=null">x</b-button>
                            </template>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="4" sm="12">
                    <b-form-group :label="__('type','Type')">
                        <b-form-select
                            :required="true"
                            v-model="form.type"
                            @change="report=null"
                            :options="[
                                {text:'Overview',value:'overview'},
                                {text:'List Sales',value:'list_sales'},
                                {text:'List Sale Items',value:'list_sale_items'},
                                {text:'Products',value:'products'},
                                {text:'Customer',value:'customer'},
                            ]"/>
                    </b-form-group>
                </b-col>
            </b-form-row>
        </b-form>
        <h2 class="card-title">
            {{__('daily_sales_report','Daily Sales Report')}}
        </h2>

        <template v-if="isObject(report) && form.type==='overview'">
            <overview :report="report"/>
        </template>
        <template v-else-if="isArray(report) && form.type==='list_sales'">
            <list-sales :report="report"/>
        </template>
        <template v-else-if="isArray(report) && form.type==='list_sale_items'">
            <list-sale-items :report="report"/>
        </template>
        <template v-else-if="isArray(report) && form.type==='products'">
            <list-products :report="report"/>
        </template>
        <template v-else-if="isArray(report) && form.type==='customer'">
            <list-by-customer :report="report"/>
        </template>
    </div>
</template>

<script>
    import dayjs from "dayjs"

    import {obj2Table, startCase, isArray, isObject} from '@/partials/datatable';
    import Overview from "@/components/sales/reports/daily_partials/Overview";
    import ListSales from "@/components/sales/reports/daily_partials/ListSales";
    import ListSaleItems from "@/components/sales/reports/daily_partials/ListSaleItems";
    import ListProducts from "@/components/sales/reports/daily_partials/ListProducts";
    import ListByCustomer from "@/components/sales/reports/daily_partials/ListByCustomer";

    export default {
        name: "Daily",
        components: {
            ListSaleItems,
            ListSales,
            Overview,
            ListProducts,
            ListByCustomer
        },
        data() {
            return {
                form: {
                    date: dayjs().format('YYYY-MM-DD'),
                    type: 'overview'
                },
                report: null
            }
        },
        watch: {
            "form": {
                deep: true,
                handler(value) {
                    this.handleSubmit();
                }
            }
        },
        mounted() {
            this.handleSubmit();
        },
        methods: {
            obj2Table,
            startCase,
            isArray,
            isObject,
            handleSubmit() {
                this.report = null;
                if (this.$refs.the_form.reportValidity()) {
                    axios.post(route('Backend.Sales.Reports').url(), JSON.parse(JSON.stringify(this.form)))
                        .then(res => {
                            this.$set(this, 'report', res.data);
                            console.log(res.data)
                        })
                        .catch(({response}) => {
                            console.log(response);
                            this.$set(this, 'report', null);
                        });
                }
            }
        }
    }
</script>

<style scoped>

</style>
