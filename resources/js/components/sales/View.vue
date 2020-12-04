<template>
    <b-modal @hidden="()=>{
                $router.go(-1);
                $emit('reset',true);
                if (dirty){
                    $emit('refreshDatatable',true);
                }
             }"
             v-if="the_item"
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
                    style="border: 1px solid lightgray"
                    :items="obj2Table(the_item.customer,['deleted_at','created_at','updated_at','photo','shipping_address','id'])"
                    :fields="[
                        {key:'key',label:__('key','Key'),formatter:v=>__(v,startCase(v))},
                        {key:'value',label:__('value','Value')}
                    ]"
                    striped
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
                <h4>{{__('sale_details','Sale Details')}}</h4>
                <b-table small hover striped
                         style="border: 1px solid lightgray"
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image','items','customer','customer_name','customer_id','tax','discount','updated_at','total','status'])"
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
        </b-table>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import statuses from "@/shared/statuses";

    export default {
        mixins: [view],
        methods: {
        },
        data() {
            return {
                dirty: false,
                statuses,
                saleItemFields: [
                    // {key: 'id', label: _t('id', 'ID')},
                    {key: 'product_name', label: _t('product_name', 'Product Name')},
                    {
                        key: 'quantity',
                        label: _t('quantity', 'Quantity'),
                        formatter: v => this.$options.filters.localNumber(v)

                    },
                    {
                        key: 'price', label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'payable',
                        label: _t('payable', 'Payable'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                ]
            }
        }
    }
</script>
