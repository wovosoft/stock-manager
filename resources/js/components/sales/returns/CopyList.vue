<template>
    <div>
        <dt-table :title="__(title,startCase(title))"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable" v-bind="commonDtOptions()">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'ReturnsView',params:{id:row.item.id}}"
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
                </b-table>
            </template>
            <template v-slot:header_dropdowns>
                <b-button size="sm" variant="primary" v-b-modal:returns-add>
                    {{_t('add', 'Add')}}
                </b-button>
            </template>
        </dt-table>
        <b-modal id="returns-add" hide-footer size="lg" title="Add Return" header-bg-variant="dark"
                 @hidden="form={}"
                 header-text-variant="light">
            <returns-add :item="form" @refresh="$refs.datatable.refresh()"></returns-add>
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
    import Datatable, {pluck} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import ReturnsAdd from "./Add"

    export default {
        name: "SMSList",
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
                default: () => route('Backend.ReturnedSales.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.ReturnedSales.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.ReturnedSales.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        methods: {
            setDataForEdit(item) {
                let d = {items: []};
                d = Object.assign(d, pluck(JSON.parse(JSON.stringify(item)), ['id', 'customer_id', 'sale_id', 'date', 'returned_amount']));
                item.items.forEach(it => {
                    d.items.push({
                        id: it.id,
                        name: it.product.name,
                        product_id: it.product_id,
                        price: it.price,
                        quantity: it.quantity
                    });
                });
                this.$set(this, 'form', d);
                this.$bvModal.show('returns-add');
            }
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'date', sortable: true, label: _t('date', 'Date')},
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'customer_id', sortable: true, label: _t('customer', 'Customer')},
                    {key: 'sale_id', sortable: true, label: _t('sale_id', 'Sale ID')},
                    {
                        key: 'returned_amount', sortable: true,
                        label: _t('returned_amount', 'Returned Amount'),
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
