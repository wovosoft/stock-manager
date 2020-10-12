<template>
    <div>
        <b-card header-class="p-1" class="text-center">
            <b-row>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'SalesAdd'}" class="mb-3">
                        {{__('new_sale','New Sale')}}
                    </b-button>
                </b-col>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'PurchasesAdd'}" class="mb-3">
                        {{__('new_purchase','New Purchase')}}
                    </b-button>
                </b-col>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'ContactCustomers'}" class="mb-3">
                        {{__('customers','List Customers')}}
                    </b-button>
                </b-col>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'ContactSuppliers'}" class="mb-3">
                        {{__('suppliers','List Suppliers')}}
                    </b-button>
                </b-col>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'ProductList'}" class="mb-3">
                        {{__('products','List Products')}}
                    </b-button>
                </b-col>
                <b-col md="2" sm="12">
                    <b-button size="lg" block variant="dark" :to="{name:'CapitalBalance'}" class="mb-3">
                        {{__('balance','Balance')}}
                    </b-button>
                </b-col>
            </b-row>
        </b-card>
        <b-card :header="__('total_financial_report','Total Financial Report')"
                header-class="text-center h3"
                class="mt-3" body-class="p-1">
            <table class="table table-bordered table-hover table-sm">
                <thead class="bg-dark text-white text-center">
                <tr>
                    <th>{{__('funding_source','Funding Source')}}</th>
                    <th>{{__('amount','Amount')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {{__('capital_deposited','Capital Deposited')}}
                    </td>
                    <td>
                        {{financial_report.capital_deposited | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('capital_withdrawn','Capital Withdrawn')}}
                    </td>
                    <td>
                        {{financial_report.capital_withdrawn | currency}}
                    </td>
                </tr>
                <tr class="bg-dark text-white">
                    <td>
                        {{__('capital_balance','Capital Balance')}}
                    </td>
                    <td>
                        {{financial_report.capital_balance | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('customer_funds_deposits','Customer Funds Deposits')}}
                    </td>
                    <td>
                        {{financial_report.customer_funds_deposits | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('customer_funds_withdrawn','Customer Funds Withdrawn')}}
                    </td>
                    <td>
                        {{financial_report.customer_funds_withdrawn | currency}}
                    </td>
                </tr>
                <tr class="bg-dark text-white">
                    <td>
                        {{__('customer_funds_balance','Customer Funds Balance')}}
                    </td>
                    <td>
                        {{financial_report.customer_funds_balance | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('supplier_funds_deposit','Supplier Funds Deposit')}}
                    </td>
                    <td>
                        {{financial_report.supplier_funds_deposit | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('supplier_funds_withdrawn','Supplier Funds Withdrawn')}}
                    </td>
                    <td>
                        {{financial_report.supplier_funds_withdrawn | currency}}
                    </td>
                </tr>
                <tr class="bg-dark text-white">
                    <td>
                        {{__('supplier_funds_balance','Supplier Funds Balance')}}
                    </td>
                    <td>
                        {{financial_report.supplier_funds_balance | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('employee_salaries','Employee Salaries')}}
                    </td>
                    <td>
                        {{financial_report.employee_salaries | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('expenses_amount','Expense Amount')}}
                    </td>
                    <td>
                        {{financial_report.expenses_amount | currency}}
                    </td>
                </tr>
                <tr class="bg-info">
                    <td>
                        {{__('purchases_payable','Purchases Payable')}}
                    </td>
                    <td>
                        {{financial_report.purchases_payable | currency}}
                    </td>
                </tr>
                <tr class="bg-info">
                    <td>
                        {{__('purchases_paid','Purchases Paid')}}
                    </td>
                    <td>
                        {{financial_report.purchases_paid | currency}}
                    </td>
                </tr>
                <tr class="bg-info text-danger">
                    <td>
                        {{__('purchases_due','Purchases Due')}}
                    </td>
                    <td>
                        {{financial_report.purchases_due | currency}}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{__('sales_payable','Sales Payable')}}
                    </td>
                    <td>
                        {{financial_report.sales_payable | currency}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('sales_paid','Sales Paid')}}
                    </td>
                    <td>
                        {{financial_report.sales_paid | currency}}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{__('sales_due','Sales Due')}}
                    </td>
                    <td>
                        {{financial_report.sales_due | currency}}
                    </td>
                </tr>
                <tr class="bg-dark text-white">
                    <td>
                        {{__('cash_available','Cash Available')}}
                    </td>
                    <td>
                        {{financial_report.cash_available | currency}}
                    </td>
                </tr>
                </tbody>
            </table>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",

        data() {
            return {
                financial_report: {}
            }
        },
        mounted() {
            this.getFinancialSummery();
        },
        methods: {
            getFinancialSummery() {
                axios
                    .post(route('Backend.Capital.FullFinancialSummery').url())
                    .then(res => {
                        console.log(res.data);
                        this.financial_report = res.data;
                    })
                    .catch(err => {
                        console.log(err.response);
                        this.financial_report = {};
                    });
            }
        }
    }
</script>

<style scoped>

</style>
