<template>
    <b-table head-variant="dark"
             small
             :items="obj2Table(report)">
        <template v-slot:cell(key)="row">
            {{_t(row.item.key,startCase(row.item.key))}}
        </template>
        <template v-slot:cell(value)="row">
            <template v-if="['sales_payable','sales_paid','sales_balance'].includes(row.item.key)">
                {{row.item.value | currency}}
            </template>
            <template v-else>
                {{row.item.value}}
            </template>
        </template>
    </b-table>
</template>

<script>
    import {obj2Table, startCase} from "@/partials/datatable";

    export default {
        name: "Overview",
        props: {
            report: {
                default: () => {
                }
            }
        },
        methods: {
            obj2Table,
            startCase
        }
    }
</script>
