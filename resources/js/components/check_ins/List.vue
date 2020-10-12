<template>
    <div>
        <dt-table :title="title" v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
        >
            <template v-slot:table>
                <b-table ref="datatable"
                         variant="primary"
                         responsive="md"
                         hover
                         bordered
                         small
                         striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         :per-page="datatable.per_page"
                         :current-page="datatable.current_page"
                >
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'CheckInsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'CheckInsEdit',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger"
                                      :title="__('delete','Delete')"
                                      @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <router-view @reset="currentItem={}"
                     @refreshDatatable="()=>$refs.datatable.refresh()"
                     :item="currentItem"></router-view>
    </div>
</template>

<script>
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";

    export default {
        name: "CheckInsList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('check_ins', 'Check Ins')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Check.Ins.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Check.Ins.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Check.Ins.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'CheckInsAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'check_ins'
                            }
                        }
                    }
                ]
            },
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true},
                    {
                        key: 'creator',
                        label: _t('created_by', 'Created By'),
                        sortable: false,
                        formatter: v => v.name
                    },
                    {
                        key: 'datetime',
                        sortable: true,
                        label: _t('datetime', 'Created By')
                    },
                    {key: 'reference', sortable: true, label: _t('reference', 'Reference')},
                    {
                        key: 'supplier',
                        sortable: false,
                        formatter: v => v.name,
                        label: _t('supplier', 'Supplier')
                    },
                    {
                        key: 'note',
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || ""),
                        label: _t('note', 'Note')
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        formatter: v => this.dayjs(v),
                        label: _t('created_at', 'Created At')
                    },
                    {
                        key: 'updated_at',
                        sortable: true,
                        formatter: v => this.dayjs(v),
                        label: _t('updated_at', 'Updated At')
                    },
                    {
                        key: 'action',
                        sortable: false,
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right',
                        label: _t('action', 'Action')
                    },
                ]
            }
        }
    }
</script>
