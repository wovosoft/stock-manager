<template>
    <div>
        <b-card bg-variant="dark" text-variant="light" class="mb-3" body-class="text-center">
            <h4>
                {{__('daily_product_report','Daily Product Report')}}
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
                :api-url="route('Backend.Reports.Products.Daily', { date,page: dt.current_page}).url()"
                :current-page="dt.current_page"
                head-variant="dark"
                :fields="fields"
                :per-page="dt.per_page"
                foot-clone
                foot-variant="light"
                :items="getItems">
                <template #foot(id)="row">
                    {{colCount(dt.data,'id')|localNumber}}
                </template>
                <template #foot(sales_payable)="row">
                    {{colSum(dt.data,'sales_payable')|currency}}
                </template>
                <template #foot(sales_quantity)="row">
                    {{colSum(dt.data,'sales_quantity')|localNumber}}
                </template>
                <template #foot(quantity)="row">
                    {{colSum(dt.data,'quantity')|localNumber}}
                </template>
            </b-table>
            <template #footer>
                <dt-footer :datatable="dt"/>
            </template>
        </b-card>
    </div>
</template>

<script>

    import dayjs from "dayjs";
    import dt from "@/shared/dt";
    import DtFooter from "@/partials/DtFooter";
    import {isTrue, colSum, colCount} from "@/partials/datatable";

    export default {
        name: "ProductReports",
        components: {
            DtFooter
        },
        props: {
            title: {
                type: String,
                default: _t('product_report', 'Product Report')
            },
        },

        methods: {
            colSum, colCount,
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
        },
        data() {
            return {
                dt: {...dt},
                form: {},
                date: dayjs().format('YYYY-MM-DD'),
                fields: [
                    {key: 'id', label: _t('id', 'ID')},
                    {key: 'name', label: _t('name', 'Name')},
                    {
                        key: 'code', label: _t('code', 'Code')
                    },
                    {
                        key: 'sales_payable', label: _t('sales_payable', 'Sales Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'previous_quantity', label: _t('previous_day_quantity', 'Previous Day Quantity'),
                        formatter: (v, r, row) => {
                            return this.$options.filters.localNumber(v) + ' ' + (row.unit ? row.unit.name : '');
                        }
                    },
                    {
                        key: 'sales_quantity', label: _t('sales_quantity', 'Sales Quantity'),
                        formatter: (v, r, row) => {
                            return this.$options.filters.localNumber(v) + ' ' + (row.unit ? row.unit.name : '');
                        }
                    },

                    {
                        key: 'quantity', label: _t('available', 'Available'),
                        formatter: (v, r, row) => {
                            return this.$options.filters.localNumber(v) + ' ' + (row.unit ? row.unit.name : '');
                        }
                    },
                ]
            }
        }
    }
</script>
