<template>
    <b-modal @hidden="()=>{
                $router.go(-1);
                $emit('reset',true);
                if (dirty){
                    $emit('refreshDatatable',true);
                }
             }"
             visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_sale','View Sale')"
             lazy>
        <b-row>
            <b-col sm="12" md="4">
                <h4>{{__('customer_details','Customer Details')}}</h4>
                <b-table
                    :items="obj2Table(the_item.customer,['deleted_at'])"
                    :fields="[
                        {key:'key',label:__('key','Key'),formatter:v=>__(v,startCase(v))},
                        {key:'value',label:__('value','Value')}
                    ]"
                    striped
                    bordered
                    small head-variant="dark">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
            <b-col sm="12" md="8">
                <h4>{{__('cart_details','Cart Details')}}</h4>
                <b-table small hover striped bordered
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image','items','customer','customer_name'])"
                         :fields="[
                            {
                                label:__('key','Key'),
                                key: 'key', sortable: true,
                                formatter: (v) => __(v,startCase(v))
                            },
                            {
                                label:__('value','Value'),
                                key: 'value',
                                sortable: true
                            }
                       ]">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
                        </template>
                        <template v-else-if="['description'].includes(row.item.key)">
                            <div v-html="row.item.value"></div>
                        </template>
                        <template v-else-if="['thumbnail'].includes(row.item.key)">
                            <b-img-lazy fluid :src="row.item.value"></b-img-lazy>
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-row>

        <h3 class="text-center">{{__('sale_items','Sale Items')}}</h3>
        <b-table
            small
            striped
            bordered
            head-variant="dark"
            :items="the_item.items"
            :fields="saleItemFields">
            <template #cell(return_quantity)="row">
                <b-form @submit.prevent="returnItems(row.item)">
                    <b-input-group size="sm">
                        <b-input :max="row.item.quantity" type="number" step="any" v-model="row.item.return_quantity"/>
                        <template #append>
                            <b-button :title="__('submit','Submit')" type="submit">
                                <b-icon-arrow-clockwise></b-icon-arrow-clockwise>
                            </b-button>
                        </template>
                    </b-input-group>
                </b-form>
            </template>
        </b-table>

        <h3 class="text-center">Payments History</h3>
        <payments-history :sale="the_item" :customer-overview="false"/>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import Payments from "@/components/sales/Payments";
    import statuses from "@/shared/statuses";
    import {msgBox} from "@/partials/datatable";

    export default {
        mixins: [view],
        components: {
            PaymentsHistory: Payments
        },
        methods: {
            msgBox,
            returnItems(item) {
                if (item.quantity < item.return_quantity) {
                    this.msgBox({
                        message: 'Return Qty. should be less than quantity',
                        type: 'danger',
                        title: 'Failed'
                    });
                    return false;
                }
                axios.post(route('Backend.Sales.Items.Return', {
                    sale: item.sale_id,
                    sale_item: item.id
                }).url(), {return_quantity: item.return_quantity}).then(res => {
                    this.msgBox(res.data);
                    this.dirty = true;
                    this.getItem(this.$route.params.id, this.$parent.$props.api_url)
                        .then(rr => {
                            this.the_item = rr.data;
                        })
                        .catch(err => console.log(err.response));
                }).catch(err => {
                    this.msgBox(err.response.data);
                    console.log(err.response);
                });
            }
        },
        data() {
            return {
                dirty: false,
                statuses,
                saleItemFields: [
                    // {key: 'id', label: _t('id', 'ID')},
                    {key: 'product_name', label: _t('product_name', 'Product Name')},
                    {key: 'quantity', label: _t('quantity', 'Quantity')},
                    {
                        key: 'price', label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    // {
                    //     key: 'total', label: _t('total', 'Total'),
                    //     formatter: v => this.$options.filters.currency(v)
                    // },
                    // {key: 'tax', label: _t('tax', 'Tax')},
                    // {key: 'discount', label: _t('discount', 'Discount')},
                    {
                        key: 'payable',
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'return_quantity',
                        label: _t('return_quantity', 'Returned Qty.'),
                    },
                    {
                        key: 'return_price', label: _t('return_price', 'Returned Price'),
                        formatter: v => this.$options.filters.currency(v)
                    }
                ]
            }
        }
    }
</script>
