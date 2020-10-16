<template>
    <b-modal @hidden="$router.go(-1)" visible
             v-bind="{...BasicModalOptions,size:'md'}"
             :title="__('view_unit','View Unit')">
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

    import {BasicModalOptions} from '@/partials/datatable';

    export default {
        mixins: [view],
        data() {
            return {
                BasicModalOptions
            }
        }
    }
</script>
