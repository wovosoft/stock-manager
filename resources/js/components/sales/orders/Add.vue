<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true),$emit('refreshDatatable',true)"
             visible
             hide-footer
             v-bind="{...BasicModalOptions,size:'xl'}"
             :title="__((form.id?'edit':'add')+'_order',(form.id?'Edit ':'Add ')+'Order')">
        <template #default="{hide}">
            <b-form @submit.prevent="handleSubmit(hide)">
                <b-form-group :label="__('select_customer','Select Customer')" label-cols-md="4">
                    <vue-select
                        :init-options="true"
                        :required="true"
                        @input="(v) =>  {
                            form.customer_id=v ? v.id : null;
                            form.previous_balance=v?v.balance:0;
                        }"
                        v-model="temp_customer"
                        :tag-text="(op) =>op? [op.id, op.name, op.phone, op.village].join(' # '): __('note_selected','Not Selected')"
                        :option-text="(op) =>op? [op.id, op.name, op.phone, op.village].join(' # '): __('note_selected','Not Selected')"
                        :api_url="route('Backend.Customers.Search')"
                    />
                </b-form-group>
                <b-form-group class="mb-1" :label="__('select_products','Select Products')" label-cols-md="4">
                    <vue-select
                        :get-filtered="(o) =>o.filter((op) => !form.items.map((i) => i.code).includes(op.code))"
                        :init-options="true"
                        ref="productSelector"
                        @input="addProductToCart"
                        v-model="product_temp"
                        :option-text="(op) =>op ? [op.id, op.name, op.code].join(' # ') :  __('note_selected','Not Selected')"
                        :tag-text="(op) =>op ? [op.id, op.name, op.code].join(' # ') :  __('note_selected','Not Selected')"
                        :api_url="route('Backend.Products.Search')"
                    />
                </b-form-group>
                <b-table
                    responsive
                    bordered
                    small
                    hover
                    striped
                    head-variant="dark"
                    :fields="item_fields"
                    :items="form.items"
                >
                    <template #cell(action)="row">
                        <b-button variant="danger"
                                  size="sm"
                                  :title="__('remove','Remove')"
                                  @click="form.items.splice(row.index,1)">
                            <b-icon-trash/>
                        </b-button>
                    </template>
                    <template #cell(quantity)="row">
                        <b-input type="number"
                                 v-model="row.item.quantity"
                                 :placeholder="__('item_quantity','Item Quantity')"
                                 size="sm"
                                 step="any"
                                 :required="true"/>
                    </template>
                    <template #cell(price)="row">
                        <b-input type="number"
                                 v-model="row.item.price"
                                 :placeholder="__('item_price','Item Price')"
                                 size="sm"
                                 step="any"
                                 :required="true"/>
                    </template>
                    <template #cell(total)="row">
                        {{((Number(row.item.quantity) * Number(row.item.price)))|currency}}
                    </template>
                </b-table>
                <b-form-row>
                    <b-col md="12" sm="12">
                        <b-form-group label-cols-md="4" :label="__('total','Total')">
                            <div class="form-control">{{total|currency}}</div>
                        </b-form-group>
                        <b-form-group label-cols-md="4" :label="__('previous_balance','Previous Balance')">
                            <div class="form-control">{{form.previous_balance|currency}}</div>
                        </b-form-group>
                        <b-form-group :label="__('cash_collection','Cash Collection')" label-cols-md="4">
                            <b-input lang="bn" type="number" step="any" v-model="form.paid"/>
                        </b-form-group>
                        <b-form-group label-cols-md="4" :label="__('current_balance','Current Balance')">
                            <div class="form-control">{{currentBalance|currency}}</div>
                        </b-form-group>
                        <b-form-group label-cols-md="4" :label="__('note','Note')">
                            <b-textarea v-model="form.note" :placeholder="__('note','Note')"></b-textarea>
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-button type="submit" block variant="dark">
                    {{__('SUBMIT')}}
                </b-button>
            </b-form>
        </template>

        <!--        <pre v-html="form"/>-->
    </b-modal>
</template>
<script>
    import {BasicModalOptions} from "@/partials/datatable";
    import VueSelect from "@/partials/VueSelect";

    const the_form = {
        customer_id: null,
        previous_balance: 0,
        paid: 0,
        total: 0,
        items: [],
        note: null
    };
    export default {
        components: {
            VueSelect
        },
        props: {
            item: {
                type: Object,
                default: () => null
            }
        },
        data() {
            return {
                BasicModalOptions,
                temp_customer: null,
                product_temp: null,
                form: JSON.parse(JSON.stringify(the_form)),
                item_fields: [
                    {key: "action", label: _t('action', 'Action')},
                    {
                        key: "name",
                        label: _t('name', 'Name'),
                        formatter: (k, d, r) => {
                            return [r.product_id, r.name, r.code].join(" # ");
                        },
                    },
                    {
                        key: "price", label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: "quantity", label: _t('quantity', 'Quantity'),
                        formatter: v => this.$options.filters.localNumber(v)
                    },
                    {
                        key: 'total', label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                ],
            };
        },
        mounted() {
            if (this.item && Object.keys(this.item).length) {
                this.setData(JSON.parse(JSON.stringify(this.item)));
            } else if (!this.the_item || !Object.keys(this.item).length) {
                axios.post(route('Backend.Orders.List'), {
                    id: this.$route.params.id
                }).then(res => {
                    this.setData(res.data);
                }).catch(err => console.log(err.response));
            }
        },
        computed: {
            total() {
                if (!this.form.items.length) {
                    return 0;
                }
                let sum = 0;
                this.form.items.forEach(item => {
                    sum += item.price * item.quantity;
                });
                return sum;
            },
            currentBalance() {
                return Number(this.total) + Number(this.form.previous_balance) - Number(this.form.paid);
            }
        },
        methods: {
            setData(data) {
                this.form.id = data.id;
                this.form.customer_id = data.customer_id;
                this.form.total = data.total;
                this.form.paid = data.paid;
                this.form.status = data.status;
                this.form.note = data.note;
                this.$set(this, 'temp_customer', data.customer);
                if (data.items) {
                    let the = this;
                    data.items.forEach(function (item) {
                        the.form.items.push({
                            id: item.id,
                            product_id: item.product_id,
                            price: item.price || 0,
                            quantity: item.quantity,
                            code: item.product.code,
                            name: item.product.name,
                        });
                    });
                }
            },
            handleSubmit(callback = null) {
                if (!this.form || !this.form.items || !this.form.items.length) {
                    alert(this._t('Please Select Items'));
                    return false;
                }
                axios
                    .post(route('Backend.Orders.Store'), this.form)
                    .then(res => {
                        this.$root.msgBox(res.data);
                        this.$set(this, 'form', JSON.parse(JSON.stringify(the_form)));
                        this.temp_customer = null;
                        this.product_temp = null;
                        if (typeof callback === 'function') {
                            callback();
                        }
                    })
                    .catch(err => {
                        this.$root.msgBox(err.response.data);
                        console.log(err.response);
                    });
            },
            addProductToCart(v) {
                let items = JSON.parse(JSON.stringify(this.form.items));
                let found = items.find((i) => i.code === v.code);
                if (found) {
                    found.quantity++;
                } else {
                    items.push({
                        product_id: v.id,
                        price: v.price || 0,
                        quantity: 1,
                        code: v.code,
                        name: v.name,
                    });
                }

                //UI not updating, so doing it here manually
                this.$set(this, "product_temp", null);
                this.$set(this.form, "items", items);
            },
        },
    };
</script>


