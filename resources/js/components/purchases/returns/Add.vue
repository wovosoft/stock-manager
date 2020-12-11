<template>
    <b-form @submit.prevent="handleSubmit">
        <b-form-row>
            <b-col md="12" sm="12">
                <b-form-group :label="__('supplier','Supplier')">
                    <b-input-group>
                        <vue-select
                            :init-options="true"
                            :required="true"
                            @input="(v) =>form.supplier_id = v ? v.id : null"
                            v-model="supplier"
                            :tag-text="(op)=>op ? [op.id, op.name, op.phone,op.village].join(' # '): __('not_selected', 'Not Selected')"
                            :option-text="(op)=>op ? [op.id, op.name, op.phone,op.village].join(' # '): ''"
                            :api_url="route('Backend.Suppliers.Search')">
                        </vue-select>
                        <template v-slot:append>
                            <b-button @click="supplier = null, form.supplier_id = null" class="font-weight-bold">
                                X
                            </b-button>
                        </template>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-form-row>
        <b-form-group :label="__('select_product', 'Select Product')">
            <b-input-group>
                <vue-select
                    :get-filtered="(o) => o.filter((op) => !form.items.map((i) => i.code).includes(op.code))"
                    :init-options="true"
                    ref="productSelector"
                    @input="v=>addProduct(v)"
                    v-model="product_temp"
                    :option-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                    :tag-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                    :api_url="route('Backend.Products.Search')">
                </vue-select>
            </b-input-group>
            <b-table
                head-variant="dark"
                small
                hover
                responsive
                striped
                bordered
                foot-clone
                foot-variant="light"
                show-empty
                :items="form.items"
                :fields="['product_id',
                {key:'name',label:__('name')},
                {key:'quantity',label:__('quantity')},
                {key:'amount',label:__('amount','Amount')},
                {key:'action',label:__('action'),tdClass:'text-right',thClass:'text-right'}]">
                <template #cell(quantity)="row">
                    <input type="number" class="border-0" step="any" v-model="row.item.quantity" style="width: 100px"/>
                </template>
                <template #cell(amount)="row">
                    <input type="number" class="border-0" step="any" v-model="row.item.amount" style="width: 100px"/>
                </template>


                <template #cell(action)="row">
                    <b-button size="sm" variant="danger"
                              @click="form.items.splice(row.index,1)"
                              title="Remove">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </template>

                <template #foot(amount)="row">
                    {{colSum(form.items,'amount')|currency}}
                </template>
                <template #foot(quantity)="row">
                    {{colSum(form.items,'quantity')|localNumber}}
                </template>
            </b-table>
        </b-form-group>


        <b-button block variant="dark" type="submit">SUBMIT</b-button>
        <!--        <pre v-html="form"></pre>-->
    </b-form>
</template>

<script>
    import VueSelect from "@/partials/VueSelect";
    import {colSum} from "@/partials/datatable";

    export default {
        name: "Add",
        components: {
            VueSelect
        },
        props: {
            item: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                supplier: null,
                product_temp: null,
                form: {
                    supplier_id: null,
                    items: []
                }
            }
        },
        mounted() {
            if (this.item) {
                if (!this.item.items) {
                    this.$set(this.item, 'items', []);
                }
                if (this.item.supplier_id) {
                    axios.post(route('Backend.Suppliers.GetByID', {id: this.item.supplier_id}))
                        .then(res => {
                            // console.log(res.data)
                            this.supplier = res.data;
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                }
                this.$set(this, 'form', this.item);
            }
        },
        methods: {
            colSum,
            resetForm() {
                this.supplier = null;
                this.product_temp = null;
                this.$set(this, 'form', {
                    supplier_id: null,
                    items: []
                });
            },
            addProduct(v) {
                if (!this.form.items.map(i => i.product_id).includes(v.id)) {
                    this.form.items.push({
                        name: v.name,
                        product_id: v.id,
                        amount: v.price,
                        quantity: 1
                    });
                } else {
                    let item = this.form.items.find(i => i.product_id === v.id);
                    item.quantity++;
                }
            },
            handleSubmit() {
                if (Array.isArray(this.form.items) && this.form.items.length > 0) {
                    axios
                        .post(route('Backend.PurchaseReturns.Store'), this.form)
                        .then(res => {
                            this.$root.msgBox(res.data);
                            this.resetForm();
                            this.$emit('refresh', true);
                            this.$emit('hideModal', true);
                        })
                        .catch(err => {
                            console.log(err.response);
                            this.$root.msgBox(err.response);
                        });
                }
            }
        }
    }
</script>
