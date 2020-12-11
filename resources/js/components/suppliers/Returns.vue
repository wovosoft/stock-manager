<template>
    <dt-table
        :title="title"
        v-model="search"
        :fields="fields"
        :datatable="datatable"
        v-if="api_url"
        :custom_buttons="custom_buttons">
        <template v-slot:table>
            <b-table ref="datatable" v-bind="commonDtOptions(the)">
                <template v-slot:foot(amount)="row">
                    {{colSum(datatable.items,'amount') | currency}}
                </template>
                <template v-slot:foot(quantity)="row">
                    {{colSum(datatable.items,'quantity') | localNumber}}
                </template>
            </b-table>
        </template>
    </dt-table>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, commonDtOptions} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";


    export default {
        name: "SupplierPurchaseReturnList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('returns_history', 'Returns History')
            },
            supplierId: {
                type: Number,
                required: true
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        methods: {
            colSum, commonDtOptions
        },
        mounted() {
            this.api_url = route('Backend.Suppliers.Returns', {supplier: this.supplierId});
        },
        data() {
            return {
                the: this,
                api_url: null,
                fields: [
                    {key: 'id', label: _t('id', 'ID'), name: 'purchase_returns.id', sortable: true},
                    {
                        key: 'product_id',
                        label: _t('product_id', 'Product ID'),
                        name: 'purchase_returns.product_id',
                        sortable: true
                    },
                    {
                        key: 'supplier_name',
                        label: _t('supplier', 'supplier'),
                        name: 'suppliers.name',
                        sortable: true
                    },
                    {
                        key: 'product_name',
                        label: _t('product_name', 'Product'),
                        name: 'products.name',
                        sortable: true
                    },
                    {
                        key: 'quantity',
                        label: _t('quantity', 'Quantity'),
                        name: 'purchase_returns.quantity',
                        sortable: true,
                        formatter: v => this.$options.filters.localNumber(v)
                    },
                    {
                        key: 'amount',
                        label: _t('total', 'Total'),
                        name: 'purchase_returns.amount',
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },

                    {
                        key: 'created_at',
                        label: _t('date', 'Date'),
                        name: 'purchase_returns.created_at',
                        formatter: v => this.$options.filters.localDateTime(v),
                        sortable: true
                    },
                ]
            }
        }
    }
</script>

