<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
                <h4>{{__('total_paid','Total Paid')}}: {{paid_salary | currency}}</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <b-select v-model="year" @change="$refs.the_table.refresh()"
                          :options="rangeIndexed(2010,2030,1)"></b-select>
            </div>
        </div>
        <b-table ref="the_table"
                 variant="primary"
                 responsive="md"
                 hover bordered small striped
                 head-variant="dark"
                 :items="getItems"
                 class="mb-0"
                 :fields="fields">
            <template v-slot:cell(action)="row">
                <b-button
                    size="sm"
                    :title="__('delete','Delete')"
                    @click="trash(row.item.id,row.item.payment_amount)">
                    <i class="fa fa-trash"></i> {{__('delete','Delete')}}
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    import {isTrue, rangeIndexed} from "@/partials/datatable";
    import months from "@/shared/months";

    export default {
        name: "EmployeePaidSalariesList",
        props: {
            employee: {
                type: Object,
                required: true
            }
        },
        mounted() {
            this.paid_salary = this.employee.paid_salary;
        },
        data() {
            return {
                paid_salary: 0,
                year: (new Date()).getFullYear(),
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'year', sortable: true, label: _t('year', 'Year')},
                    {
                        key: 'month', sortable: true,
                        label: _t('month', 'Month'),
                        formatter: v => months[v - 1]
                    },
                    {
                        key: 'payment_amount', sortable: true,
                        formatter: v => this.$options.filters.currency(v),
                        label: _t('payment_amount', 'Payment Amount')
                    },
                    {key: 'payment_method', sortable: true, label: _t('payment_method', 'Payment Method')},
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
                ],
                datatable: {},
                api_url: route('Backend.Employees.Paid.Salaries', {employee: this.employee.id}).url()
            }
        },

        methods: {
            rangeIndexed,
            getItems(ctx) {
                // console.log(ctx)
                return axios.post(this.api_url + "?page=" + (ctx.currentPage ? ctx.currentPage : 1), {
                    per_page: 15,
                    orderBy: ctx.sortBy || 'id',
                    order: !isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                    filter: ctx.filter,
                    year: this.year
                }).then(res => {
                    // console.log(res);
                    this.datatable.total = res.data.total;
                    this.datatable.from = res.data.from;
                    this.datatable.to = res.data.to;
                    this.datatable.current_page = res.data.current_page;
                    return res.data.data;
                }).catch(err => {
                    console.log(err.response);
                    return [];
                });
            },
            trash(id, amount) {
                this.$bvModal
                    .msgBoxConfirm(this.__('are_you_sure', 'Are you sure?'), {
                        okTitle: this.__('ok', 'Ok'),
                        cancelTitle: this.__('cancel', 'Cancel')
                    })
                    .then(value => {
                        if (value) {
                            axios.post(route('Backend.Employees.Salaries.Delete').url(), {
                                id: id,
                            }).then(res => {
                                this.paid_salary = Number(this.paid_salary) - Number(amount);
                                this.$root.msgBox(res.data);
                                this.$refs.the_table.refresh();
                                this.$emit('refresh', true);
                            }).catch(err => {
                                this.$root.msgBox(err.response.data);
                                console.log(err.response)
                            });
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    });
            },
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
