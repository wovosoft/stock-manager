<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             scrollable
             :title="__('view_language','View Language')"
             lazy>
        <b-row>
            <b-col>
                <b-table small bordered
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at'])"
                         :fields="[
                            {
                                key: 'key', sortable: true,
                                label:__('key','Key'),
                                formatter: (v) => startCase(__(v))
                            },
                            {
                                key: 'value',
                                label: __('value','Value'),
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
                        <template v-else-if="['definitions'].includes(row.item.key)">
                            <b-table hover :items="row.item.value" :fields="['key','value']"></b-table>
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
