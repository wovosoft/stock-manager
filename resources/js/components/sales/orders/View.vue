<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)" visible
             v-bind="{...BasicModalOptions,size:'xl'}"
             :title="__('view_order','View Order')">
        <b-form-row>
            <b-col md="4" sm="12">
                <b-card :header="__('customer_details','Customer Details')"
                        header-bg-variant="dark"
                        header-text-variant="light"
                        body-class="p-0">
                    <b-table
                        thead-class="d-none"
                        class="mb-0"
                        v-if="the_item && the_item.customer"
                        small
                        hover
                        striped
                        bordered
                        head-variant="dark"
                        :fields="[{key:'key',formatter:v=>__(v)},'value']"
                        :items="obj2Table(the_item.customer)"/>
                </b-card>
            </b-col>
            <b-col md="4" sm="12" class="my-sm-3 my-md-0">
                <b-card :header="__('user_details','User Details')"
                        header-bg-variant="dark"
                        header-text-variant="light"
                        body-class="p-0">
                    <b-table
                        v-if="the_item && the_item.user"
                        class="mb-0"
                        thead-class="d-none"
                        small
                        hover
                        striped
                        bordered
                        head-variant="dark"
                        :fields="[{key:'key',formatter:v=>__(v)},'value']"
                        :items="obj2Table(the_item.user)"/>
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :header="__('order_details','Order Details')"
                        body-class="p-0"
                        header-bg-variant="dark"
                        header-text-variant="light">
                    <b-table small bordered hover striped
                             thead-class="d-none"
                             class="mb-0"
                             head-variant="dark"
                             :items="obj2Table(the_item,['deleted_at','user_id','customer_id','customer_title','customer','items','user'])"
                             :fields="[
                            {
                                key: 'key', sortable: true,
                                label:__('key','Key'),
                                formatter: (v) => __(v,startCase(v))
                            },
                            {
                                key: 'value',
                                label:__('value','Value'),
                                sortable: true
                            }
                       ]">
                        <template v-slot:cell(value)="row">
                            <template v-if="['created_at','updated_at'].includes(row.item.key)">
                                {{row.item.value | localDateTime}}
                            </template>
                            <template v-else-if="['description'].includes(row.item.key)">
                                <div v-html="row.item.value"></div>
                            </template>
                            <template v-else>{{row.item.value}}</template>
                        </template>
                    </b-table>
                </b-card>
            </b-col>
        </b-form-row>
        <b-card
            class="mt-4"
            :header="__('order_items','Order Items')"
            header-bg-variant="dark"
            header-text-variant="light"
            body-class="p-0">
            <b-table
                v-if="the_item && the_item.items && Array.isArray(the_item.items)"
                class="mb-0"
                small
                hover
                :responsive="true"
                striped
                bordered
                head-variant="dark"
                :fields="item_fields"
                :items="the_item.items"/>
        </b-card>
        <h2 class="text-center my-3">
            {{__('status','Status')}}
        </h2>
        <b-form @submit.prevent="">
            <b-form-group class="text-center">
                <b-form-radio-group
                    v-model="the_item.status"
                    name="order-status"
                    @change="changeStatus"
                    :options="[
                        {value:'pending',text:__('pending','Pending')},
                        {value:'accepted',text:__('accepted','Accepted')},
                        {value:'processed',text:__('processed','Processed')},
                        {value: 'cancelled',text: __('cancelled','Cancelled')}
                    ]">
                </b-form-radio-group>
            </b-form-group>
            <b-form-group class="text-center">
                <b-checkbox
                    v-if="!the_item.sale_id && !disabled"
                    @change="makeSale"
                    :checked="!!Number(the_item.sale_id)" switch>
                    {{__('create_sale','Create Sale')}}
                </b-checkbox>
                <template v-if="the_item.sale_id">
                    <b-button
                        target="_blank"
                        size="sm" variant="dark"
                        :href="route('Backend.Sales.Invoice.PDF',{sale:the_item.sale_id,type:'pdf',is_delivery:'no',invoice_both:'no'})">
                        Cash Memo
                    </b-button>
                    <b-button
                        target="_blank"
                        size="sm" variant="dark"
                        :href="route('Backend.Sales.Invoice.PDF',{sale:the_item.sale_id,type:'pdf',is_delivery:'yes',invoice_both:'no'})">
                        Delivery Slip
                    </b-button>
                    <b-button
                        target="_blank"
                        size="sm" variant="dark"
                        :href="route('Backend.Sales.Invoice.PDF',{sale:the_item.sale_id,type:'pdf',is_delivery:'no',invoice_both:'yes'})">
                        Cash & Delivery Memo
                    </b-button>
                </template>
            </b-form-group>
        </b-form>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import {BasicModalOptions} from "@/partials/datatable";

    export default {
        mixins: [view],
        data() {
            return {
                disabled: false,
                BasicModalOptions,
                item_fields: [
                    {key: 'id', label: _t('id', 'ID')},
                    {
                        key: 'product', label: _t('product_name', 'Product Name'),
                        formatter: v => [v.id, v.name].join(' # ')
                    },
                    {
                        key: 'quantity', label: _t('quantity', 'Quantity'),
                        formatter: v => this.$options.filters.localNumber(v)
                    },
                    {
                        key: 'price', label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'total', label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    // {
                    //     key: 'created_at',
                    //     label: _t('created_at', 'Created At'),
                    //     formatter: v => this.$options.filters.localDateTime(v)
                    // }
                ]
            }
        },
        methods: {
            changeStatus(value) {
                axios.post(route('Backend.Orders.ChangeStatus', {order: this.the_item.id}), {
                    status: value
                }).then(res => {
                    this.$root.msgBox(res.data);
                    this.getItem(this.the_item.id, route('Backend.Orders.List'))
                        .then(res => {
                            this.the_item = res.data
                        })
                        .catch(err => console.log(err.response));
                }).catch(err => {
                    console.log(err.response);
                    this.$root.msgBox(err.response.data);
                });
            },
            makeSale(value) {
                this.disabled = true;
                if (value) {
                    axios.post(route('Backend.Orders.MakeSale', {order: this.the_item.id}), {
                        status: value
                    }).then(res => {
                        this.$root.msgBox(res.data);
                        this.getItem(this.the_item.id, route('Backend.Orders.List'))
                            .then(res => {
                                this.the_item = res.data
                            })
                            .catch(err => console.log(err.response));
                    }).catch(err => {
                        console.log(err.response);
                        this.$root.msgBox(err.response.data);
                    });
                }
            }
        }
    }
</script>
