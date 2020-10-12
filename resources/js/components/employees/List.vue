<template>
    <div>
        <b-row class="mb-3">
            <b-col md="6" sm="12">
                <b-card :title="__('total_employees','Total Employees')">
                    {{overview.total_employees | localNumber}}
                </b-card>
            </b-col>
            <b-col md="6" sm="12">
                <b-card :title="__('paid_salary','Paid Salary')">
                    {{overview.paid_salary | currency}}
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
                         @refreshed="overview=JSON.parse(headers.employee_summery)"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page" :current-page="datatable.current_page"
                         foot-clone
                         foot-variant="light"
                >
                    <template v-slot:foot(salary)="row">
                        {{colSum(datatable.items,'salary')|currency}}
                    </template>
                    <template v-slot:foot(paid_salary)="row">
                        {{colSum(datatable.items,'paid_salary')|currency}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-dropdown right size="sm">
                            <b-dropdown-item
                                :title="__('send_salary','Send Salary')"
                                v-b-modal:add_salary_modal
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i> {{__('send_salary','Send Salary')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('paid_salaries','Paid Salaries')"
                                v-b-modal:list_paid_salaries
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i> {{__('paid_salaries','Paid Salaries')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('view','View')"
                                :to="{name:'EmployeesView',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i> {{__('view_employee','View Employee')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('edit','Edit')"
                                :to="{name:'EmployeesAdd',params:{id:row.item.id}}"
                                @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i> {{__('edit_employee','Edit Employee')}}
                            </b-dropdown-item>
                            <b-dropdown-item
                                :title="__('delete','Delete')"
                                @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i> {{__('delete_employee','Delete Employee')}}
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <router-view @reset="currentItem={}"
                     @refreshDatatable="()=>$refs.datatable.refresh()"
                     :item="currentItem"></router-view>
        <b-modal id="add_salary_modal"
                 v-if="currentItem"
                 lazy
                 hide-footer
                 @hidden="currentItem=null"
                 :title="'Send Salary'"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <add-salary
                    @message="v=>msgBox(v)"
                    :salary="currentItem.salary"
                    @success="v=>{if(v) hide();currentItem=null;}"
                    @refresh="v=>$refs.datatable.refresh()"
                    v-if="currentItem && currentItem.id"
                    :employee-id="currentItem.id"/>
            </template>
        </b-modal>
        <b-modal id="list_paid_salaries"
                 lazy
                 size="xl"
                 hide-footer
                 @hidden="currentItem=null"
                 @message="v=>msgBox(v)"
                 :title="__('paid_salaries','Paid Salaries')"
                 header-bg-variant="dark"
                 header-text-variant="light">
            <template v-slot:default="{hide}">
                <list-paid-salaries v-if="currentItem" :employee="currentItem"/>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable, {colSum} from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";
    import AddSalary from "@/components/employees/AddSalary";
    import ListPaidSalaries from "@/components/employees/ListPaidSalaries";

    export default {
        name: "EmployeeList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            AddSalary,
            ListPaidSalaries
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('employees', 'Employees')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Employees.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Employees.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Employees.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'EmployeesAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'employees'
                            }
                        }
                    }
                ]
            },
        },
        methods: {colSum},
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'name', sortable: true, label: _t('name', 'Name')},
                    {key: 'position', sortable: true, label: _t('position', 'Position')},
                    {
                        key: 'salary', sortable: true, label: _t('salary', 'Salary'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'paid_salary',
                        sortable: true,
                        searchable: false,
                        label: _t('paid_salary', 'Paid Salary'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {key: 'email', sortable: true, label: _t('email', 'Email')},
                    {key: 'phone', sortable: true, label: _t('phone', 'Phone')},
                    {key: 'company', sortable: true, label: _t('company', 'Company')},
                    {key: 'district', sortable: true, label: _t('district', 'District')},
                    {key: 'thana', sortable: true, label: _t('thana', 'Thana')},
                    {key: 'post_office', sortable: true, label: _t('post_office', 'P.O.')},
                    {key: 'village', sortable: true, label: _t('village', 'Village')},
                    {
                        key: 'is_active', sortable: true,
                        formatter: v => !!Number(v) ? _t('active', 'Active') : _t('inactive', 'Inactive'),
                        label: _t('is_active', 'Is Active')
                    },
                    {
                        key: 'joining_date',
                        sortable: true,
                        label: _t('joining_date', 'Joining Date'),
                        formatter: v => this.dayjs(v, 'DD-MM-YYYY')
                    },
                    {
                        key: 'leaving_date',
                        sortable: true,
                        label: _t('leaving_date', 'Leaving Date'),
                        formatter: v => !v ? '' : this.dayjs(v, 'DD-MM-YYYY')
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.dayjs(v)
                    },
                    {
                        key: 'updated_at',
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
<style lang="scss">
    table {
        th {
            vertical-align: top !important;
        }
    }
</style>
