<template>
    <div>
        <b-row>
            <b-col md="8" sm="12">
                <h4>Party Ledger</h4>
            </b-col>
            <b-col md="4" sm="12">
                <b-input type="date" v-model="date"/>
            </b-col>
        </b-row>
        <b-form-row class="mt-3">
            <b-col md="6" sm="12">
                <b-card
                    class="h-100"
                    header-bg-variant="dark"
                    header-text-variant="light"
                    header-class="text-center"
                    body-class="p-0"
                    :header="__('all_outgoing_ledger', 'All Outgoing Ledger')"
                >
                    <b-tabs card>
                        <b-tab :title="__('expenses', 'Expenses')" class="p-2" lazy>
                            <expenses :date="date"/>
                        </b-tab>
                        <b-tab :title="__('exmployee_salaries', 'Employee Salaries')" class="p-2" lazy>
                            <employee-salaries :date="date"/>
                        </b-tab>
                        <b-tab :title="__('supplier_payments', 'Supplier Payments')">
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-col>
            <b-col md="6" sm="12">
                <b-card
                    class="h-100"
                    body-class="p-0"
                    header-bg-variant="dark"
                    header-text-variant="light"
                    :header="__('customer_ledger', 'Customer Ledger')"
                >
                    <b-tabs card>
                        <b-tab lazy :title="__('todays_collection', 'Today\'s Collection')" class="p-0">
                            <transaction-collection-by-customer :date="date"/>
                        </b-tab>
                        <b-tab lazy :title="__('due_sales', 'Due Sales')" class="p-0">
                            <due-sales :date="date"></due-sales>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-col>
        </b-form-row>

    </div>
</template>
<script>
    import dayjs from "dayjs";
    import Expenses from "@/components/transactions/Expenses";
    import TransactionCollectionByCustomer from "@/components/transactions/TransactionCollectionByCustomer";
    import DueSales from "@/components/transactions/DueSales";
    import EmployeeSalaries from "@/components/transactions/EmployeeSalaries";

    export default {
        components: {
            Expenses,
            TransactionCollectionByCustomer,
            DueSales,
            EmployeeSalaries
        },
        data() {
            return {
                date: dayjs(new Date()).format("YYYY-MM-DD"),
                currentItem: null,
            };
        },
        methods: {},
    };
</script>

<style scoped>
</style>
