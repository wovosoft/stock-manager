<template>
    <div>
        <b-card bg-variant="dark" text-variant="light" class="mb-3" body-class="text-center">
            <h4>
                {{__('customer_sales_report','Customer Sales Report')}}
            </h4>
            <div>
                {{browse.start_date | localDate}} - {{browse.end_date | localDate}}
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
                    <b-col class="text-center" md="2" sm="12">
                        <b-button size="sm" variant="dark"
                                  @click="setToday">
                            {{__('todays_report',"Today's Report")}}
                        </b-button>
                        <b-button size="sm" variant="dark"
                                  target="_blank"
                                  :href="route('Backend.Reports.Customers.Sales', {start_date: browse.start_date,end_date: browse.end_date,pdf:'pdf'}).url()">
                            {{__('export',"Export")}}
                        </b-button>
                    </b-col>
                    <b-col md="6" sm="12">
                        <div class="float-right">
                            <b-form-row>
                                <b-col md="6" sm="12">
                                    <b-input-group :prepend="__('start','Start')" size="sm">
                                        <b-input v-model="browse.start_date" type="date"/>
                                        <template #append>
                                            <b-button variant="dark" @click="browse.start_date=null">
                                                Reset
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-col>
                                <b-col md="6" sm="12">
                                    <b-input-group :prepend="__('end','End')" size="sm">
                                        <b-input v-model="browse.end_date" type="date"/>
                                        <template #append>
                                            <b-button variant="dark" @click="browse.end_date=null">
                                                Reset
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-col>
                            </b-form-row>
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
                :api-url="route('Backend.Reports.Customers.Sales', {start_date: browse.start_date,end_date: browse.end_date,page:dt.current_page}).url()">
                <template #foot(payable)="row">
                    {{colSum(dt.data,'payable') | currency}}
                </template>
                <template #foot(paid)="row">
                    {{colSum(dt.data,'paid') | currency}}
                </template>
                <template #foot(returned)="row">
                    {{colSum(dt.data,'returned') | currency}}
                </template>
                <template #foot(balance)="row">
                    {{colSum(dt.data,'balance') | currency}}
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
                browse: {
                    start_date: null,
                    end_date: null
                },

                fields: [
                    {
                        key: 'id',
                        label: _t('id', 'ID')
                    },
                    {
                        key: 'name',
                        label: _t('name', 'Name')
                    },
                    {
                        key: 'payable',
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'paid',
                        label: _t('sales.paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'returned',
                        label: _t('returned', 'Returned'),
                        formatter: v => this.$options.filters.currency(v),
                    },
                    {
                        key: 'balance',
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v),
                    }
                ]
            }
        },
        mounted() {
            this.setToday();
        },
        methods: {
            colSum,
            setToday() {
                this.$set(this.browse, 'start_date', dayjs().format('YYYY-MM-DD'));
                this.$set(this.browse, 'end_date', dayjs().format('YYYY-MM-DD'));
            },
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
