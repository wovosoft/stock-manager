<template>
    <div>
<!--        {{headers.sql}}-->
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
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable" variant="primary" responsive="md" hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         @refreshed="overview=JSON.parse(headers.overview)"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                         foot-clone
                         foot-variant="light"
                >
                    <template v-slot:foot(total_expense_amount)="row">
                        {{colSum(datatable.items,'total_expense_amount') | currency}}
                    </template>
                    <template v-slot:foot(total_expense_quantity)="row">
                        {{colSum(datatable.items,'total_expense_quantity') | localNumber}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="dark"
                                      :title="__('add_expense','Add Expense')"
                                      v-b-modal:addExpenseModal
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-plus"></i>
                            </b-button>
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'ExpenseCategoriesView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'ExpenseCategoriesAdd',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger" :title="__('delete','Delete')" @click="trash(row.item.id)">
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
        <b-modal id="addExpenseModal"
                 hide-footer
                 body-class="p-2"
                 v-if="currentItem && currentItem.id"
                 lazy
                 @hidden="currentItem={}"
                 :title="__('add_expense','Add Expense')"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-expense
                    @created="v=>hide()"
                    @refreshDatatable="()=>$refs.datatable.refresh()"
                    :expense-category-id="currentItem.id"/>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import AddExpense from "@/components/expense_categories/AddExpense";
    import {colSum} from "@/partials/datatable";

    export default {
        name: "ExpenseCategoriesList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            AddExpense
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('expense_categories','Expense Categories')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Expenses.Categories.List')
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Expenses.Categories.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Expenses.Categories.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        title: _t('new_category', 'New Category'),
                        variant: 'dark',
                        to: {name: 'ExpenseCategoriesAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'expense_categories'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            colSum
        },
        data() {
            return {
                form: {},
                fields: [
                    {
                        key: 'id',
                        name: 'expense_categories.id',
                        sortable: true,
                        label: _t('id', 'ID')
                    },
                    {
                        key: 'name',
                        name: 'expense_categories.name',
                        sortable: true,
                        label: _t('name', 'Name')
                    },
                    {
                        key: 'total_expense_quantity',
                        sortable: true,
                        searchable: false,
                        label: _t('total_expense_quantity', 'Total Expenses Quantity'),
                        formatter: v => this.$options.filters.localNumber   (v)
                    },
                    {
                        key: 'total_expense_amount',
                        sortable: true,
                        searchable: false,
                        label: _t('total_expense_amount', 'Total Expenses Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'description',
                        name: 'expense_categories.description',
                        label: _t('description', 'Description'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        name: 'expense_categories.created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'expense_categories.updated_at',
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
