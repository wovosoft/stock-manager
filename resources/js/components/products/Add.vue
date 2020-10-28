<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             @shown="initForm"
             size="xl"
             no-close-on-backdrop
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__((form.id?'edit':'add')+'_product',(form.id?'Edit ':'Add ')+'Product')"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-row>
                <b-col>
                    <b-form-group :label="__('name','Name') +'*'">
                        <b-form-input v-model="form.name" :placeholder="__('name','Name')" :required="true"/>
                    </b-form-group>
                    <!--
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('barcode_symboloy','Barcode Symbology')">
                                <b-form-select
                                    v-model="form.barcode_symbology"
                                    :options="barcode_symbologies"/>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12">

                        </b-col>
                    </b-form-row>
                    -->
                    <b-form-group :label="__('code','Code')+' *'">
                        <b-form-input
                            :required="true"
                            type="text" v-model="form.code"
                            :placeholder="__('code_barcode_sku_upc_isbn','Code (Barcode/SKU/UPC/ISBN)')"/>
                    </b-form-group>
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('cost','Cost')+' *'">
                                <b-input type="number"
                                         step="any"
                                         v-model="form.cost"
                                         :required="true"
                                         :placeholder="__('product_buying_cost','Product Buying Cost')"/>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('price','Price')+' *'">
                                <b-input type="number"
                                         step="any"
                                         v-model="form.price"
                                         :required="true"
                                         :placeholder="__('product_selling_price','Product Selling Price')"/>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('quantity','Quantity')">
                                <b-form-input
                                    :disabled="true"
                                    type="number"
                                    step="any"
                                    :placeholder="__('product_quantity','Product Quantity')"
                                    v-model="form.quantity"/>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('alert_quantity','Alert Quantity')">
                                <b-form-input
                                    type="number"
                                    step="any"
                                    :placeholder="__('product_alert_quantity','Product Alert Quantity')"
                                    v-model="form.alert_quantity"/>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                </b-col>
                <b-col>
                    <b-form-row>
                        <!--                        <b-col>-->
                        <!--                            <b-form-group :label="__('status','Status')">-->
                        <!--                                <b-form-select-->
                        <!--                                    v-model="form.status"-->
                        <!--                                    :options="[-->
                        <!--                                {text:'Active',value:1},-->
                        <!--                                {text: 'Inactive',value: 0}-->
                        <!--                            ]"/>-->
                        <!--                            </b-form-group>-->
                        <!--                        </b-col>-->
                        <b-col>
                            <b-form-group>
                                <template v-slot:label>
                                    {{__('photo','Photo')}}
                                    <a v-if="form.photo_url" target="_blank" :href="form.photo_url">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </template>
                                <b-input-group>
                                    <b-form-file v-model="form.photo_upload"></b-form-file>
                                    <template v-slot:append>
                                        <b-button
                                            @click="form.photo=null,form.photo_upload=null,form.photo_url=null"
                                            :title="__('reset','Reset')">
                                            x
                                        </b-button>
                                    </template>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                    <b-form-row>
                        <b-col md="12" sm="12">
                            <b-form-group :label="__('category','Category')">
                                <b-input-group>
                                    <vue-select
                                        @input="v=>{form.category_id=v?v.id:null;form.subcategory_id=null}"
                                        v-model="form.category"
                                        :api_url="route('Backend.Categories.Search').url()">
                                        <template v-slot:option="op">
                                            {{[op.item.id,op.item.name].join(' # ')}}
                                        </template>
                                        <template v-slot:tag="op">
                                            {{op.tag?[op.tag.id,op.tag.name].join(' # ')
                                            :'Not Selected'}}
                                        </template>
                                    </vue-select>
                                    <template v-slot:append>
                                        <b-button @click="form.category=null,form.category_id=null">x</b-button>
                                    </template>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="12" sm="12" v-if="form.category">
                            <b-form-group :label="__('sub_category','Subcategory')">
                                <b-input-group>
                                    <b-form-select
                                        :options="form.category.subcategories"
                                        text-field="name"
                                        value-field="id"
                                        v-model="form.subcategory_id"/>
                                    <template v-slot:append>
                                        <b-button @click="$set(form,'subcategory_id',null)">x</b-button>
                                    </template>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                    <b-form-row>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('brand','Brand')">
                                <b-input-group>
                                    <vue-select
                                        @input="v=>{form.brand_id=v?v.id:null}"
                                        v-model="form.brand"
                                        :api_url="route('Backend.Brands.Search').url()">
                                        <template v-slot:option="op">
                                            {{[op.item.id,op.item.name].join(' # ')}}
                                        </template>
                                        <template v-slot:tag="op">
                                            {{op.tag?[op.tag.id,op.tag.name].join(' # ')
                                            :__('not_selected','Not Selected')}}
                                        </template>
                                    </vue-select>
                                    <template v-slot:append>
                                        <b-button @click="form.brand=null,form.brand_id=null">x</b-button>
                                    </template>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12">
                            <b-form-group :label="__('unit','Unit')">
                                <b-form-select :options="units" v-model="form.unit_id"></b-form-select>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                </b-col>
            </b-form-row>

            <b-form-group :label="__('description','Description')">
                <b-form-textarea :placeholder="__('product_description','Product Description')"
                                 v-model="form.description"/>
            </b-form-group>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="onSubmit">
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
    import VueSelect from "@/partials/VueSelect";
    import barcode_symbologies from "@/shared/barcode_symbologies";

    export default {
        mixins: [add_form],
        components: {
            VueSelect
        },
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Products.Store').url()
            }
        },
        methods: {
            slugify,
            objPhotoUrl,
            initForm() {
                if (!this.form.cost) {
                    this.$set(this.form, 'cost', 0);
                }
                if (!this.form.price) {
                    this.$set(this.form, 'price', 0);
                }
                if (!this.form.unit_id) {
                    this.$set(this.form, 'unit_id', this.units[0].value);
                }
                if (!this.form.barcode_symbology) {
                    this.$set(this.form, 'barcode_symbology', "code128");
                }
                if (!(this.form.status === 0 || this.form.status === 1)) {
                    this.$set(this.form, 'status', 1);
                }

            }
        },
        data() {
            return {
                barcode_symbologies,
                categories: [],
                subcategories: [],
                units: []
            }
        },
        mounted() {
            axios.post(route('Backend.Products.Get.Category.Unit').url())
                .then(res => {
                    this.categories = res.data.categories;
                    this.units = res.data.units;
                })
                .catch(err => console.log(err.response));
        },
    }
</script>

