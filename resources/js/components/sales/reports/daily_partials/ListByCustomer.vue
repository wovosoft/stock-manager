<template>
    <b-table head-variant="dark"
             foot-variant="light"
             small
             :fields="fields"
             foot-clone
             :items="report">
        <template v-slot:foot(customer_id)="row">
            {{countItems('customer_id') | localNumber}} {{__('persons','Persons')}}
        </template>
        <template v-slot:foot(sales_quantity)="row">
            {{sum('sales_quantity') | localNumber}} {{__('items','Items')}}
        </template>
        <template v-slot:foot(sales_total)="row">
            {{sum('sales_total') | currency}}
        </template>
        <template v-slot:foot(sales_tax)="row">
            {{sum('sales_tax') | currency}}
        </template>
        <template v-slot:foot(sales_discount)="row">
            {{sum('sales_discount') | currency}}
        </template>
        <template v-slot:foot(sales_payable)="row">
            {{sum('sales_payable') | currency}}
        </template>
        <template v-slot:foot(sales_paid)="row">
            {{sum('sales_paid') | currency}}
        </template>
        <template v-slot:foot(sales_balance)="row">
            {{sum('sales_balance') | currency}}
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
            countItems(col) {
                let items = [];
                this.report.forEach(r => {
                    if (!items.includes(r[col])) {
                        items.push(r[col]);
                    }
                });
                return items.length;
            }
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
                        key: 'customer_id',
                        name: 'sales.customer_id',
                        sortable: true,
                        label: _t('customer_id', "Customer ID")
                    },
                    {
                        key: 'customer_name',
                        name: 'customers.name',
                        sortable: true,
                        label: _t('customer_name', "Customer Name")
                    },
                    {
                        key: 'sales_quantity',
                        sortable: true,
                        label: _t('sales_quantity', "Sales Quantity"),
                        formatter: v => this.$options.filters.localNumber(v)
                    },
                    {
                        key: 'sales_total',
                        sortable: true,
                        label: _t('total', "Total"),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'sales_tax',
                        sortable: true,
                        label: _t('tax', "Tax"),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'sales_discount',
                        sortable: true,
                        label: _t('discount', "Discount"),
                        formatter: v => this.$options.filters.currency(v)
                    },

                    {
                        key: 'sales_payable', sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'sales_paid', sortable: true,
                        label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'sales_balance', sortable: true,
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    }
                ]
            }
        }
    }
</script>
