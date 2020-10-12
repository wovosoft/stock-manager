<template>
    <div>
        <b-card bg-variant="dark" text-variant="light" class="mb-3" body-class="text-center">
            <h4>
                {{__('daily_customer_sales_report','Daily Customer Sales Report')}}
            </h4>
            <div>
                {{date | localDate}}
            </div>
        </b-card>
        <b-card body-class="p-0">
            <template #header>
                <b-row>
                    <b-col md="4" sm="12">
                        <b-input-group :prepend="__('per_page','Per Page')" size="sm">
                            <b-select
                                v-model="dt.per_page"
                                :options="[10,30,50,100,150,200,300,500,1000]"/>
                        </b-input-group>
                    </b-col>
                    <b-col md="8" sm="12">
                        <div class="float-right">
                            <b-input-group :prepend="__('date','Date')" size="sm">
                                <b-input v-model="date" type="date"/>
                            </b-input-group>
                        </div>
                    </b-col>
                </b-row>
            </template>
            <b-table
                class="mb-0"
                ref="dt_table"
                hover
                small
                striped
                bordered
                :items="getItems"
                :current-page="dt.current_page"
                head-variant="dark"
                :fields="fields"
                :per-page="dt.per_page"
                foot-clone
                foot-variant="light"
                :api-url="route('Backend.Reports.Customers.Sales.Daily', {date: date,page:dt.current_page}).url()">
                <template #foot(sales_amount)="row">
                    {{colSum(dt.data,'sales_amount') | currency}}
                </template>
                <template #foot(paid_amount)="row">
                    {{colSum(dt.data,'paid_amount') | currency}}
                </template>
                <template #foot(balance_amount)="row">
                    {{colSum(dt.data,'balance_amount') | currency}}
                </template>
            </b-table>
            <template #footer>
                <dt-footer :datatable="dt"/>
            </template>
        </b-card>
    </div>
</template>

<script>
    import DtFooter from '@/partials/DtFooter'
    import {colSum, isTrue} from "@/partials/datatable";
    import dt from "@/shared/dt"
    import dayjs from "dayjs"

    export default {
        name: "CustomerSalesReports",
        components: {
            DtFooter,
        },
        data() {
            return {
                dt: {...dt},
                form: {},
                date: dayjs().format("YYYY-MM-DD"),
                fields: [
                    {
                        key: 'customer_id',
                        label: _t('customer_id', 'Customer ID')
                    },
                    {
                        key: 'name',
                        label: _t('name', 'Name')
                    },
                    {
                        key: 'sales_amount',
                        label: _t('sales_amount', 'Sales Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'paid_amount',
                        label: _t('paid_amount', 'Paid Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'balance_amount',
                        label: _t('balance_amount', 'Balance Amount'),
                        formatter: v => this.$options.filters.currency(v),
                    }
                ]
            }
        },
        methods: {
            colSum,
            getItems(ctx) {
                return axios.post(ctx.apiUrl, {
                    per_page: ctx.perPage,
                    orderBy: ctx.sortBy || 'id',
                    order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                }).then(res => {
                    this.$set(this, 'dt', res.data);
                    return res.data.data;
                }).catch(err => {
                    console.log(err.response);
                    this.dt = {...dt};
                    return [];
                });
            }
        }
    }
</script>
