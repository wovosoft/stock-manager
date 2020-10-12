<template>
    <b-modal @hidden="$router.go(-1)" visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_subcategory','View Subcategory')"
             lazy>
        <b-row>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image'])"
                         :fields="[
                            {
                                key: 'key', sortable: true,
                                formatter: (v) =>__(v, startCase(v))
                            },
                            {
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
    </b-modal>
</template>
<script>
    import view from "@/partials/view"

    export default {
        mixins: [view]
    }
</script>
