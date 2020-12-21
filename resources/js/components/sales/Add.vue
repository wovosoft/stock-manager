<template>
    <div>
        <b-form-row>
            <b-col sm="12" md="6">
                <b-card body-class="p-2" class="h-100">
                    <b-form @submit.prevent="handleSubmit" ref="theForm">
                        <b-form-group :label="__('customer', 'Customer')" label-cols-md="4">
                            <b-input-group>
                                <vue-select
                                    size="md"
                                    :init-options="true"
                                    :required="true"
                                    @input="(v) => {
                                        (form.customer_id = v ? v.id : null);
                                        customer_balance=v?v.balance:0;
                                    }"
                                    v-model="form.customer"
                                    :tag-text="(op)=>op ? [op.id, op.name].join(' # '): __('not_selected', 'Not Selected')"
                                    :option-text="(op)=>op ? [op.id, op.name,op.village].join(' # '): ''"
                                    :api_url="route('Backend.Customers.Search')">
                                </vue-select>
                                <template v-slot:append>
                                    <b-button
                                        @click="(form.customer = null), (form.customer_id = null),customer_balance=0"
                                        class="font-weight-bold">
                                        X
                                    </b-button>
                                    <b-button @click="customer_add_modal_visible = true" variant="dark">
                                        <i class="fa fa-plus"></i>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>

                        <b-form-group class="mb-1" :label="__('select_product', 'Select Product')" label-cols-md="4">
                            <vue-select
                                size="md"
                                :get-filtered="(o) => o.filter((op) => !form.items.map((i) => i.code).includes(op.code))"
                                :init-options="true"
                                ref="productSelector"
                                @input="v=>{addProductToCart(v);$set(form,'product_temp',null);}"
                                v-model="form.product_temp"
                                :option-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                                :tag-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                                :api_url="route('Backend.Products.Search')">
                            </vue-select>
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
                            <template v-slot:cell(price)="row">
                                <b-input-group style="min-width: 200px;" size="sm"
                                               :append="$options.filters.currencySymbol(0)">
                                    <b-input type="number" step="any" v-model="row.item.price"

                                             :placeholder="__('sales.price', 'Price')" :required="true"/>
                                </b-input-group>
                            </template>
                            <template v-slot:cell(quantity)="row">
                                <b-input type="number" step="any" v-model="row.item.quantity"
                                         style="min-width: 50px;"
                                         :placeholder="__('quantity', 'Quantity')" :required="true" size="sm"/>
                            </template>
                            <template v-slot:cell(total)="row">
                                {{ (row.item.quantity * row.item.price) | currency }}
                            </template>
                            <template v-slot:cell(tax)="row">
                                <b-input-group append="%" size="sm">
                                    <b-input
                                        type="number" step="any" v-model="row.item.tax"
                                        :placeholder="__('tax', 'Tax')" :required="true"/>
                                </b-input-group>
                            </template>
                            <template v-slot:cell(discount)="row">
                                <b-input-group append="%" size="sm">
                                    <b-input
                                        type="number" step="any" v-model="row.item.discount"
                                        :placeholder="__('discount', 'Discount')" :required="true"/>
                                </b-input-group>
                            </template>
                            <template v-slot:cell(payable)="row">
                                {{ getItemPayable(row.item) | currency }}
                            </template>
                            <template v-slot:cell(action)="row">
                                <b-button size="sm" @click="removeCartItem(row)">
                                    <b-icon-trash/>
                                </b-button>
                            </template>
                            <template #custom-foot>
                                <b-tr>
                                    <b-td :colspan="3" class="text-right font-weight-bold">
                                        {{ __("price", "Price") }}
                                    </b-td>
                                    <b-td :colspan="4" class="text-right font-weight-bold">
                                        {{ getPayable | currency }}
                                    </b-td>
                                </b-tr>
                                <b-tr>
                                    <b-td :colspan="3" class="text-right font-weight-bold">
                                        {{ __('previous_balance', 'Previous Balance') }}
                                    </b-td>
                                    <b-td :colspan="4" class="text-right font-weight-bold">
                                        {{customer_balance|currency}}
                                    </b-td>
                                </b-tr>
                                <b-tr>
                                    <b-td :colspan="3" class="text-right font-weight-bold">
                                        {{ __('total', 'Total') }}
                                    </b-td>
                                    <b-td :colspan="4" class="text-right font-weight-bold">
                                        {{(Number(customer_balance) + Number(getPayable))|currency}}
                                    </b-td>
                                </b-tr>
                            </template>
                        </b-table>

                        <b-form-row>
                            <b-col md="6" sm="12">
                                <b-form-group :label="__('payment_method', 'Payment Method')">
                                    <b-form-select v-model="form.payment_method" :options="payment_options"/>
                                </b-form-group>
                            </b-col>

                            <b-col md="6" sm="12">
                                <b-form-group :label="__('sales.payment_amount', 'Payment Amount')">
                                    <b-input-group>
                                        <b-input
                                            step="any" type="number"
                                            :placeholder="__('sales.payment_amount', 'Payment Amount')" :required="true"
                                            v-model="form.payment_amount"/>
                                        <template #append>
                                            <b-button variant="dark"
                                                      @click="form.payment_amount = (Number(getPayable) + Number(customer_balance))">
                                                {{ __("full", "Full") }}
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>

                        </b-form-row>
                        <b-form-row>
                            <b-col md="6" sm="12">
                                <b-form-group :label="__('date', 'Date')">
                                    <b-form-input type="date" v-model="form.date"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" sm="12">
                                <b-form-group :label="__('current_balance', 'Current Balance')">
                                    <div class="form-control">
                                        {{(Number(customer_balance) + Number(getPayable) - Number(form.payment_amount))
                                        |currency}}
                                    </div>
                                </b-form-group>
                            </b-col>
                            <!--                            <b-col>-->
                            <!--                                <b-form-group label="Status">-->
                            <!--                                    <b-form-select :required="true" v-model="form.status" :options="statuses"/>-->
                            <!--                                </b-form-group>-->
                            <!--                            </b-col>-->
                        </b-form-row>

                        <b-form-group :label="__('note', 'Note')">
                            <b-form-textarea :rows="4" :placeholder="__('sales_note', 'Sales Note')"
                                             v-model="form.note"/>
                        </b-form-group>
                        <b-button type="submit" block variant="dark" :disabled="submit_disabled">
                            {{ __("submit", "SUBMIT") }}
                        </b-button>
                    </b-form>
                </b-card>
            </b-col>
            <b-col sm="12" md="6">
                <b-card
                    class="h-100"
                    body-class="p-2 mh-60vh overflow-auto"
                    header-class="px-2">
                    <template #header>
                        <b-form-group :label="__('select_category', 'Select Category')" label-cols-md="4">
                            <b-input-group>
                                <template #append>
                                    <b-button @click="search_category = null">x</b-button>
                                </template>
                                <vue-select
                                    size="md"
                                    v-model="search_category"
                                    :init-options="true"
                                    :option-text="(op) => [op.id, op.name, op.code].join(' # ')"
                                    :tag-text="(op) =>op? [op.id, op.name, op.code].join(' # '): __('not_selected', 'Not Selected')"
                                    :api_url="route('Backend.Categories.Search')"
                                >
                                </vue-select>
                            </b-input-group>
                        </b-form-group>
                    </template>
                    <b-form-row>
                        <b-col md="4" sm="6" v-for="(si, si_key) in searched_items.data" class="mb-2" :key="si_key">
                            <b-card class="h-100"
                                    @click="addProductToCart(si)"
                                    body-class="text-white product-image"
                                    :title="si.name"
                                    :style="{backgroundImage:'url('+si.photo_url+')'}"
                                    style="background-size: cover;cursor: pointer;">
                                <table>
                                    <tr>
                                        <td>{{ __("code", "Code") }}</td>
                                        <td>: {{ si.code }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __("price", "Price") }}</td>
                                        <td>: {{ si.price | currency }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __("quantity", "Quantity") }}</td>
                                        <td>: {{ si.quantity | localNumber }}</td>
                                    </tr>
                                </table>
                            </b-card>
                        </b-col>
                    </b-form-row>
                    <template #footer>
                        <b-row>
                            <b-col>
                                {{__('total','Total')}} : {{searched_items.total | localNumber}}
                                {{__('items','Items')}},
                                {{__('page','Page')}} : {{searched_items.current_page | localNumber}}/
                                {{searched_items.last_page | localNumber}}
                            </b-col>
                            <b-col class="text-right">
                                <b-button
                                    v-if="searched_items.prev_page_url"
                                    @click="getCatProducts(searched_items.prev_page_url)"
                                    variant="dark" size="sm">
                                    <i class="fa fa-angle-double-left"></i>
                                    {{__('previous','Previous')}}
                                </b-button>
                                <b-button
                                    v-if="searched_items.next_page_url"
                                    @click="getCatProducts(searched_items.next_page_url)"
                                    variant="dark" size="sm">
                                    {{__('next','Next')}}
                                    <i class="fa fa-angle-double-right"></i>
                                </b-button>
                            </b-col>
                        </b-row>
                    </template>
                </b-card>
            </b-col>
        </b-form-row>
        <!--        <pre v-html="form"></pre>-->
        <customer-add
            :visibility="customer_add_modal_visible"
            @created=" (v) => {
                $set(form,'customer',v.item);
                $set(form,'customer_id',v.item.id);
            }"
            :hidden-callback="() => {customer_add_modal_visible = false;}"
        />
        <b-modal
            size="xl"
            body-class="p-0"
            header-bg-variant="dark"
            header-text-variant="light"
            footer-bg-variant="dark"
            footer-text-variant="light"
            :title="__('sale_invoice','Sale Invoice')"
            id="invoice-modal"
            lazy
            no-close-on-backdrop
            @hidden="sale_id=null">
            <b-embed
                v-if="sale_id"
                id="print_invoice"
                aspect="16by9"
                allowfullscreen
                :src="route('Backend.Sales.Invoice.PDF',{sale:sale_id,type:'html',invoice_both:'yes'})"/>
            <template v-slot:modal-footer="{close}">
                <b-button
                    size="sm"
                    :href="route('Backend.Sales.Invoice.PDF',{sale:sale_id,type:'html',invoice_both:'no',auto_print:true})"
                    target="_blank"
                    variant="primary">
                    <i class="fa fa-file-pdf"></i>
                    {{__('cash_invoice','Cash Invoice')}}
                </b-button>
                <b-button
                    size="sm"
                    :href="route('Backend.Sales.Invoice.PDF',{sale:sale_id,type:'html',is_delivery:'yes',auto_print:true})"
                    target="_blank"
                    variant="primary">
                    <i class="fa fa-file-pdf"></i>
                    {{__('delivery_slip','Delivery Slip')}}
                </b-button>
                <b-button
                    size="sm"
                    :href="route('Backend.Sales.Invoice.PDF',{sale:sale_id,type:'html',invoice_both:'yes',auto_print:true})"
                    target="_blank"
                    variant="primary">
                    <i class="fa fa-file-pdf"></i>
                    {{__('cash_and_delivery_memo','Cash & Delivery')}}
                </b-button>
                <b-button size="sm" @click="printInvoice" variant="primary">
                    <i class="fa fa-print"></i>
                    {{__('print','Print')}}
                </b-button>
                <b-button size="sm" @click="close" variant="secondary">Close</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import add_form from "@/partials/add_form";
    import {slugify, objPhotoUrl, isArray} from "@/partials/datatable";
    import VueSelect from "@/partials/VueSelect";
    import dayjs from "dayjs";
    import payment_options from "@/shared/payment_options";
    import statuses from "@/shared/statuses";
    import CustomerAdd from "@/components/customers/Add";
    import Invoice from "@/components/sales/Invoice";
    import {colSum} from "@/partials/datatable";

    export default {
        mixins: [add_form],
        components: {
            VueSelect,
            CustomerAdd,
            Invoice
        },
        props: {
            submit_url: {
                type: String,
                default: () => route("Backend.Sales.Store"),
            },
            payment_options: {
                type: Array,
                default: () => payment_options,
            },
            statuses: {
                type: Array,
                default: () => statuses,
            },
        },
        data() {
            return {
                print_type: 'html',
                submit_disabled: false,
                sale_id: null,
                search_category: null,
                searched_items: {
                    data: [],
                },
                customer_balance: 0,
                customer_add_modal_visible: false,
                item_fields: [
                    {key: "action", label: _t("action", "Action")},
                    // {key: "product_id", label: _t("pid", "PID")},
                    {
                        key: "name", label: _t("name", "Name"),
                        formatter: (k, d, r) => {
                            return [r.product_id, r.name, r.code].join(' # ')
                        }
                    },
                    // {key: "code", label: _t("code", "Code")},
                    {key: "price", label: _t("sales.price", "Price")},
                    {key: "quantity", label: _t("quantity", "Quantity")},
                    // {key:'total',label:_t('total','Total')},
                    // {key:'tax',label:_t('tax','Tax')},
                    // {key:'discount',label:_t('discount','Discount')},
                    // {key:'payable',label:_t('payable','Payable')},
                    {key: "payable", label: _t("total", "Total")},

                ],
            };
        },
        mounted() {
            this.$set(this, "form", {
                items: [],
                date: dayjs().format("YYYY-MM-DD"),
                status: "Processed",
                tax: 0,
                discount: 0,
                customer: null,
                payment_method: "Cash",
                payment_amount: 0,
            });
            this.getCatProducts();
        },
        watch: {
            search_category() {
                this.getCatProducts();
            },
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
                return (
                    this.getTotal * (1 + this.form.tax / 100 - this.form.discount / 100)
                );
            },
        },
        methods: {
            colSum,
            printInvoice() {
                let el = document.getElementById('print_invoice').contentWindow;
                el.focus();
                el.print();
            },
            handleSubmit() {

                if (this.$refs.theForm.reportValidity()) {
                    if (!(isArray(this.form.items) && this.form.items.length > 0)) {
                        alert("Please Select Items First");
                        this.$refs.productSelector.$el.querySelector("button").click();
                        return false;
                    }
                    this.submit_disabled = true;
                    this.onSubmit((res) => {
                        this.$bvModal.show('invoice-modal');
                        this.sale_id = res.data.sale_id;
                        this.$set(this, "form", {
                            items: [],
                            date: dayjs().format("YYYY-MM-DD"),
                            status: "Processed",
                            tax: 0,
                            discount: 0,
                            customer: null,
                            payment_method: "Cash",
                            payment_amount: 0,
                        });
                        this.submit_disabled = false;
                        this.$set(this, 'customer_balance', 0);
                    });
                }
            },
            slugify,
            objPhotoUrl,
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
                        tax: v.tax || 0,
                        discount: v.discount || 0,
                    });
                }

                //UI not updating, so doing it here manually
                this.$set(this.form, "product_temp", null);
                this.$set(this.form, "items", items);
            },
            getItemPayable(row) {
                let total = row.quantity * row.price;
                return total * (1 - Number(row.discount) / 100 + Number(row.tax) / 100);
            },
            removeCartItem(row) {
                if (confirm("Are You Sure?")) {
                    this.form.items.splice(row.index, 1);
                }
            },
            getCatProducts(url = null) {
                axios
                    .post(url ? url : route("Backend.Products.POS.Items"), {
                        category_id: this.search_category ? this.search_category.id : null,
                    })
                    .then((res) => {
                        this.$set(this, "searched_items", res.data);
                    })
                    .catch((err) => {
                        this.$set(this, "searched_items", {data: []});
                        console.log(err.response);
                    });
            },
        },
    };
</script>
<style lang="scss">
    .product-image {
        background-color: rgba(0, 0, 0, 0.8);
    }
</style>

