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
                        {{__('capital_balance','Capital Balance')}}
                    </b-button>
                </b-col>
            </b-row>
        </b-card>
        <transaction-add class="mt-3"></transaction-add>
    </div>
</template>

<script>
    import TransactionAdd from "@/components/transactions/Add"

    export default {
        name: "Dashboard",
        components: {
            TransactionAdd
        },
        data() {
            return {
                financial_report: {}
            }
        },
    }
</script>

<style scoped>

</style>
