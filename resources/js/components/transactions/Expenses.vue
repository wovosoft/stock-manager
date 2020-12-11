<template>
    <div>
        <b-row class="my-2">
            <b-col>
                <b-input-group size="sm" :prepend="__('per_page','Per Page')">
                    <b-select
                        v-model="expenses.per_page"
                        :options="[5,10,20,30,50,80,100,150,500]"/>
                </b-input-group>
            </b-col>
            <b-col class="text-right">
                <b-button size="sm" variant="dark"
                          @click="expenses_add_visible=true">
                    <i class="fa fa-plus"></i>
                    {{ __("add", "Add") }}
                </b-button>
            </b-col>
        </b-row>
        <b-table
            ref="todayExpensesList"
            :fields="expenses_fields"
            small
            bordered
            hover
            striped
            head-variant="dark"
            foot-clone
            foot-variant="light"
            :sort-desc.sync="expenses.sortDesc"
            :sort-by.sync="expenses.sortBy"
            :per-page="expenses.per_page"
            :current-page="expenses.current_page"
            :items="getTodaysExpenses">
            <template #foot(expense_category_name)="row">
                {{ colCount(expenses.data,'expense_category_name') | localNumber}}
            </template>
            <template #foot(amount)="row">
                {{colSum(expenses.data,'amount') | currency}}
            </template>
        </b-table>

        <dt-footer :datatable="expenses"></dt-footer>
        <expenses-add
            @reset="()=>{
                expenses_add_visible=false;
                $refs.todayExpensesList.refresh();
            }"
            size="md"
            :router-back-on-close="false"
            :is-visible="expenses_add_visible"></expenses-add>
    </div>
</template>

<script>
    import {isTrue} from "@/partials/datatable";
    import DtFooter from "@/partials/DtFooter";
    import ExpensesAdd from "@/components/expenses/Add";
    import {startCase, colSum, colCount, msgBox} from "@/partials/datatable";

    export default {
        name: "Expenses",
        components: {
            DtFooter,
            ExpensesAdd
        },
        props: {
            date: {
                type: String,
                required: true
            }
        },
        watch: {
            "date": {
                handler() {
                    this.$refs.todayExpensesList.refresh();
                }
            }
        },
        data() {
            return {
                expenses_add_visible: false,
                expenses: {
                    sortBy: 'id',
                    sortDesc: true,
                    per_page: 30,
                    current_page: 1,
                    total: 0,
                    from: 0,
                    to: 0,
                    data: []
                },
                expenses_fields: [
                    {
                        key: "id",
                        name: "expenses.id",
                        sortable: true,
                        label: _t("id", "ID"),
                    },
                    {
                        key: "expense_category_name",
                        name: "expense_categories.name",
                        label: _t("category", "Category"),
                        sortable: true,
                    },
                    {
                        key: "amount",
                        sortable: true,
                        label: _t("transaction.expense", "Amount"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "reference",
                        label: _t("reference", "Reference"),
                        sortable: true,
                    },
                    {
                        key: "created_at",
                        name: "expenses.created_at",
                        label: _t("created_at", "Created At"),
                        sortable: true,
                        formatter: (v) => this.$options.filters.localTime(v),
                    },
                ],
            }
        },
        methods: {
            startCase, colSum, colCount, msgBox,
            getTodaysExpenses(ctx) {
                return axios
                    .post(route("Backend.Expenses.List", {page: ctx.currentPage}), {
                        date: this.date,
                        per_page: ctx.perPage || 10,
                        orderBy: ctx.sortBy || 'id',
                        order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                    })
                    .then((res) => {
                        this.expenses = {...this.expenses, ...res.data};
                        return res.data.data;
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.$set(this, 'expenses', {
                            sortBy: 'id',
                            sortDesc: true,
                            per_page: 30,
                            current_page: 1,
                            total: 0,
                            from: 0,
                            to: 0,
                            data: []
                        });
                        return [];
                    });
            },
        }
    }
</script>

<style scoped>

</style>
