<template>
    <b-modal @hidden="$router.go(-1)" visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_purchase','View Purchase')"
             lazy>
        <b-row>
            <b-col sm="12" md="4">
                <h4>{{__('supplier_details','Supplier Details')}}</h4>
                <b-table :items="obj2Table(the_item.supplier)"
                         :fields="[{key:'key',label:__('key','Key'),formatter:v=>__(v,startCase(v))},
                         {key:'value',label:__('value','Value')}]"
                         small head-variant="dark"></b-table>
            </b-col>
            <b-col sm="12" md="8">
                <h4>{{__('cart_details','Cart Details')}}</h4>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image','items','supplier','supplier_name'])"
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

        <h3 class="text-center">Purchase Items</h3>
        <b-table
            small
            head-variant="dark"
            :fields="[
                {key:'id',label:__('id','ID')},
                {key:'purchase_id',label: __('purchase_id','Purchase ID')},
                {key:'product_name',label: __('product_name','Product Name')},
                {key:'quantity',label: __('quantity','Quantity')},
                {key:'price',label:__('price','Price'),formatter:v=>$options.filters.currency(v)},
                {key:'total',label:__('total','Total'),formatter:v=>$options.filters.currency(v)},
                {key:'tax',label:__('tax','Tax')},
                {key:'discount',label:__('discount','Discount')},
                {key:'payable',label:__('payable','Payable'),formatter:v=>$options.filters.currency(v)},
                {key:'status',label:__('status','Status')},
                {key:'created_at',label:__('created_at','Created At'),formatter:v=>$options.filters.dayjs(v)}]"
            :items="the_item.items"/>

        <h3 class="text-center">{{__('payment_history','Payments History')}}</h3>
        <payments-history :purchase="the_item" :supplier-overview="false"/>
        <!--        <pre v-html="the_item"></pre>-->
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import Payments from "@/components/purchases/Payments";

    export default {
        mixins: [view],
        components: {
            PaymentsHistory: Payments
        }
    }
</script>
