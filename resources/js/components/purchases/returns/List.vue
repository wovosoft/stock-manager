<template>
    <div>
        <dt-table :title="__(title,startCase(title))"
                  v-model="search"
                  enable-date-range
                  :fields="fields"
                  :datatable="datatable"
                  @refreshDatatable="$refs.datatable.refresh()"
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable" v-bind="commonDtOptions()">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'PurchaseReturnsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      @click="setDataForEdit(row.item)">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger"
                                      :title="__('delete','Delete')"
                                      @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                    <template #foot(quantity)="row">
                        {{colSum(datatable.items,'quantity') | localNumber}}
                    </template>
                    <template #foot(amount)="row">
                        {{colSum(datatable.items,'amount') | currency}}
                    </template>
                </b-table>
            </template>
            <template v-slot:header_dropdowns>
                <b-button size="sm" variant="primary" v-b-modal:returns-add>
                    {{__('add', 'Add')}}
                </b-button>
            </template>
        </dt-table>
        <b-modal id="returns-add" hide-footer size="lg" title="Add Return" header-bg-variant="dark"
                 @hidden="form={}"
                 header-text-variant="light">
            <template #default="{hide}">
                <returns-add :item="form" @refresh="$refs.datatable.refresh(),hide()"></returns-add>
            </template>
        </b-modal>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import ReturnsAdd from "./Add"

    export default {
        name: "PurchaseReturnList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            ReturnsAdd
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: ' Returns'
            },
            api_url: {
                type: String,
                default: () => route('Backend.PurchaseReturns.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.PurchaseReturns.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.PurchaseReturns.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        methods: {
            colSum,
            setDataForEdit(item) {
                this.$set(this, 'form', {
                    supplier_id: item.supplier_id,
                    items: [
                        {
                            id: item.id,
                            name: item.product.name,
                            product_id: item.product_id,
                            amount: item.amount,
                            quantity: item.quantity
                        }
                    ]
                });
                this.$bvModal.show('returns-add');
            }
        },
        beforeMount() {
            let date = new Date();
            this.datatable.search_columns.starting_date = [date.getFullYear(), date.getMonth() + 1, date.getDate()].join('-');
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {
                        key: 'supplier_id',
                        sortable: true,
                        label: _t('supplier', 'Supplier'),
                        formatter: (r, x, {supplier}) => [supplier.id, supplier.name, supplier.village].join(' | ')
                    },
                    {
                        key: 'product_id', sortable: true, label: _t('product', 'Product'),
                        formatter: (r, x, {product}) => [product.id, product.name].join(' # ')
                    },
                    {
                        key: 'quantity', sortable: true,
                        label: _t('quantity', 'Quantity'),
                        formatter: v => this.$options.filters.localNumber(v)
                    },
                    {
                        key: 'amount', sortable: true,
                        label: _t('amount', 'Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        sortable: true,
                        visible: false,
                        label: _t('updated_at', 'Updated At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'action',
                        sortable: false,
                        label: _t('action', 'Action'),
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    },
                ]
            }
        }
    }
</script>
