<template>
    <div>
        <b-row>
            <b-col md="6" sm="12">
                <b-card bg-variant="dark" text-variant="light"
                        :header="__('total_number_of_withdrawals','Total Number of Withdrawals')" class="mb-3">
                    <h4>{{ overview.total_no_withdrawals | localNumber}}</h4>
                </b-card>
            </b-col>
            <b-col md="6" sm="12">
                <b-card bg-variant="dark" text-variant="light"
                        :header="__('total_withdrawal_amount','Total Withdrawal Amount')" class="mb-3">
                    <h4>{{overview.total_payment_amount | currency}}</h4>
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
                  :custom_buttons="custom_buttons">
            <template #header_dropdowns>
                <b-button variant="dark" size="sm" v-b-toggle:header-bottom-panel>
                    {{__('more','More')}}
                </b-button>
            </template>
            <template #header_bottom_panel>
                <b-collapse id="header-bottom-panel">
                    <b-row>
                        <b-col md="6" sm="12">
                            <b-input-group :prepend="__('id','ID')" class="mt-3">
                                <b-input type="number"
                                         v-model="datatable.search_columns.id"
                                         :placeholder="__('id','ID')"/>
                            </b-input-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-input-group :prepend="__('payment_method','Payment Method')" class="mt-3">
                                <b-select v-model="datatable.search_columns.payment_method"
                                          :options="payment_options"/>
                            </b-input-group>
                        </b-col>
                    </b-row>
                </b-collapse>
            </template>
            <template #table>
                <b-table ref="datatable"
                         variant="primary"
                         responsive="md"
                         hover
                         bordered
                         small
                         striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                         foot-clone
                         @refreshed="overview=JSON.parse(headers.overview)"
                         foot-variant="secondary">
                    <template v-slot:foot(id)="row">
                        {{colCount(datatable.items,'id') | localNumber}} {{__('items','Items')}}
                    </template>
                    <template v-slot:foot(payment_amount)="row">
                        {{colSum(datatable.items,'payment_amount') | currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'CapitalWithdrawsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'CapitalWithdrawsEdit',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
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
        </dt-table>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colCount, colSum} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import payment_options from '@/shared/payment_options';

    export default {
        name: "CapitalWithdrawsList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('capital_withdraws', 'Capital Withdraws')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Capital.Withdraws.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Capital.Withdraws.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Capital.Withdraws.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'CapitalWithdrawsAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'capital_withdraws'
                            }
                        }
                    }
                ]
            },
        },
        data() {
            return {
                payment_options,
                form: {},
                total_payment_amount: 0,
                total_no_withdrawals: 0,
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {
                        key: 'payment_amount',
                        label: _t('payment_amount', 'Payment Amount'),
                        sortable: true,
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'payment_method',
                        label: _t('payment_method', 'Payment Method'),
                        sortable: true,
                        formatter: v => v ? _t((v || '').toLowerCase(), v) : ''
                    },
                    {key: 'bank', sortable: true, label: _t('bank', 'Bank')},
                    {key: 'check_no', sortable: true, label: _t('check_no', 'Check No.')},
                    {key: 'transaction_no', sortable: true, label: _t('transaction_no', 'Transaction No.'),},
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
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
        },
        methods: {
            colSum,
            colCount
        }
    }
</script>
