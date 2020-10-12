<template>
    <div>
        <dt-table :title="title" v-model="search" :fields="fields" :datatable="datatable"
                  :custom_buttons="custom_buttons"
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
                         :per-page="datatable.per_page" :current-page="datatable.current_page"
                >
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :to="{name:'LanguagesView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :to="{name:'LanguagesEdit',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger" @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '../../partials/DtHeader'
    import DtFooter from '../../partials/DtFooter'
    import Datatable from "../../partials/datatable";
    import DtTable from "../../partials/DtTable";

    export default {
        name: "LanguagesList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: _t('languages', 'Languages')
            },
            api_url: {
                type: String,
                default: () => route('Backend.Languages.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Languages.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Languages.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: 'Add',
                        variant: 'dark',
                        to: {name: 'LanguagesAdd'}
                    }
                ]
            },
        },
        data() {
            return {
                form: {},
                fields: [
                    {key: 'id', sortable: true, label: this.__('id', "ID")},
                    {key: 'name', sortable: true, label: this.__('name', 'Name')},
                    {
                        key: 'description',
                        label: this.__('description', 'Description'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        label: this.__('created_at', 'Created At'),
                        visible:false,
                        sortable: true, formatter: v => this.dayjs(v)
                    },
                    {
                        key: 'updated_at',
                        visible:false,
                        label: this.__('updated_at', 'Updated At'),
                        sortable: true, formatter: v => this.dayjs(v)
                    },
                    {
                        key: 'action',
                        label: this.__('action', 'Action'),
                        sortable: false, searchable: false, thClass: 'text-right', tdClass: 'text-right'
                    },
                ]
            }
        }
    }
</script>
