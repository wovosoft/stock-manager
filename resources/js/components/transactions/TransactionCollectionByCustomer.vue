<template>
    <div>
        <b-card body-class="p-0">
            <b-table
                class="mb-0"
                ref="transactionCollectionsByCustomer"
                head-variant="dark"
                small
                bordered
                striped
                foot-clone
                foot-variant="light"
                :fields="customer_collection_fields"
                :items="transactionCollectionsByCustomer">
                <template #cell(total_amount)="row">
                    {{ row.item.total_amount | currency }}
                </template>
                <template #foot(id)="row"> &nbsp;</template>
                <template #foot(name)="row">
                    {{ __("total", "Total") }}
                </template>
                <template #foot(total_amount)="row">
                    {{ colSum(customer_collections.data, "total_amount") | currency }}
                </template>
            </b-table>
            <template #footer>
                <dt-footer :datatable="customer_collections"/>
            </template>
        </b-card>
    </div>
</template>

<script>
    import DtFooter from "@/partials/DtFooter";
    import {colCount, colSum} from "@/partials/datatable";

    export default {
        name: "TransactionCollectionByCustomer",
        props: {
            date: String,
            required: true
        },
        components: {
            DtFooter
        },
        watch: {
            "date": {
                handler() {
                    this.$refs.transactionCollectionsByCustomer.refresh();
                }
            }
        },
        data() {
            return {
                customer_collections: {
                    data: [],
                },
                customer_collection_fields: [
                    {key: "id", label: _t("id", "ID")},
                    {key: "name", label: _t("customer", "Customer")},
                    {key: "total_amount", label: _t("amount", "Amount")},
                ],
            }
        },
        methods: {
            colCount, colSum,
            transactionCollectionsByCustomer() {
                return axios
                    .post(route("Backend.Transactions.Collections.By.Customers", {page: 1,}).url(), {
                        date: this.date,
                    }).then((res) => {
                        this.$set(this, "customer_collections", res.data);
                        return res.data.data;
                    }).catch((err) => {
                        this.$set(this, "customer_collections", {data: []});
                        console.log(err.response);
                        return [];
                    });
            },
        }
    }
</script>

<style scoped>

</style>
