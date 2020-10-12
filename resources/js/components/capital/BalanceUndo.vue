<template>
    <div>
        <b-row>
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
            <b-col>
                <b-card no-body>
                    <Highcharts :options="chartOptions"/>
                </b-card>
            </b-col>
        </b-row>
    </div>

</template>

<script>
    import Highcharts from 'highcharts';
    import loadMap from 'highcharts/modules/map.js';
    import {genComponent} from 'vue-highcharts';

    loadMap(Highcharts);
    export default {
        components: {
            Highcharts: genComponent('Highcharts', Highcharts),
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
                        // series: {
                        //     dataLabels: {
                        //         enabled: true,
                        //         color: '#000',
                        //         style: {fontWeight: 'bolder'},
                        //         formatter: function () {
                        //             return this.x + ': ' + this.y
                        //         },
                        //         inside: true,
                        //         rotation: 270
                        //     },
                        //     pointPadding: 0.1,
                        //     groupPadding: 0
                        // },
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
                }
            }
        },
        mounted() {
            this.getOverview();
        },
        methods: {
            getOverview() {
                axios
                    .post(route("Backend.Capital.Balance").url())
                    .then(res => {
                        this.$set(this, 'overview', res.data);
                        this.chartOptions.series[0].data = [res.data.total_deposit];
                        this.chartOptions.series[1].data = [res.data.total_withdrawals];
                        this.chartOptions.series[2].data = [res.data.balance];
                    })
                    .catch(err => {
                        console.log(err.response);
                        this.$set(this, 'overview', {
                            total_deposit: 0,
                            total_withdrawals: 0,
                            balance: 0
                        });
                        this.chartOptions.series[0].data = [0];
                        this.chartOptions.series[1].data = [0];
                        this.chartOptions.series[2].data = [0];
                    });
            }
        }
    }
</script>

<style lang="scss">

</style>
