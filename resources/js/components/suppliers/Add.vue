<template>
    <b-modal @hidden="()=>{hiddenCallback()}"
             v-model="visible"
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="(form.id?'Edit ':'Add ')+'Supplier'"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-row>
                <b-col sm="12" md="6">
                    <b-form-group :label="__('name','Name')">
                        <b-form-input type="text" :placeholder="__('name','Name')" v-model="form.name"/>
                    </b-form-group>
                    <b-form-group :label="__('email','Email')">
                        <b-form-input type="email"
                                      :placeholder="__('email_address','Email Address')"
                                      v-model="form.email"/>
                    </b-form-group>
                    <b-form-group :label="__('phone','Phone')">
                        <b-form-input type="tel"
                                      :placeholder="__('phone_number','Phone Number')"
                                      v-model="form.phone"/>
                    </b-form-group>
                    <b-form-group :label="__('company','Company')">
                        <b-form-input type="text" :placeholder="__('company','Company')" v-model="form.company"/>
                    </b-form-group>
                    <div v-if="form.photo">
                        <b-button
                            @click="form.photo=null"
                            style="position: absolute;right: 16px;">
                            X
                        </b-button>
                        <b-img-lazy thumbnail style="max-height: 150px;" :src="'storage/'+form.photo"/>
                    </div>
                    <b-form-group :label="__('photo','Photo')">
                        <b-input-group>
                            <b-form-file v-model="form.photo_upload"/>
                            <template v-slot:append>
                                <b-button @click="form.photo_upload=null">X</b-button>
                            </template>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col sm="12" md="6">
                    <b-form-group :label="__('district','District')">
                        <b-form-select
                            text-field="name"
                            value-field="name"
                            :options="districts"
                            v-model="form.district"
                        />
                    </b-form-group>
                    <b-form-group :label="__('thana','Thana')">
                        <b-form-input type="text"
                                      :placeholder="__('thana','Thana')" v-model="form.thana"/>
                    </b-form-group>
                    <b-form-group :label="__('post_office','Post Office')">
                        <b-form-input type="text"
                                      :placeholder="__('post_office','Post Office')"
                                      v-model="form.post_office"/>
                    </b-form-group>
                    <b-form-group :label="__('village','Village')">
                        <b-form-input type="text" :placeholder="__('village','Village')" v-model="form.village"/>
                    </b-form-group>
                    <b-form-group :label="__('shipping_address','Shipping Address')">
                        <b-form-textarea v-model="form.shipping_address"
                                         placeholder="Shipping Address"/>
                    </b-form-group>
                </b-col>
            </b-row>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn"
                      @click="()=>{if($refs.theForm.reportValidity()){onSubmit();}}">
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
    import {slugify, objPhotoUrl} from "@/partials/datatable";
    import districts from '@/shared/districts';

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Suppliers.Store')
            },
            hiddenCallback: {
                type: Function,
                default: function () {
                    this.$router.go(-1);
                    this.$emit('reset', true);
                }
            },

            visibility: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                districts
            }
        },
        methods: {
            slugify,
            objPhotoUrl
        },
        created() {
            this.visible = this.visibility;
        },
        watch: {
            "visibility"(value) {
                this.visible = value;
            }
        }
    }
</script>

