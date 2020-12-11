<template>
    <div>
        <dt-table v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  :title="$route.meta.title"
        >
            <template v-slot:table>
                <b-table ref="datatable" variant="primary" responsive="md" hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                         :tbody-tr-class="rowClass"
                         @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)"
                >
                    <template v-slot:row-details="row">
                        <b-row no-gutters>
                            <b-col md="6">
                                <b-card title="Old Values" body-class="p-2">
                                    <b-table responsive head-variant="dark" :items="obj2Table(row.item.old_values)">
                                        <template v-slot:cell(key)="rr">
                                            {{startCase(rr.item.key)}}
                                        </template>
                                    </b-table>
                                </b-card>
                            </b-col>
                            <b-col md="6">
                                <b-card title="New Values" body-class="p-2" class="ml-md-1">
                                    <b-table responsive head-variant="dark" :items="obj2Table(row.item.new_values)">
                                        <template v-slot:cell(key)="rr">
                                            {{startCase(rr.item.key)}}
                                        </template>
                                    </b-table>
                                </b-card>
                            </b-col>
                        </b-row>
                    </template>
                </b-table>
            </template>
        </dt-table>
    </div>
</template>


<script>
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable, {isTrue, setColumns} from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";
    import startCase from "bootstrap-vue/esm/utils/startcase";

    export default {
        name: "HistoryList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: 'History'
            },
            api_url: {
                type: String,
                default: () => route('Backend.History.List')
            },
            custom_buttons: {
                type: Array,
                default: () => []
            },
        },
        created() {
            this.$route.meta.title = startCase(this.$route.params.model || '') + ' History';
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'type', sortable: true, label: _t('type', 'Type')},
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                ]
            }
        },
        methods: {
            getItems(ctx) {
                // console.log(ctx)
                return axios.post(this.api_url + "?page=" + (ctx.currentPage ? ctx.currentPage : 1), {
                    per_page: this.datatable.per_page,
                    orderBy: ctx.sortBy || 'id',
                    order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                    // order: isTrue(ctx.sortDesc) && ctx.sortBy ? 'desc' : 'asc',
                    filter: ctx.filter,
                    model: this.$route.params.model,
                    columns: setColumns(this)
                }).then(res => {
                    // console.log(res);
                    this.datatable.total = res.data.total;
                    this.datatable.from = res.data.from;
                    this.datatable.to = res.data.to;
                    this.datatable.current_page = res.data.current_page;
                    return res.data.data;
                }).catch(err => {
                    console.log(err.response);
                    return [];
                });
            },
            rowClass(item, type) {
                if (!item || type !== 'row') return
                if (item._showDetails) return 'table-info'
            }
        }
    }
</script>
