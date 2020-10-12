<template>
    <div>
        <form @submit.prevent="handleSubmit" ref="theForm">
            <b-card footer-class="p-1">
                <b-form-row>
                    <b-col sm="12" md="7">
                        <b-form-group :label="__('supplier','Supplier')">
                            <b-input-group>
                                <vue-select
                                    :required="true"
                                    @input="v=>form.supplier_id=v?v.id:null"
                                    v-model="form.supplier"
                                    :api_url="route('Backend.Suppliers.Search').url()">
                                    <template v-slot:option="op">
                                        {{[op.item.id,op.item.name,op.item.phone].join(' # ')}}
                                    </template>
                                    <template v-slot:tag="op">
                                        {{op.tag?[op.tag.id,op.tag.name,op.tag.phone].join(' # ')
                                        :__('not_selected','Not Selected')}}
                                    </template>
                                </vue-select>
                                <template v-slot:append>
                                    <b-button @click="form.supplier=null,form.supplier_id=null">Reset</b-button>
                                    <b-button @click="supplier_add_modal_visibility=true" variant="dark">Add</b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>
                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('date','Date')">
                                    <b-form-input type="date" v-model="form.date"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('status','Status')">
                                    <b-form-select
                                        :required="true"
                                        v-model="form.status"
                                        :options="statuses"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-form-row>
                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('payment_amount','Payment Amount')">
                                    <b-input-group>
                                        <b-input
                                            step="any"
                                            type="number"
                                            :placeholder="__('payment_amount','Payment Amount')"
                                            :required="true"
                                            v-model="form.payment_amount"
                                        />
                                        <template v-slot:append>
                                            <b-button @click="form.payment_amount=getPayable">
                                                {{__('full','Full')}}
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('payment_method','Payment Method')">
                                    <b-form-select
                                        v-model="form.payment_method"
                                        :options="payment_options"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-form-row>
                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('tax','Tax')">
                                    <b-input-group append="%">
                                        <b-form-input
                                            :required="true"
                                            type="number"
                                            step="any"
                                            :placeholder="__('tax','Tax')"
                                            v-model="form.tax"/>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('discount','Discount')">
                                    <b-input-group append="%">
                                        <b-form-input
                                            :required="true"
                                            type="number"
                                            step="any"
                                            :placeholder="__('discount','Discount')"
                                            v-model="form.discount"/>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-form-row>
                    </b-col>
                    <b-col sm="12" md="5">
                        <table class="table table-sm table-bordered table-hover">
                            <tr>
                                <th colspan="2" class="text-center bg-dark text-light">
                                    {{__('cart_details','Cart Details')}}
                                </th>
                            </tr>
                            <tr>
                                <th>{{__('total','Total')}}</th>
                                <td>{{getTotal|currency}}</td>
                            </tr>
                            <tr>
                                <th>{{__('tax','Tax')}}</th>
                                <td>{{(getTotal*form.tax/100) | currency}}</td>
                            </tr>
                            <tr>
                                <th>{{__('discount','Discount')}}</th>
                                <td>{{(getTotal*form.discount/100) | currency}}</td>
                            </tr>
                            <tr>
                                <th>{{__('payable','Payable')}}</th>
                                <td>{{getPayable | currency}}</td>
                            </tr>
                        </table>
                        <b-form-group :label="__('note','Note')">
                            <b-form-textarea
                                :rows="4"
                                :placeholder="__('purchase_note','Purchase Note')"
                                v-model="form.note"/>
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col>
                        <b-form-group :label="__('select_product','Select Product')">
                            <vue-select
                                ref="productSelector"
                                @input="addProductToCart"
                                v-model="form.product_temp"
                                :api_url="route('Backend.Products.Search').url()">
                                <template v-slot:option="op">
                                    {{[op.item.id,op.item.name,op.item.code].join(' # ')}}
                                </template>
                                <template v-slot:tag="op">
                                    {{op.tag?[op.tag.id,op.tag.name,op.item.code].join(' # ')
                                    :__('not_selected','Not Selected')}}
                                </template>
                            </vue-select>
                            <b-table
                                bordered
                                small
                                hover
                                striped
                                head-variant="dark"
                                :fields="[
                                {key:'product_id',label:__('pid','PID')},
                                {key:'name',label:__('name','Name')},
                                {key:'code',label:__('code','Code')},
                                {key:'price',label:__('price','Price')},
                                {key:'quantity',label:__('quantity','Quantity')},
                                {key:'total',label:__('total','Total')},
                                {key:'tax',label:__('tax','Tax')},
                                {key:'discount',label:__('discount','Discount')},
                                {key:'payable',label:__('payable','Payable')},
                                {key:'action',label:__('action','Action')}
                             ]"
                                :items="form.items">
                                <template v-slot:cell(price)="row">
                                    <b-input-group size="sm" :append="$options.filters.currencySymbol(0)">
                                        <b-input
                                            type="number"
                                            step="any"
                                            v-model="row.item.price"
                                            :placeholder="__('price','Price')"
                                            :required="true"
                                        />
                                    </b-input-group>
                                </template>
                                <template v-slot:cell(quantity)="row">
                                    <b-input
                                        type="number"
                                        step="any"
                                        v-model="row.item.quantity"
                                        :placeholder="__('quantity','Quantity')"
                                        :required="true"
                                        size="sm"
                                    />
                                </template>
                                <template v-slot:cell(total)="row">
                                    {{(row.item.quantity*row.item.price) | currency}}
                                </template>
                                <template v-slot:cell(tax)="row">
                                    <b-input-group append="%" size="sm">
                                        <b-input
                                            type="number"
                                            step="any"
                                            v-model="row.item.tax"
                                            :placeholder="__('tax','Tax')"
                                            :required="true"
                                        />
                                    </b-input-group>
                                </template>
                                <template v-slot:cell(discount)="row">
                                    <b-input-group append="%" size="sm">
                                        <b-input
                                            type="number"
                                            step="any"
                                            v-model="row.item.discount"
                                            :placeholder="__('discount','Discount')"
                                            :required="true"
                                        />
                                    </b-input-group>
                                </template>
                                <template v-slot:cell(payable)="row">
                                    {{getItemPayable(row.item) | currency}}
                                </template>
                                <template v-slot:cell(action)="row">
                                    <b-button size="sm" variant="danger" @click="removeCartItem(row)">
                                        <b-icon-trash/>
                                    </b-button>
                                </template>
                            </b-table>
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <template v-slot:footer>
                    <b-button type="submit" block variant="dark">
                        {{__('submit','SUBMIT')}}
                    </b-button>
                </template>
            </b-card>

            <!--        <pre v-html="form"></pre>-->
        </form>
        <suppliers-add :visibility="supplier_add_modal_visibility"
                       @created="v=>{form.supplier=v.item;form.supplier_id=v.id}"
                       :hidden-callback="()=>{supplier_add_modal_visibility=false}"/>
    </div>
