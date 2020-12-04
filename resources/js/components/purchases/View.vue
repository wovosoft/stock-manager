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
             :title="__('view_purchase','View Purchase')"
             lazy>
        <b-row>
            <b-col sm="12" md="4">
                <h4>{{__('supplier_details','Supplier Details')}}</h4>
                <b-table
                    :items="obj2Table(the_item.supplier,['deleted_at','created_at','updated_at','photo','shipping_address','id'])"
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
                <h4>{{__('purchase_details','Purchase Details')}}</h4>
                <b-table small hover striped bordered
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image','items','supplier','supplier_name','supplier_id','tax','discount','updated_at','total','status'])"
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
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-row>

        <h3 class="text-center">{{__('purchase_items','Purchase Items')}}</h3>
        <b-table
            small
            striped
            bordered
            head-variant="dark"
            :items="the_item.items"
            :fields="purchaseItemFields">
        </b-table>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import statuses from "@/shared/statuses";

    export default {
        mixins: [view],
        data() {
            return {
                dirty: false,
                statuses,
                purchaseItemFields: [
                    // {key: 'id', label: _t('id', 'ID')},
                    {key: 'product_name', label: _t('product_name', 'Product Name')},
                    {key: 'quantity', label: _t('quantity', 'Quantity')},
                    {
                        key: 'price', label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'total',
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    }
                ]
            }
        }
    }
</script>
