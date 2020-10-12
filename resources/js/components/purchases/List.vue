<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_payable','purchases Payable')">
                    <h4>{{headers.payable | currency}}</h4>
                    {{__('total','Total')}}: {{overview.purchases_payable | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_paid','purchases Paid')">
                    <h4>{{headers.paid |currency}}</h4>
                    {{__('total','Total')}}: {{overview.purchases_paid | currency}}
                </b-card>
            </b-col>

            <b-col md="4" sm="12">
                <b-card bg-variant="dark" text-variant="light" :title="__('purchases_balance','purchases Balance')">
                    <h4>{{(headers.payable-headers.paid) | currency}}</h4>
                    {{__('total','Total')}}:{{overview.purchases_balance | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable"
                         variant="primary"
                         responsive="md"
                         hover bordered small striped
                         head-variant="dark"
                         @refreshed="overview=JSON.parse(headers.overview)"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="dark"
                                      :title="__('take_payment','Take Payment')"
                                      v-b-modal:add-payment
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-money-bill"></i>
                            </b-button>
                            <b-button variant="secondary"
                                      :title="__('payment_history','Payment History')"
                                      v-b-modal:payment-history
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-money-bill-wave"></i>
                            </b-button>
                            <b-button variant="primary"
                                      :title="__('view_purchase_history','View Purchase\'s Details')"
                                      :to="{name:'PurchasesView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <!--                            <b-button variant="warning"-->
                            <!--                                      :title="__('edit_the_purchase','Edit the Purchase')"-->
                            <!--                                      :to="{name:'PurchasesEdit',params:{id:row.item.id}}"-->
                            <!--                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">-->
                            <!--                                <i class="fa fa-edit"></i>-->
                            <!--                            </b-button>-->
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
        <b-modal id="add-payment"
                 :title="__('take_payment','Take Payment')"
                 v-if="currentItem"
                 hide-footer
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-payment
                    @msgBox="v=>msgBox(v)"
                    @success="v=>{if(v) {hide();$refs.datatable.refresh();}}"
                    :purchase="currentItem"/>
            </template>
        </b-modal>
        <b-modal id="payment-history"
                 size="xl"
                 body-class="p-1"
                 :title="__('payment_history','Payment History')"
                 v-if="currentItem"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <payments-history :purchase="currentItem"/>
            </template>
        </b-modal>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";
    import AddPayment from "@/components/purchases/AddPayment";
    import Payments from "@/components/purchases/Payments";

    export default {
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            AddPayment,
            PaymentsHistory: Payments
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('list_of_purchases', 'List of Purchases')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Purchases.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Purchases.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Purchases.Store').url()
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
                                model: 'Purchases'
                            }
                        }
                    }
                ]
            },
        },
        data() {
            return {
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
                        label: _t('supplier', 'Supplier')
                    },
                    {
                        key: 'total', sortable: true,
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'tax', sortable: true,
                        label: _t('tax', 'Tax'),
                        formatter: v => (v || 0) + "%"
                    },
                    {
                        key: 'discount', sortable: true,
                        label: _t('discount', 'Discount'),
                        formatter: v => (v || 0) + "%"
                    },
                    {
                        key: 'payable', sortable: true,
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'paid', sortable: true,
                        label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {
                        key: 'balance', sortable: true,
                        label: _t('balance', 'Balance'),
                        formatter: v => this.$options.filters.currency(v || 0)
                    },
                    {key: 'date', sortable: true, label: _t('date', 'Date'),},
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
                        formatter: v => this.dayjs(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'purchases.updated_at',
                        sortable: true,
                        label: _t('updated_at', 'Updated At'),
                        formatter: v => this.dayjs(v)
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
