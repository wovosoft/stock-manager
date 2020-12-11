<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_quantity','Purchases Quantity')">
                    {{overview.purchases_quantity | localNumber}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_total','Purchases Total')">
                    {{overview.purchases_payable | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_returned','Purchases Returned')">
                    {{overview.purchases_returned | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title" v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
        >
            <template v-slot:table>
                <b-table ref="datatable" variant="primary" responsive="md" hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         @refreshed="overview=JSON.parse(headers.overview||'{}')"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                         foot-clone
                         foot-variant="light"
                >
                    <template v-slot:foot(supplier_name)="row">
                        {{colCount(datatable.items,'supplier_name')|localNumber}} {{__('persons','Persons')}}
                    </template>

                    <template v-slot:foot(total)="row">
                        {{colSum(datatable.items,'total')|currency}}
                    </template>
                    <template v-slot:foot(discount)="row">
                        {{colSum(datatable.items,'discount')|localNumber}}%
                    </template>
                    <template v-slot:foot(tax)="row">
                        {{colSum(datatable.items,'tax')|localNumber}}%
                    </template>
                    <template v-slot:foot(payable)="row">
                        {{colSum(datatable.items,'payable')|currency}}
                    </template>
                    <template v-slot:foot(previous_balance)="row">
                        {{colSum(datatable.items,'previous_balance')|currency}}
                    </template>
                    <template v-slot:foot(current_balance)="row">
                        {{colSum(datatable.items,'current_balance')|currency}}
                    </template>
                    <template v-slot:foot(returned)="row">
                        {{colSum(datatable.items,'returned')|currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="dark"
                                      :title="__('view_invoice','View Invoice')"
                                      v-b-modal:invoice-modal
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-file-invoice"></i>
                            </b-button>
                            <b-button variant="primary"
                                      :title="__('view_purchase_history','View Purchase\'s Details')"
                                      :to="{name:'PurchasesView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="danger"
                                      :title="__('delete_the_purchase','Delete the Purchase')"
                                      @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>

        <b-modal id="invoice-modal"
                 size="xl"
                 footer-class="text-right"
                 body-class="p-0"
                 :title="__('purchase_invoice','Purchase Invoice')"
                 v-if="currentItem"
                 @hidden="currentItem=null"
                 header-bg-variant="dark"
                 header-text-variant="light"
                 footer-bg-variant="dark"
                 footer-text-variant="light">
            <b-embed
                v-if="currentItem && currentItem.id"
                id="print_invoice"
                aspect="16by9"
                allowfullscreen
                :src="route('Backend.Purchases.Invoice.PDF',{purchase:currentItem.id,type:'html'})"/>
            <template v-slot:modal-footer="{close}">
                <b-button
                    v-if="currentItem && currentItem.id"
                    :href="route('Backend.Purchases.Invoice.PDF',{purchase:currentItem.id,type:'pdf'})"
                    target="_blank"
                    variant="dark">
                    <i class="fa fa-file-pdf"></i>
                    {{__('pdf','PDF')}}
                </b-button>
                <b-button @click="printInvoice" variant="primary">
                    <i class="fa fa-print"></i>
                    {{__('print','Print')}}
                </b-button>
                <b-button @click="close" variant="secondary">Close</b-button>
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
    import Datatable, {colSum, colCount} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";

    export default {
        components: {
            DtHeader,
            DtFooter,
            DtTable
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('purchase_list', 'List of Purchases')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Purchases.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Purchases.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Purchases.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'PurchasesAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'purchases'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            colSum,
            colCount,
            printInvoice() {
                let el = document.getElementById('print_invoice').contentWindow;
                el.focus();
                el.print();
            }
        },
        data() {
            return {
                invoice_type: 'html',
                form: {},
                fields: [
                    {
                        key: 'id',
                        name: 'purchases.id',
                        sortable: true, label: _t('id', 'ID')
                    },
                    {
                        key: 'supplier_name',
                        name: 'suppliers.name',
                        sortable: true,
                        label: _t('supplier', "Supplier")
                    },
                    // {
                    //     key: 'total', sortable: true,
                    //     label: _t('total', 'Total'),
                    //     formatter: v => this.$options.filters.currency(v || 0)
                    // },
                    // {
                    //     key: 'tax', sortable: true,
                    //     label: _t('tax', 'Tax'),
                    //     formatter: v => this.$options.filters.localNumber(v || 0) + "%"
                    // },
                    // {
                    //     key: 'discount', sortable: true,
                    //     label: _t('discount', 'Discount'),
                    //     formatter: v => this.$options.filters.localNumber(v || 0) + "%"
                    // },
                    {
                        key: 'payable', sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'previous_balance', sortable: true,
                        label: _t('previous_balance', 'Previous Balance'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'current_balance', sortable: true,
                        label: _t('current_balance', 'Current Balance'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'returned', sortable: true,
                        label: _t('returned', 'Returned'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'date',
                        sortable: true, label: _t('date', 'Date'),
                        formatter: v => (new Date(v)).toLocaleDateString(_s('locale'))
                    },
                    {key: 'status', sortable: true, label: _t('status', 'Status'),},
                    {
                        key: 'note',
                        sortable: true,
                        visible: false,
                        label: _t('note', 'Note'),
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        name: 'purchases.created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'purchases.updated_at',
                        sortable: true,
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
