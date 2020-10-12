<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             size="lg"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             @shown="()=>{
                 if (!form.type){
                     $set(form,'type','text');
                 }
             }"
             :title="__((form.id?'edit':'add')+'_sms',(form.id?'Edit ':'Add ')+'SMS')"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-group>
                <b-select
                    v-model="form.type"
                    :options="[
                        {text:__('unicode_for_bangla','Unicode For Bangla'),value:'unicode'},
                        {text:__('text_for_english','Text for English'),value:'text'}
                    ]"
                />
            </b-form-group>
            <b-form-group :label="__('contacts','Contacts')+' *'">
                <b-form-tags
                    v-model="form.contacts"
                    :required="true"
                    input-type="number"
                    remove-on-delete
                    :input-attrs="{max:8801999999999,maxLength:13}"
                    :state="Array.isArray(form.contacts) && form.contacts.length>0"
                    :tag-validator="isValidNumber"
                    :placeholder="__('contacts','Contacts')"/>
                <b-form-invalid-feedback
                    :state="Array.isArray(form.contacts) && form.contacts.length>0">Contacts
                    Required
                </b-form-invalid-feedback>
                <b-form-text class="font-weight-bold">
                    <ol class="ml-3 p-0">
                        <li>Type a valild number and hit enter.</li>
                        <li>Enter Numbers with country code.</li>
                        <li>Numbers must be in english.</li>
                        <li>Use Comma (,) to separate numbers.</li>
                    </ol>
                    Eg. 8801711111111, 8801511111112, 8801911111114
                </b-form-text>
            </b-form-group>
            <b-form-group :label="__('message','Message')">
                <b-textarea
                    :required="true"
                    :placeholder="__('message','Message')"
                    v-model="form.message"/>
            </b-form-group>
            <b-form-checkbox switch v-if="form.id" v-model="form.resend">Resend?</b-form-checkbox>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn"
                      @click="()=>{
                          if(!(Array.isArray(form.contacts) && form.contacts.length>0)){
                              return false;
                          }
                          onSubmit();
                      }">
                {{__('submit','SUBMIT')}}
            </b-button>
            <b-button @click="cancel()">
                {{__('cancel','CANCEL')}}
            </b-button>
        </template>
        <!--                <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import {slugify, objPhotoUrl} from "@/partials/datatable";

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.SMS.Store').url()
            }
        },
        methods: {
            slugify,
            objPhotoUrl,
            isValidNumber(num) {
                return num.toString().match(/^(?:8801[3-9]\d{8})$/);
            }
        }
    }
</script>

