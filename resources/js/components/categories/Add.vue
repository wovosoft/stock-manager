<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             v-bind="{...BasicModalOptions}"
             :title="__((form.id?'edit':'add ')+'_category',(form.id?'Edit ':'Add ')+'Category')">
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-row>
                <b-col md="4" sm="12">
                    <b-form-group :label="__('name','Name')+' *'">
                        <b-form-input v-model="form.name" :placeholder="__('name','Name')" :required="true"/>
                    </b-form-group>
                    <b-form-group :label="__('code','Code')">
                        <b-form-input v-model="form.code" :placeholder="__('code','Code')"/>
                    </b-form-group>
                </b-col>
                <b-col md="8" sm="12">
                    <b-form-group :label="__('description','Description')">
                        <b-form-textarea :rows="5" :placeholder="__('description','Description')"
                                         v-model="form.description"/>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <div class="mb-3">
                <h4 class="d-inline">Subcategories</h4>
                <b-button size="sm" class="float-right"
                          @click="form.subcategories.push({name:'',description:''})">
                    <b-icon-plus/>
                </b-button>
            </div>
            <b-table small hover striped bordered head-variant="dark"
                     :items="form.subcategories"
                     :fields="subcatfields">
                <template v-slot:cell(name)="row">
                    <b-input type="text" v-model="row.item.name" :required="true" size="sm" placeholder="Name"/>
                </template>
                <template v-slot:cell(description)="row">
                    <b-input type="text" v-model="row.item.description" size="sm"
                             placeholder="Description"/>
                </template>
                <template v-slot:cell(action)="row">
                    <b-button size="sm" @click="form.subcategories.splice(row.index,1)">
                        <b-icon-trash/>
                    </b-button>
                </template>
            </b-table>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="onSubmit">
                {{__('submit','SUBMIT')}}
            </b-button>
            <b-button @click="cancel()">
                {{__('cancel','CANCEL')}}
            </b-button>
        </template>
        <!--        <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import {BasicModalOptions} from "@/partials/datatable";

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Categories.Store').url()
            },
            subcatfields: {
                type: Array,
                default: () => [
                    {
                        key: 'name',
                        label: _t('name', 'Name')
                    },
                    {
                        key: 'description',
                        label: _t('description', 'Description')
                    },
                    {
                        key: 'action',
                        label: _t('action', 'Action'),
                        tdClass: 'text-right',
                        thClass: 'text-right'
                    }
                ]
            }
        },
        mounted() {
            if (!this.form.subcategories) {
                this.$set(this.form, 'subcategories', []);
            }
        },
        data() {
            return {
                BasicModalOptions
            }
        }
    }
</script>

