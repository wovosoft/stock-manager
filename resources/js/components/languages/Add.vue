<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             size="xl"
             scrollable
             no-close-on-backdrop
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             lazy>
        <template v-slot:modal-header="{close}">
            <b-row class="w-100">
                <b-col>
                    <h5 class="modal-title">
                        {{__((form.id?'edit':'add')+'_language',(form.id?'Edit ':'Add ')+'Language')}}
                    </h5>
                </b-col>
                <b-col class="text-right">
                    <b-button @click="addDefition">
                        <b-icon-plus></b-icon-plus>
                        {{__('add_new_definition','Add New Definition')}}
                    </b-button>
                    <b-button @click="close()">x</b-button>
                </b-col>
            </b-row>
        </template>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-row>
                <b-col md="3" sm="12">
                    <b-form-group :label="__('name','Name') +' *'">
                        <b-form-input v-model="form.name" :placeholder="__('name','Name')" :required="true"/>
                    </b-form-group>
                    <b-form-group :label="__('photo','Photo')">
                        <b-form-file v-model="form.photo_upload"/>
                    </b-form-group>
                    <b-form-group :label="__('description','Description')">
                        <b-form-textarea :placeholder="__('language_description','Language Description')"
                                         v-model="form.description"/>
                    </b-form-group>
                </b-col>
                <b-col md="9" sm="12">
                    <b-card body-class="p-0">
                        <b-table borderless
                                 hover
                                 small
                                 :fields="['key','value',{key:'action',thClass:'text-right',tdClass:'text-right'}]"
                                 head-variant="dark"
                                 :items="form.definitions">
                            <template v-slot:cell(key)="row">
                                <b-input size="sm"
                                         :disabled="(!!Number(row.item.is_system))"
                                         :placeholder="__('definition_key','Definition Key')"
                                         v-model="row.item.key"
                                         :required="true"/>
                            </template>
                            <template v-slot:cell(value)="row">
                                <b-input size="sm"
                                         :placeholder="__('definition_value','Definition Value')"
                                         v-model="row.item.value"
                                         :required="true"/>
                            </template>
                            <template v-slot:cell(action)="row">
                                <b-button
                                    v-if="!(!!Number(row.item.is_system))"
                                    @click="form.definitions.splice(row.index,1)"
                                    variant="danger"
                                    size="sm">
                                    <b-icon-trash/>
                                </b-button>
                            </template>
                        </b-table>
                    </b-card>
                </b-col>
            </b-row>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="hitSubmit">
                {{__('submit','SUBMIT')}}
            </b-button>
            <b-button @click="cancel()">
                {{__('cancel','CANCEL')}}
            </b-button>
        </template>
        <!--        <pre v-html="langFormats()"/>-->
        <!--        <pre v-html="form"/>-->
    </b-modal>
</template>

<script>
    import add_form from "@/partials/add_form";
    import {isArray} from "@/partials/datatable";
    // import startCase from "bootstrap-vue/esm/utils/startcase";


    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Languages.Store').url()
            }
        },
        mounted() {
            if (!isArray(this.form.definitions)) {
                this.$set(this.form, 'definitions', []);
            }
        },
        methods: {
            loadFromLanguageCollector() {
                let trans = [];
                for (let k in translation_collector) {
                    trans.push({
                        key: k,
                        value: translation_collector[k]
                    });
                }
                this.$set(this.form, 'definitions', trans)
            },
            addDefition() {
                this.form.definitions.push({
                    key: '',
                    value: ''
                });
            },
            hitSubmit() {
                if (this.$refs.theForm.reportValidity()) {
                    if (!this.form.definitions || !isArray(this.form.definitions) || this.form.definitions.length <= 0) {
                        alert("Language Definitions are required");
                        return false;
                    } else {
                        this.onSubmit(() => {
                            setTimeout(() => window.location.reload(), 1000);
                        });
                    }
                }
            }
        }
    }
</script>

