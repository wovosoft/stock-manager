<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :ok-title="__('ok','OK')"
             :cancel-title="__('cancel','Cancel')"
             :title="__('view_supplier','View Supplier')"
             lazy>
        <b-row>
            <b-col md="3" sm="12" v-if="the_item.photo">
                <b-img-lazy fluid thumbnail :src="'storage/'+the_item.photo"></b-img-lazy>
            </b-col>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image'])"
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
                        <template
                            v-else-if="['deposit_amount','withdrawn_amount','funds_balance','sales_payable','sales_paid','sales_balance','final_balance'].includes(row.item.key)">
                            {{row.item.value | currency}}
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
