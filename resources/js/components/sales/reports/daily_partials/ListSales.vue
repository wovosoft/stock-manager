<template>
    <b-table head-variant="dark"
             foot-variant="light"
             small
             :fields="fields"
             foot-clone
             :items="report">
        <template v-slot:foot(customer_id)="row">
            {{numCustomers | localNumber}} {{__('persons','Persons')}}
        </template>
        <template v-slot:foot(id)="row">
            {{report.length | localNumber}} Sales
        </template>
        <template v-slot:foot(total)="row">
            {{sum('total')|currency}}
        </template>
        <template v-slot:foot(tax)="row">
            {{percentage('tax')|currency}}
        </template>
        <template v-slot:foot(discount)="row">
            {{percentage('discount')|currency}}
        </template>
        <template v-slot:foot(payable)="row">
            {{sum('payable')|currency}}
        </template>
        <template v-slot:foot(paid)="row">
            {{sum('paid')|currency}}
        </template>
        <template v-slot:foot(balance)="row">
            {{sum('balance')|currency}}
        </template>
        <template v-slot:foot(created_at)="row">
            <div v-if="report && report.length">
                {{dayjs(report[0].created_at).to(report[report.length-1].created_at,true)}}
            </div>
        </template>
    </b-table>
</template>

<script>
    import {obj2Table, startCase} from "@/partials/datatable";
    import dayjs from "dayjs"
    import relativeTime from 'dayjs/plugin/relativeTime'

    dayjs.extend(relativeTime)

    export default {
        props: {
            report: {
                default: () => []
            }
        },
        methods: {
            obj2Table,
            startCase,
            dayjs,
            sum(col) {
                let total = 0;
                this.report.forEach(r => total += r[col]);
                return total;
            },
            percentage(col) {
                let total = 0;
                this.report.forEach(r => total = Number(r.total || 0) * Number(r[col] || 0) / 100);
                return total;
            },
        },
        computed: {
            numCustomers() {
                let customers = [];
                this.report.forEach(r => {
                    if (!customers.includes(r.customer_id)) {
                        customers.push(r.customer_id);
                    }
                });
                return customers.length;
            }
        },
        data() {
            return {
                fields: [
                    {
                        key: 'id',
                        name: 'sales.id',
                        sortable: true, label: _t('id', 'ID')
                    },
                    {
                        key: 'customer_id',
                        name: 'sales.customer_id',
                        sortable: true,
                        label: _t('customer_id', "Customer ID")
                    },
                    {
                        key: 'customer_name',
                        name: 'customers.name',
                        sortable: true,
                        label: _t('customer', "Customer")
                    },
                    {
                        key: 'total', sortable: true,
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'tax', sortable: true,
                        label: _t('tax', 'Tax'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'discount', sortable: true,
                        label: _t('discount', 'Discount'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'payable', sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'paid', sortable: true,
                        label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'balance', sortable: true,
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'created_at',
                        name: 'sales.created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.dayjs(v, 'hh:mm:ss A')
                    }
                ]
            }
        }
    }
</script>
