<template>
    <div>
        <b-row class="mb-3">
            <b-col md="6" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('sales_quantity','Sales Quantity')">
                    {{overview.sales_quantity | localNumber}}
                </b-card>
            </b-col>
            <b-col md="6" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('sales_payable','Sales Payable')">
                    {{overview.sales_payable | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()">
            <template #header_dropdowns>
                <b-dropdown size="sm"
                            variant="dark"
                            right
                            :text="__('export','Export')">
                    <b-dropdown-item @click="getProductWiseReport">
                        {{__('product_summery','Product Summery')}}
                    </b-dropdown-item>
                </b-dropdown>
                <b-button size="sm" variant="dark"
                          :title="__('refresh','Refresh')"
                          @click="$refs.datatable.refresh()">
                    <i class="fa fa-sync"></i>
                </b-button>
            </template>
            <template v-slot:table>
                <b-table ref="datatable"
                         @refreshed="overview=JSON.parse(headers.overview||'{}')"
                         v-bind="commonDtOptions()"
                         foot-clone
                         foot-variant="light"
                >
                    <template v-slot:foot(customer_name)="row">
                        {{colCount(datatable.items,'customer_name')|localNumber}} {{__('persons','Persons')}}
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
                                      @click="invoice_is_delivery=false,currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-file-invoice"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('delivery_slip','Delivery Slip')"
                                      v-b-modal:invoice-modal
                                      @click="invoice_is_delivery=true,currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-shopping-cart"></i>
                            </b-button>
                            <b-dropdown right size="sm">
                                <b-dropdown-item
                                    :title="__('cash_and_delivery_memo','Cash & Delivery')"
                                    v-b-modal:invoice-modal
                                    @click="invoice_both=true,currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-file-invoice"></i>
                                    {{__('cash_and_delivery_memo','Cash & Delivery')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('returns_history','Returns History')"
                                    v-b-modal:returns-modal
                                    @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-retweet"></i>
                                    {{__('returns_history','Returns History')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('view_sale_history','View Sale\'s Details')"
                                    :to="{name:'SalesView',params:{id:row.item.id}}"
                                    @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                    <i class="fa fa-eye"></i> {{__('view','View')}}
                                </b-dropdown-item>
                                <b-dropdown-item
                                    :title="__('delete_the_sale','Delete the Sale')"
                                    @click="trash(row.item.id)">
                                    <i class="fa fa-trash"></i> {{__('delete','Delete')}}
                                </b-dropdown-item>
                            </b-dropdown>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>

        <b-modal id="invoice-modal"
                 v-bind="{...BasicModalOptions,bodyClass:'p-0'}"
                 :title="__('sale_invoice','Sale Invoice')"
                 v-if="currentItem"
                 @hidden="currentItem={},invoice_is_delivery=false,invoice_both=false">
            <b-embed
                v-if="currentItem && currentItem.id"
                id="print_invoice"
                aspect="16by9"
                allowfullscreen
                :src="route('Backend.Sales.Invoice.PDF',{sale:currentItem.id,type:'html',is_delivery:invoice_is_delivery?'yes':'no',invoice_both:invoice_both?'yes':'no'})"/>
            <template v-slot:modal-footer="{close}">
                <b-button
                    v-if="currentItem && currentItem.id"
                    :href="route('Backend.Sales.Invoice.PDF',{sale:currentItem.id,type:'pdf',is_delivery:invoice_is_delivery?'yes':'no',invoice_both:invoice_both?'yes':'no'})"
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
    import Datatable, {colSum, colCount, BasicModalOptions} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import dayjs from "dayjs";

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
                default: _t('list_of_sales', 'List of Sales')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Sales.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Sales.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Sales.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'SalesAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'sales'
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
            },
            getProductWiseReport() {
                let query = {};
                if (this.datatable.search_columns.starting_date) {
                    query.starting_date = this.datatable.search_columns.starting_date;
                }
                if (this.datatable.search_columns.ending_date) {
                    query.ending_date = this.datatable.search_columns.ending_date;
                }
                if (this.search) {
                    query.search = this.search;
                }
                window.open(route('Backend.SaleItems.Export', query), "_blank");
            }
        },
        mounted() {
            this.datatable.search_columns.starting_date = dayjs().format('YYYY-MM-DD');
        },
        data() {
            return {
                BasicModalOptions,
                invoice_is_delivery: false,
                invoice_both: false,
                invoice_type: 'html',
                form: {},
                fields: [
                    {
                        key: 'id',
                        name: 'sales.id',
                        sortable: true, label: _t('id', 'ID')
                    },
                    {
                        key: 'customer_name',
                        name: 'customers.name',
                        sortable: true,
                        label: _t('customer', "Customer")
                    },
                    {
                        key: 'customer_address',
                        name: 'customers.village',
                        sortable: true,
                        label: _t('address', "Address")
                    },
                    {
                        key: 'total', sortable: true,
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
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
                    // {
                    //     key: 'payable', sortable: true,
                    //     label: _t('sales.payable', 'Payable'),
                    //     formatter: v => this.$options.filters.currency(v || 0)
                    // },
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
                        name: 'sales.created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'sales.updated_at',
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
