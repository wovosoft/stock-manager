<template>
    <div>
        <dt-table :title="__(title,startCase(title))"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
        >
            <template #header_dropdowns>
                <b-button variant="dark" size="sm" @click="$refs.datatable.refresh()">
                    <i class="fa fa-sync"></i>
                </b-button>
            </template>
            <template #header_bottom_panel>
                <b-row class="mt-3">
                    <b-col md="4" sm="12">
                        <b-form-group :label="__('customer', 'Customer')" label-cols-md="4">
                            <b-input-group size="sm">
                                <vue-select
                                    size="sm"
                                    :required="true"
                                    @input="(v) => {
                                        $set(datatable.search_columns,'customer_id',v ? v.id : null);
                                    }"
                                    v-model="temp_customer"
                                    :tag-text="(op)=>op ? [op.id, op.name].join(' # '): __('not_selected', 'Not Selected')"
                                    :option-text="(op)=>op ? [op.id, op.name,op.village].join(' # '): ''"
                                    :api_url="route('Backend.Customers.Search')">
                                </vue-select>
                                <template v-slot:append>
                                    <b-button
                                        @click="(temp_customer = null), (datatable.search_columns.customer_id = null)"
                                        class="font-weight-bold">
                                        <b-icon-x/>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="4" sm="12">
                        <b-form-group :label="__('status','Status')" label-cols-md="4">
                            <b-input-group size="sm">
                                <b-select
                                    v-model="datatable.search_columns.status"
                                    :options="statuses"/>
                                <template #append>
                                    <b-button @click="datatable.search_columns.status=null">
                                        <b-icon-x/>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="4" sm="12">
                        <b-form-group :label="__('user','User')" label-cols-md="4">
                            <b-input-group size="sm">
                                <vue-select
                                    :init-options="true"
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
                                      :to="{name:'CollectionsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'CollectionsEdit',params:{id:row.item.id}}"
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
                    <template #foot(payment_amount)="row">
                        {{colSum(datatable.items,'payment_amount')|currency}}
                    </template>
                    <template #foot(previous_balance)="row">
                        {{colSum(datatable.items,'previous_balance')|currency}}
                    </template>
                    <template #foot(current_balance)="row">
                        {{colSum(datatable.items,'current_balance')|currency}}
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
    import Datatable, {commonDtOptions, colSum} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import statuses from "@/shared/statuses";
    import VueSelect from "@/partials/VueSelect";

    export default {
        name: "CollectionsList",
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
                default: _t('collections', 'Collections')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Collections.List')
            },
            trash_url: {
                type: String,
                // default: () => route('Backend.Collections.Delete')
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Collections.Store')
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'CollectionsAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'collections'
                            }
                        }
                    }
                ]
            },
        },
        beforeMount() {
            const date = new Date();
            this.datatable.search_columns.starting_date = [date.getFullYear(), date.getMonth() + 1, date.getDate()].join("-");
            this.$set(this.datatable.search_columns, 'status', 'Pending');
        },
        methods: {
            colSum,
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
                            axios
                                .post(route('Backend.Collections.Delete', {order_collection: id}))
                                .then(res => {
                                    console.log(res)
                                    this.$root.msgBox(res.data);
                                    this.$refs.datatable.refresh();
                                })
                                .catch(err => {
                                    console.log(err.response);
                                    this.$root.msgBox(err.response.data);
                                });
                        }
                    });
            }
        },
        data() {
            return {
                temp_customer: null,
                temp_user: null,
                statuses,
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {
                        key: 'customer_id', sortable: true, label: _t('name', 'Name'),
                        formatter: (i, v, r) => r.customer ? [r.customer.id, r.customer.name].join('#') : null
                    },
                    {
                        key: 'previous_balance',
                        sortable: true,
                        label: _t('previous_balance', 'Previous Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'payment_amount',
                        sortable: true,
                        label: _t('payment_amount', 'Payment Amount'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'current_balance',
                        sortable: true,
                        label: _t('current_balance', 'Current Balance'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'status',
                        sortable: true,
                        label: _t('status', 'Status'),
                        formatter: v => v ? _t(v) : null
                    },
                    {
                        key: 'reference',
                        sortable: true,
                        label: _t('reference', 'Reference'),
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
