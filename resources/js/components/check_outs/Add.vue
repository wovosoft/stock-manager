<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             @shown="initForm"
             v-model="visible"
             size="lg"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__((form.id?'edit':'add')+'_check_out',(form.id?'Edit ':'Add ')+'Check Out')"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-row>
                <b-col>
                    <b-form-group :label="__('datetime','Date & Time')">
                        <b-form-input type="datetime-local" step="any" v-model="form.datetime"/>
                    </b-form-group>
                    <b-form-group :label="__('reference','Reference')">
                        <b-form-input v-model="form.reference" :placeholder="__('reference','Reference')"/>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group :label="__('supplier','Supplier')">
                        <vue-select
                            required
                            :api_url="route('Backend.Suppliers.Search').url()"
                            v-model="form.supplier"
                            @input="v=>form.supplier_id=v?v.id:null"
                        >
                            <template v-slot:tag="op">
                                {{op.tag?[op.tag.id,op.tag.name].join(' # '):__('not_selected','Not Selected')}}
                            </template>
                            <template v-slot:option="op">
                                {{[op.item.id,op.item.name].join(' # ')}}
                            </template>
                        </vue-select>
                    </b-form-group>
                    <b-form-group :label="__('attachment','Attachment')">
                        <b-form-file v-model="form.attachment_upload"/>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-form-group :label="__('note','Note')">
                <b-form-textarea :placeholder="__('check_out_note','Check-out Note')" v-model="form.note"/>
            </b-form-group>
            <vue-select
                :placeholder="__('select_and_search_products','Search & Select Products')"
                :api_url="route('Backend.Products.Search').url()"
                @input="v=>addItem(v)"
            >
                <template v-slot:option="op">
                    {{[op.item.id,op.item.name].join(' # ')}} ({{op.item.code}})
                </template>
            </vue-select>
            <b-table
                bordered
                hover
                striped
                small
                head-variant="dark"
                :items="form.items"
                :fields="[
                    {
                        key:'name',
                        formatter:(a,r,d)=>[d.product_id,d.name].join(' # '),
                        label:__('name','Name')
                    },
                    {key:'code',label: __('code','Code')},
                    {key:'available',label: __('available','Available')},
                    {key:'quantity',label: 'Quantity'},
                    {
                        key: 'action',
                        label: __('action','Action'),
                        tdClass:'text-right',
                        thClass:'text-right'
                    }
                ]">
                <template v-slot:cell(quantity)="row">
                    <b-form-input type="number" size="sm"
                                  :placeholder="__('quantity','Quantity')"
                                  v-model="row.item.quantity" :max="row.item.available"/>
                </template>
                <template v-slot:cell(action)="row">
                    <b-button
                        @click="form.items.splice(row.index,1)"
                        size="sm"
                        variant="danger"
                        :title="(__('remove_item','Remove Item'))">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </template>
            </b-table>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="onSubmit">{{__('submit','SUBMIT')}}</b-button>
            <b-button @click="cancel()">{{__('cancel','CANCEL')}}</b-button>
        </template>
        <!--        <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import VueSelect from "@/partials/VueSelect";
    import dayjs from 'dayjs'

    export default {
        components: {VueSelect},
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Check.Outs.Store').url()
            }
        },
        methods: {
            initForm() {
                if (this.form.datetime) {
                    this.form.datetime = dayjs(this.form.datetime).format('YYYY-MM-DDTHH:mm:ss');
                } else {
                    this.form.datetime = dayjs().format('YYYY-MM-DDTHH:mm:ss');
                }
                if (!this.form.items) {
                    this.$set(this.form, 'items', []);
                }
            },
            addItem(item) {
                this.form.items.push({
                    name: item.name,
                    product_id: item.id,
                    available: item.quantity,
                    quantity: 1,
                    code: item.code,
                });
            }
        }

    }
</script>

