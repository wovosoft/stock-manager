<template>
    <div>
        <dt-table :title="__(title,startCase(title))"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
                  :custom_buttons="custom_buttons"
        >
            <template #header_dropdowns>
                <b-button variant="dark" size="sm" @click="$refs.datatable.refresh()">
                    <i class="fa fa-sync"></i>
                </b-button>
            </template>
            <template #header_bottom_panel>
                <b-row class="mt-3">
                    <b-col md="3" sm="12">
                        <b-form-group :label="__('status','Status')" label-cols-md="3">
                            <b-input-group size="sm">
                                <b-select v-model="datatable.search_columns.status" :options="statuses"/>
                                <template #append>
                                    <b-button @click="datatable.search_columns.status=null">
                                        <b-icon-x/>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="5" sm="12">
                        <b-form-group :label="__('customer','Customer')"
                                      label-cols-md="4">
                            <b-input-group size="sm">
                                <vue-select
                                    size="sm"
                                    @input="(v) => {
                                        $set(datatable.search_columns,'customer_id',v ? v.id : null)
                                    }"
                                    v-model="temp_customer"
                                    :tag-text="(op) =>op? [op.id, op.name].join(' # '): __('not_selected','Not Selected')"
                                    :option-text="(op) =>op? [op.id, op.name,  op.village].join(' # '): __('not_selected','Not Selected')"
                                    :api_url="route('Backend.Customers.Search')"
                                />
                                <template #append>
                                    <b-button @click="()=>{
                                        $set(datatable.search_columns,'customer_id', null);
                                        temp_customer=null;
                                    }">
                                        <b-icon-x/>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="4" sm="12">
                        <b-form-group :label="__('user','User')"
                                      label-cols-md="4">
                            <b-input-group size="sm">
                                <vue-select
                                    size="sm"
                                    @input="(v) => {
                                        $set(datatable.search_columns,'user_id',v ? v.id : null)
                                    }"
                                    v-model="temp_user"
                                    :tag-text="(op) =>op? op.name: __('not_selected','Not Selected')"
                                    :option-text="(op) =>op? op.name: __('not_selected','Not Selected')"
                                    :api_url="route('Wovosoft.Users.Search')"
                                />
                                <template #append>
                                    <b-button @click="()=>{
                                        $set(datatable.search_columns,'user_id', null);
                                        temp_user=null;
                                    }">
                                        <b-icon-x/>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                </b-row>
            </template>
            <template v-slot:table>
                <b-table ref="datatable" v-bind="commonDtOptions()">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'OrdersView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'OrdersEdit',params:{id:row.item.id}}"
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
    import Datatable, {commonDtOptions} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import statuses from "@/shared/statuses";
    import VueSelect from "@/partials/VueSelect";

    export default {
        name: "OrdersList",
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
                default: _t('orders', 'Orders')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Orders.List')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Orders.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'OrdersAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'orders'
                            }
                        }
                    }
                ]
            },
        },
        beforeMount() {
            const date = new Date();
            this.datatable.search_columns.starting_date = [date.getFullYear(), date.getMonth() + 1, date.getDate()].join('-');
        },
        methods: {
            commonDtOptions() {
                return commonDtOptions(this);
            },
            trash(id) {
                this.$bvModal
                    .msgBoxConfirm(this.__('are_you_sure', 'Are you sure?'), {
                        okTitle: this.__('ok', 'Ok'),
                        cancelTitle: this.__('cancel', 'Cancel')
                    })
                    .then(value => {
                        if (value) {
                            axios.post(route('Backend.Orders.Delete', {order: id})).then(res => {
                                this.$root.msgBox(res.data);
                                this.$refs.datatable.refresh();
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
        },
        data() {
            return {
                statuses,
                temp_customer: null,
                temp_user: null,
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'customer_title', sortable: true, label: _t('customer', 'Customer')},
                    {
                        key: 'total', sortable: true, label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'paid', sortable: true, label: _t('paid', 'Paid'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'status', sortable: true, label: _t('status', 'Status'),
                        formatter: v => _t(v)
                    },
                    {
                        key: 'user',
                        sortable: true,
                        label: _t('submitted_by', 'Submitted By'),
                        formatter: v => v ? [v.id, v.name].join(' # ') : null
                    },
                    {
                        key: 'note',
                        label: _t('note', 'Note'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
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
