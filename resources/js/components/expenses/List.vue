<template>
    <div>
        <b-row class="mb-3">
            <b-col md="6" sm="12">
                <b-card :header="__('total_expense_amount','Total Expense Amount')"
                        bg-variant="dark" text-variant="light">
                    <h4>{{overview.total_expense_amount|currency}}</h4>
                </b-card>
            </b-col>
            <b-col md="6" sm="12">
                <b-card :header="__('total_expense_quantity','Total Expense Quantity')"
                        bg-variant="dark"
                        text-variant="light">
                    <h4>{{overview.total_expense_quantity | localNumber}}</h4>
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  :enable-date-range="true"
                  @refreshDatatable="$refs.datatable.refresh()"
        >
            <template #header_dropdowns>
                <b-button variant="dark" v-b-toggle:advanced_search size="sm" ref="ht">
                    {{__('more','More')}}
                </b-button>
            </template>
            <template #header_bottom_panel>
                <b-collapse id="advanced_search" class="mt-3">
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-input-group :prepend="__('category','Category')">
                                <vue-select
                                    :init-options="true"
                                    :required="true"
                                    @input="v=>$set(datatable.search_columns,'expense_category_id',v?v.id:undefined)"
                                    v-model="datatable.expense_category"
                                    :api_url="route('Backend.Expenses.Categories.Search')">
                                    <template v-slot:option="op">
                                        {{[op.item.id,op.item.name].join(' # ')}}
                                    </template>
                                    <template v-slot:tag="op">
                                        {{op.tag?[op.tag.id,op.tag.name].join(' # '):__('not_selected','Not Selected')}}
                                    </template>
                                </vue-select>
                                <template v-slot:append>
                                    <b-button
                                        @click="datatable.search_columns.expense_category_id=undefined,datatable.expense_category=undefined">
                                        x
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-input-group :prepend="__('reference','Reference')">
                                <b-input
                                    type="search"
                                    :placeholder="__('reference','Reference')"
                                    v-model="datatable.search_columns.reference"/>
                            </b-input-group>
                        </b-col>
                    </b-form-row>
                </b-collapse>
            </template>
            <template v-slot:table>
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
                         foot-variant="secondary"
                         @refreshed="overview=JSON.parse(headers.overview)"
                >
                    <template v-slot:foot(amount)="row">
                        {{colSum(datatable.items,'amount')|currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'ExpensesView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'ExpensesAdd',params:{id:row.item.id}}"
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
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";
    import {colSum} from "@/partials/datatable";
    import VueSelect from "@/partials/VueSelect";

    export default {
        name: "ExpensesList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            VueSelect
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('expenses', 'Expenses')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Expenses.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Expenses.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Expenses.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'ExpensesAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'expenses'
                            }
                        }
                    }
                ]
            },
        },

        data() {
            return {
                form: {},
                total_expense_amount: 0,
                fields: [
                    {
                        key: 'id',
                        name: 'expenses.id',
                        sortable: true, label: _t('id', 'ID')
                    },
                    {
                        key: 'expense_category_name',
                        name: 'expense_categories.name',
                        label: _t('category', 'Category'),
                        sortable: true,
                    },
                    {
                        key: 'amount',
                        sortable: true,
                        label: _t('amount', 'Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'reference', label: _t('reference', 'Reference'), sortable: true},
                    {
                        key: 'taken_by_name',
                        name: 'users.name',
                        sortable: true, label: _t('taken_by', 'Taken By')
                    },
                    {
                        key: 'description',
                        name: 'expenses.description',
                        label: _t('description', 'Description'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        name: 'expenses.created_at',
                        label: _t('created_at', 'Created At'),
                        sortable: true,
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'expenses.updated_at',
                        label: _t('updated_at', 'Updated At'),
                        sortable: true,
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'action',
                        label: _t('action', 'Action'),
                        sortable: false,
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    },
                ]
            }
        },
        methods: {
            colSum
        }
    }
</script>
