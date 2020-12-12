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
                    <b-col md="3" sm="12">
                        <b-input-group :prepend="__('per_page','Per Page')" size="sm">
                            <b-select
                                v-model="dt.per_page"
                                :options="[10,30,50,100,150,200,300,500,1000]"/>
                        </b-input-group>
                    </b-col>
                    <b-col md="9" sm="12" class="text-right">
                        <b-button variant="dark" size="sm" class="mr-3"
                                  target="_blank"
                                  :href="route('Backend.Reports.Products.Daily', { date:date,export:'pdf'})"
                                  :title="__('export_report','Export Report')">
                            {{__('export_report',"Export Report")}}
                        </b-button>
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
                :api-url="route('Backend.Reports.Products.Daily', { date,page: dt.current_page})"
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
                <template #foot(current_stock)="row">
                    {{colSum(dt.data,'current_stock')|localNumber}}
                </template>
                <template #foot(addition)="row">
                    {{colSum(dt.data,'addition')|localNumber}}
                </template>
                <template #foot(subtraction)="row">
                    {{colSum(dt.data,'subtraction')|localNumber}}
                </template>
                <template #foot(remains)="row">
                    {{colSum(dt.data,'remains')|localNumber}}
                </template>
                <template #foot(stock)="row">
                    {{colSum(dt.data,'stock')|localNumber}}
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
                    console.log(res.data)
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
                    {key: 'id', label: _t('id', 'ID'), sortable: true},
                    {key: 'name', label: _t('name', 'Name'), sortable: true},
                    {
                        key: 'code', label: _t('code', 'Code'), sortable: true
                    },
                    {
                        key: 'current_stock',
                        label: _t('reports.current_stock', 'Current Stock'),
                        sortable: true,
                        formatter: (v, i, r) => {
                            // let vv = ((r.prev_purchased_items - r.prev_purchase_returned_items) - (r.prev_sold_items - r.prev_sold_returned_items));
                            // return this.$options.filters.localNumber(vv || 0)
                            return this.$options.filters.localNumber(r.current_stock || 0)
                        }
                    },
                    {
                        key: 'addition',
                        label: _t('reports.addition', 'Addition'),
                        sortable: true,
                        formatter: (v, i, r) => {
                            // let vv = (r.purchased_items - r.purchase_returned_items);
                            return this.$options.filters.localNumber(r.addition || 0)
                        }
                    },
                    {
                        key: 'subtraction',
                        label: _t('reports.subtraction', 'Subtraction'),
                        sortable: true,
                        formatter: (v, i, r) => {
                            // let vv = (r.sold_items - r.sold_returned_items);
                            return this.$options.filters.localNumber(r.subtraction || 0)
                        }
                    },
                    {
                        key: 'remains',
                        label: _t('reports.remains', 'Remains'),
                        sortable: true,
                        formatter: (v, i, r) => {
                            // let vv = ((r.purchased_items - r.purchase_returned_items) - (r.sold_items - r.sold_returned_items));
                            return this.$options.filters.localNumber(r.remains || 0)
                        }
                    },
                    {
                        key: 'stock',
                        label: _t('reports.stock', 'Stock'),
                        sortable: true,
                        formatter: (v, i, r) => {
                            // let previous_stock = ((r.prev_purchased_items - r.prev_purchase_returned_items) - (r.prev_sold_items - r.prev_sold_returned_items));
                            // let todays_stock = ((r.purchased_items - r.purchase_returned_items) - (r.sold_items - r.sold_returned_items));
                            return this.$options.filters.localNumber(r.stock || 0)
                        }
                    },

                ]
            }
        }
    }
</script>
