<template>
    <b-table head-variant="dark"
             foot-variant="light"
             small
             :fields="fields"
             foot-clone
             :items="report">
        <template v-slot:foot(product_id)="row">
            {{countItems('product_id') | localNumber}} {{__('items','Items')}}
        </template>
        <template v-slot:foot(customers)="row">
            {{sum('customers') | localNumber}} {{__('persons','Persons')}}
        </template>
        <template v-slot:foot(sales)="row">
            {{sum('sales') | localNumber}}
        </template>
        <template v-slot:foot(quantity)="row">
            {{sum('quantity') | localNumber}} {{__('items','Items')}}
        </template>
        <template v-slot:foot(total)="row">
            {{sum('total') | currency}}
        </template>
        <template v-slot:foot(tax)="row">
            {{sum('tax') | currency}}
        </template>
        <template v-slot:foot(discount)="row">
            {{sum('discount') | currency}}
        </template>
        <template v-slot:foot(payable)="row">
            {{sum('payable') | currency}}
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
                        key: 'product_id',
                        name: 'sale_items.product_id',
                        sortable: true,
                        label: _t('pid', "PID")
                    },
                    {
                        key: 'name',
                        name: 'products.name',
                        sortable: true,
                        label: _t('name', "Name")
                    },
                    {
                        key: 'customers',
                        sortable: true,
                        label: _t('customers', "Customers")
                    },
                    {
                        key: 'sales',
                        sortable: true,
                        label: _t('sales', "Sales")
                    },
                    {
                        key: 'quantity',
                        sortable: true,
                        label: _t('quantity', "Quantity")
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
                    }
                ]
            }
        }
    }
</script>
