<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card :header="__('overview','Overview')" body-class="p-2" class="h-100" bg-variant="dark"
                        text-variant="light">
                    <table class="table table-sm table-hover table-borderless table-striped text-white">
                        <tr>
                            <th>{{__('total_deposit','Total Deposit')}}</th>
                            <td>{{overview.total_deposit | currency}}</td>
                        </tr>
                        <tr>
                            <th>{{__('total_withdrawals','Total Withdrawals')}}</th>
                            <td>{{overview.total_withdrawals | currency}}</td>
                        </tr>
                        <tr>
                            <th>{{__('balance','Balance')}}</th>
                            <td>{{overview.balance | currency}}</td>
                        </tr>
                    </table>
                </b-card>
            </b-col>
            <b-col md="8" sm="12">
                <b-card no-body>
                    <Highcharts :options="chartOptions"/>
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  enable-date-range
                  no-search
                  @refreshDatatable="$refs.datatable.refresh()"
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable" variant="primary" responsive="md" hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         sort-by="created_at"
                         sort-desc
                         foot-clone
                         foot-variant="light"
                         @refreshed="()=>{
                             overview=JSON.parse(headers.overview||'{}');
                             chartOptions.series[0].data = [overview.total_deposit];
                             chartOptions.series[1].data = [overview.total_withdrawals];
                             chartOptions.series[2].data = [overview.balance];
                         }"
                         :per-page="datatable.per_page" :current-page="datatable.current_page"
                >
                    <template v-slot:foot(id)="row">
                        {{__('total','Total')}} {{ colCount(datatable.items,'id')|localNumber}}
                    </template>
                    <template v-slot:foot(debit)="row">
                        {{colSum(datatable.items,'debit')|currency}}
                    </template>
                    <template v-slot:foot(credit)="row">
                        {{colSum(datatable.items,'credit')|currency}}
                    </template>
                </b-table>
            </template>
        </dt-table>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, colCount} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import Highcharts from 'highcharts';
    import loadMap from 'highcharts/modules/map.js';
    import {genComponent} from 'vue-highcharts';

    loadMap(Highcharts);
    export default {
        name: "CapitalDepositsList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            Highcharts: genComponent('Highcharts', Highcharts),
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('capital_debit_credit', 'Capital Debit Credit')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Capital.Balance')
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        methods: {
            colSum,
            colCount
        },
        data() {
            return {
                overview: {
                    total_deposit: 0,
                    total_withdrawals: 0,
                    balance: 0
                },
                chartOptions: {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: _t('funding_overview', 'Funding Overview')
                    },
                    subtitle: {
                        text: _t('overview', 'Overview')
                    },
                    xAxis: {
                        title: {
                            text: _t('amount', 'Amount'),
                        },
                        categories: []
                    },
                    yAxis: {
                        title: {
                            text: _t('funds', 'Funds')
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [
                        {
                            name: _t('deposit_amount', 'Deposit Amount'),
                            data: [0]
                        },
                        {
                            name: _t('withdrawal_amount', 'Withdrawal Amount'),
                            data: [0]
                        },
                        {
                            name: _t('balance', 'Balance'),
                            data: [0]
                        }
                    ]
                },
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'debit',
                        label: _t('capital.deposit', 'Debit'),
                        sortable: true,
                        formatter: v => v ? this.$options.filters.currency(v) : ''
                    },
                    {
                        key: 'credit',
                        label: _t('capital.withdraw', 'Credit'),
                        sortable: true,
                        formatter: v => v ? this.$options.filters.currency(v) : ''
                    },
                    {
                        key: 'payment_amount',
                        label: _t('payment_amount', 'Payment Amount'),
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'payment_method', label: _t('payment_method', 'Payment Method'), sortable: true},
                    {key: 'bank', sortable: true, label: _t('bank', 'Bank')},
                    {key: 'check_no', sortable: true, label: _t('check_no', 'Check No.')},
                    {key: 'transaction_no', sortable: true, label: _t('transaction_no', 'Transaction No.'),},
                    {key: 'type', sortable: true, label: _t('type', 'Type'),},

                ]
            }
        },
    }
</script>