</template>

<script>
    import add_form from "@/partials/add_form";
    import {slugify, objPhotoUrl, isArray} from "@/partials/datatable";
    import VueSelect from "@/partials/VueSelect";
    import dayjs from "dayjs";
    import payment_options from "@/shared/payment_options";
    import statuses from "@/shared/statuses";
    import SuppliersAdd from "@/components/suppliers/Add";

    export default {
        mixins: [add_form],
        components: {VueSelect, SuppliersAdd},
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Purchases.Store').url()
            },
            payment_options: {
                type: Array,
                default: () => payment_options
            },
            statuses: {
                type: Array,
                default: () => statuses
            }
        },
        mounted() {
            this.$set(this, 'form', {
                items: [],
                date: dayjs().format('YYYY-MM-DD'),
                status: "Processed",
                tax: 0,
                discount: 0,
                Supplier: null,
                payment_method: 'Cash',
                payment_amount: 0
            });
        },
        computed: {
            getTotal() {
                let total = 0;
                for (let x in this.form.items) {
                    total += this.getItemPayable(this.form.items[x]);
                }
                return total;
            },
            getPayable() {
                return this.getTotal * (1 + this.form.tax / 100 - this.form.discount / 100);
            }
        },
        data() {
            return {
                supplier_add_modal_visibility: false
            }
        },
        methods: {
            handleSubmit() {
                if (this.$refs.theForm.reportValidity()) {
                    if (!(isArray(this.form.items) && this.form.items.length > 0)) {
                        alert("Please Select Items First");
                        this.$refs.productSelector.$el.querySelector('button').click();
                        return false;
                    }
                    this.onSubmit();
                }
            },
            slugify,
            objPhotoUrl,
            addProductToCart(v) {
                let items = JSON.parse(JSON.stringify(this.form.items));
                items.push({
                    product_id: v.id,
                    price: v.price,
                    quantity: 1,
                    code: v.code,
                    name: v.name,
                    tax: v.tax || 0,
                    discount: v.discount || 0
                });
                //UI not updating, so doing it here manually
                this.$set(this.form, 'product_temp', null);
                this.$set(this.form, 'items', items);
            },
            getItemPayable(row) {
                let total = row.quantity * row.price;
                return total * (1 - Number(row.discount) / 100 + Number(row.tax) / 100);
            },
            removeCartItem(row) {
                if (confirm("Are You Sure?")) {
                    this.form.items.splice(row.index, 1);
                }
            }
        }
    }
</script>

