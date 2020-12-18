<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_withdrawal_details','View Withdrawal Details')"
             lazy>
        <b-row>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at'])"
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
                        <template v-if="['payment_amount'].includes(row.item.key)">
                            {{row.item.value | currency}}
                        </template>
                        <template v-else-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
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
