<template>
    <div>
        <b-card bg-variant="dark" text-variant="light" class="text-center mb-2">
            <h4>{{__('daily_customer_collection','Daily Customer Collection')}}</h4>
            <div>
                {{date | localDate}}
            </div>
        </b-card>
        <transaction-collection-by-customer :date="date"/>
    </div>
</template>

<script>
    import dayjs from "dayjs";
    import TransactionCollectionByCustomer from "@/components/transactions/TransactionCollectionByCustomer";

    export default {
        name: "List",
        components: {
            TransactionCollectionByCustomer
        },
        data() {
            return {
                date: dayjs().format('YYYY-MM-DD')
            }
        }
    }
</script>

<style scoped>

</style>
