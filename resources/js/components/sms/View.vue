<template>
    <b-modal @hidden="$router.go(-1)" visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             body-class="p-0"
             footer-class="p-2"
             :ok-title="__('ok','Ok')"
             :cancel-title="__('cancel','Cancel')"
             :title="__('view_sms','View SMS')"
             lazy>
        <b-row>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at'])"
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
                        <template v-else-if="['contacts'].includes(row.item.key)">
                            {{row.item.value.join(", ")}}
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
