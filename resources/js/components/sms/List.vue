<template>
    <div>
        <dt-table :title="__(title,startCase(title))"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons">
            <template v-slot:table>
                <b-table ref="datatable" v-bind="commonDtOptions()">
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :title="__('view','View')"
                                      :to="{name:'SMSView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :title="__('edit','Edit')"
                                      :to="{name:'SMSEdit',params:{id:row.item.id}}"
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
        <router-view
            @reset="currentItem={}"
            @refreshDatatable="()=>$refs.datatable.refresh()"
            :item="currentItem"/>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";

    export default {
        name: "SMSList",
        components: {
            DtHeader,
            DtFooter,
            DtTable,
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: ' SMS'
            },
            api_url: {
                type: String,
                default: () => route('Backend.SMS.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.SMS.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.SMS.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: _t('add', 'Add'),
                        variant: 'dark',
                        to: {name: 'SMSAdd'}
                    },
                    {
                        text: _t('history', 'History'),
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'sms'
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
                    {key: 'id', sortable: true, label: _t('id', 'ID')},
                    {key: 'provider', sortable: true, label: _t('provider', 'Provider')},
                    {key: 'sms_id', sortable: true, label: _t('sms_id', 'SMS ID')},
                    {key: 'type', sortable: true, label: _t('type', 'Type')},
                    {key: 'sender', sortable: true, label: _t('sender', 'Sender')},
                    {
                        key: 'contacts', sortable: true,
                        label: _t('contacts', 'contacts'),
                        formatter: v => (v || []).join(",")
                    },
                    {
                        key: 'message',
                        label: _t('message', 'Message'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'delivery',
                        label: _t('delivery', 'Delivery'),
                        sortable: true,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        label: _t('created_at', 'Created At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        sortable: true,
                        visible: false,
                        label: _t('updated_at', 'Updated At'),
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'action',
                        sortable: false,
                        label: _t('action', 'Action'),
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    },
                ]
            }
        }
    }
</script>
