<template>
    <div>
        <b-row>
            <b-col md="3" sm="12">
                <b-card bg-variant="dark" text-variant="light" class="text-center mb-2">
                    <h4>{{__('date','Date')}}</h4>
                    <div>
                        {{date | localDate}}
                    </div>
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card bg-variant="dark" text-variant="light" class="text-center mb-2">
                    <h4>{{__('income','Income')}}</h4>
                    <div>
                        {{colSum(dt.data,'income') | currency}}
                    </div>
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card bg-variant="dark" text-variant="light" class="text-center mb-2">
                    <h4>{{__('reports.expense','Expense')}}</h4>
                    <div>
                        {{colSum(dt.data,'expense') | currency}}
                    </div>
                </b-card>
            </b-col>
            <b-col md="3" sm="12">
                <b-card bg-variant="dark" text-variant="light" class="text-center mb-2">
                    <h4>{{__('balance','Balance')}}</h4>
                    <div>
                        {{(Number(colSum(dt.data,'income') - Number(colSum(dt.data,'expense')))) | currency}}
                    </div>
                </b-card>
            </b-col>
        </b-row>
        <b-card body-class="p-1" header-class="text-center">
            <template #header>
                <b-row>
                    <b-col>
                        <b-input-group prepend="Date" size="sm">
                            <b-input style="max-width: 300px;" type="date" v-model="date"/>
                        </b-input-group>
                    </b-col>
                    <b-col>
                        <b-button size="sm" target="_blank" variant="dark"
                                  :href="route('Backend.Reports.IncomeExpense',{date:date,pdf:'pdf'})">
                            Export
                        </b-button>
                        <b-button size="sm" target="_blank" variant="dark"
                                  :href="route('Backend.Reports.IncomeExpenseGrouped',{date:date,pdf:'pdf'})">
                            Grouped Export
                        </b-button>
                    </b-col>
                    <b-col>
                        <b-input-group prepend="Per Page" size="sm">
                            <b-select @change="$refs.the_dt.refresh()" :options="range()" v-model="dt.per_page"/>
                        </b-input-group>
                    </b-col>
                </b-row>
            </template>
            <b-table
                ref="the_dt"
                hover
                striped
                small
                bordered
                :per-page="dt.per_page"
                :fields="fields"
                head-variant="dark"
                foot-clone
                :api-url="route('Backend.Reports.IncomeExpense',{date:date})"
                :items="getItems">
                <template #cell(sl)="row">
                    {{row.index+1 | localNumber}}
                </template>
                <template #cell(income)="row">
                    {{row.item.income?$options.filters.currency(row.item.income ) :''}}
                </template>

                <template #cell(expense)="row">
                    {{row.item.expense?$options.filters.currency(row.item.expense ) :''}}
                </template>
                <template #cell(date)="row">
                    {{row.item.date | localTime}}
                </template>
                <template #foot(income)="row">
                    {{colSum(dt.data,'income') | currency}}
                </template>
                <template #foot(expense)="row">
                    {{colSum(dt.data,'expense') |currency}}
                </template>
            </b-table>
            <template #footer>
                <dt-footer :datatable="dt"></dt-footer>
            </template>
        </b-card>
    </div>
</template>

<script>
    import dayjs from "dayjs";
    import {isTrue, startCase, colSum, range} from "@/partials/datatable";
    import dt from "@/shared/dt";
    import DtFooter from "@/partials/DtFooter";

    export default {
        name: "List",
        components: {DtFooter},
        data() {
            return {
                dt: {...dt},
                date: dayjs().format('YYYY-MM-DD'),
                fields: [
                    {key: 'sl', label: _t('sl', 'SL')},
                    {
                        key: 'title', label: _t('title', 'Title'),
                        formatter: v => _t(v, startCase(v))
                    },
                    {key: 'description', label: _t('description', 'Description')},
                    {key: 'income', label: _t('income', 'Income')},
                    {key: 'expense', label: _t('reports.expense', 'Expense')},
                    {key: 'date', label: _t('time', 'Time')}
                ]
            }
        },
        methods: {
            startCase,
            range,
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

<style scoped>

</style>
