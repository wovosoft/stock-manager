<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             visible
             size="lg"
             header-bg-variant="dark"
             header-text-variant="light"
             body-class="p-1"
             footer-class="p-2"
             :title="__('view_product','View Product')"
             :ok-title="__('ok','Ok')"
             :cancel-title="__('cancel','Cancel')"
             lazy>
        <b-row>
            <b-col md="4" v-if="the_item.photo_url">
                <b-img-lazy thumbnail fluid :src="the_item.photo_url"/>
            </b-col>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['photo_url','photo','deleted_at','unit','brand','category','subcategory','subcategory_id','unit_id','brand_id','category_id'])"
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

                        <template
                            v-else-if="['cost','price','total_cost','total_price','probable_profit'].includes(row.item.key)">
                            {{row.item.value | currency}}
                        </template>
                        <template v-else-if="['quantity','alert_quantity'].includes(row.item.key)">
                            {{row.item.value | localNumber}}
                        </template>
                        <template v-else-if="['status'].includes(row.item.key)">
                            {{(!!Number(row.item.value))?__('active','Active'):__('inactive','Inactive') }}
                        </template>
                        <template v-else-if="['description'].includes(row.item.key)">
                            <div v-html="row.item.value"></div>
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-row>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"

    export default {
        mixins: [view]
    }
</script>
