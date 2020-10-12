<template>
    <div>
        <b-form-row>
            <b-col sm="12" md="6">
                <b-card body-class="p-2" class="h-100">
                    <b-form @submit.prevent="handleSubmit" ref="theForm">
                        <b-form-group>
                            <b-input-group>
                                <template #prepend>
                                    <b-input-group-text style="min-width: 200px">
                                        {{ __("customer", "Customer") }}
                                    </b-input-group-text>
                                </template>
                                <vue-select
                                    :init-options="true"
                                    :required="true"
                                    @input="(v) => (form.customer_id = v ? v.id : null)"
                                    v-model="form.customer"
                                    :tag-text="(tag)=>tag ? [tag.id, tag.name, tag.phone].join(' # '): __('not_selected', 'Not Selected')"
                                    :option-text="(op)=>op ? [op.id, op.name, op.phone].join(' # '): ''"
                                    :api_url="route('Backend.Customers.Search').url()">
                                </vue-select>
                                <template v-slot:append>
                                    <b-button @click="(form.customer = null), (form.customer_id = null)"
                                              class="font-weight-bold">
                                        X
                                    </b-button>
                                    <b-button @click="customer_add_modal_visible = true" variant="dark">
                                        <i class="fa fa-plus"></i>
                                    </b-button>
                                </template>
                            </b-input-group>
                        </b-form-group>

                        <b-form-group class="mb-1">
                            <b-input-group>
                                <template #prepend>
                                    <b-input-group-text style="min-width: 200px">
                                        {{ __("select_product", "Select Product") }}
                                    </b-input-group-text>
                                </template>
                                <vue-select
                                    :get-filtered="(o) => o.filter((op) => !form.items.map((i) => i.code).includes(op.code))"
                                    :init-options="true"
                                    ref="productSelector"
                                    @input="v=>{addProductToCart(v);$set(form,'product_temp',null);}"
                                    v-model="form.product_temp"
                                    :option-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                                    :tag-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                                    :api_url="route('Backend.Products.Search').url()">
                                </vue-select>
                            </b-input-group>
                        </b-form-group>
                        <b-table
                            bordered
                            small
                            hover
                            striped
                            head-variant="dark"
                            :fields="item_fields"
                            :items="form.items"
                        >
                            <template v-slot:cell(price)="row">
                                <b-input-group size="sm" :append="$options.filters.currencySymbol(0)">
                                    <b-input
                                        type="number"
                                        step="any"
                                        v-model="row.item.price"
                                        :placeholder="__('price', 'Price')"
                                        :required="true"
                                    />
                                </b-input-group>
                            </template>
                            <template v-slot:cell(quantity)="row">
                                <b-input
                                    type="number"
                                    step="any"
                                    v-model="row.item.quantity"
                                    :placeholder="__('quantity', 'Quantity')"
                                    :required="true"
                                    size="sm"
                                />
                            </template>
                            <template v-slot:cell(total)="row">
                                {{ (row.item.quantity * row.item.price) | currency }}
                            </template>
                            <template v-slot:cell(tax)="row">
                                <b-input-group append="%" size="sm">
                                    <b-input
                                        type="number"
                                        step="any"
                                        v-model="row.item.tax"
                                        :placeholder="__('tax', 'Tax')"
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
                                        :placeholder="__('discount', 'Discount')"
                                        :required="true"
                                    />
                                </b-input-group>
                            </template>
                            <template v-slot:cell(payable)="row">
                                {{ getItemPayable(row.item) | currency }}
                            </template>
                            <template v-slot:cell(action)="row">
                                <b-button
                                    size="sm"
                                    variant="danger"
                                    @click="removeCartItem(row)"
                                >
                                    <b-icon-trash/>
                                </b-button>
                            </template>
                            <template #custom-foot>
                                <b-tr>
                                    <b-td :colspan="5" class="text-right font-weight-bold">
                                        {{ __("total", "Total") }}
                                    </b-td>
                                    <b-td :colspan="2" class="font-weight-bold">
                                        {{ getPayable | currency }}
                                    </b-td>
                                </b-tr>
                            </template>
                        </b-table>

                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('payment_amount', 'Payment Amount')">
                                    <b-input-group>
                                        <b-input
                                            step="any"
                                            type="number"
                                            :placeholder="__('payment_amount', 'Payment Amount')"
                                            :required="true"
                                            v-model="form.payment_amount"
                                        />
                                        <template #append>
                                            <b-button
                                                variant="dark"
                                                @click="form.payment_amount = getPayable"
                                            >
                                                {{ __("full", "Full") }}
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('payment_method', 'Payment Method')">
                                    <b-form-select v-model="form.payment_method" :options="payment_options"/>
                                </b-form-group>
                            </b-col>
                        </b-form-row>
                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('date', 'Date')">
                                    <b-form-input type="date" v-model="form.date"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Status">
                                    <b-form-select :required="true" v-model="form.status" :options="statuses"/>
                                </b-form-group>
                            </b-col>
                        </b-form-row>

                        <b-form-group :label="__('note', 'Note')">
                            <b-form-textarea :rows="4" :placeholder="__('sales_note', 'Sales Note')"
                                             v-model="form.note"/>
                        </b-form-group>
                        <!--
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
                                    -->
                        <b-button type="submit" block variant="dark">
                            {{ __("submit", "SUBMIT") }}
                        </b-button>
                    </b-form>
                </b-card>
            </b-col>
            <b-col sm="12" md="6">
                <b-card
                    class="h-100"
                    body-class="p-2 mh-60vh overflow-auto"
                    header-class="px-2"
                >
                    <template #header>
                        <b-input-group>
                            <template #prepend>
                                <b-input-group-text style="min-width: 200px">
                                    {{ __("select_category", "Select Category") }}
                                </b-input-group-text>
                            </template>
                            <template #append>
                                <b-button @click="search_category = null">x</b-button>
                            </template>
                            <vue-select
                                v-model="search_category"
                                :init-options="true"
                                :option-text="(op) => [op.id, op.name, op.code].join(' # ')"
                                :tag-text="(op) =>op? [op.id, op.name, op.code].join(' # '): __('not_selected', 'Not Selected')"
                                :api_url="route('Backend.Categories.Search').url()"
                            >
                            </vue-select>
                        </b-input-group>
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

        <customer-add
            :visibility="customer_add_modal_visible"
            @created=" (v) => {form.customer = v.item;form.customer_id = v.id;}"
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
            no-close-on-esc
            @hidden="sale_id=null">
            <b-embed
                id="print_invoice"
                aspect="16by9"
                allowfullscreen
                :src="route('Backend.Sales.Invoice.PDF',{sale:sale_id,type:'pdf'})"/>
            <template v-slot:modal-footer="{close}">
                <!--                <b-button variant="primary" @click="invoice_type=invoice_type==='pdf'?'html':'pdf'">-->
                <!--                    Type : {{invoice_type}}-->
                <!--                </b-button>-->
                <b-button @click="printInvoice" variant="primary">Print</b-button>
                <b-button @click="close" variant="secondary">Close</b-button>
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
                default: () => route("Backend.Sales.Store").url(),
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
                sale_id: null,
                search_category: null,
                searched_items: {
                    data: [],
                },
                customer_add_modal_visible: false,
                item_fields: [
                    {key: "product_id", label: _t("pid", "PID")},
                    {key: "name", label: _t("name", "Name")},
                    {key: "code", label: _t("code", "Code")},
                    {key: "price", label: _t("price", "Price")},
                    {key: "quantity", label: _t("quantity", "Quantity")},
                    // {key:'total',label:_t('total','Total')},
                    // {key:'tax',label:_t('tax','Tax')},
                    // {key:'discount',label:_t('discount','Discount')},
                    // {key:'payable',label:_t('payable','Payable')},
                    {key: "payable", label: _t("total", "Total")},
                    {key: "action", label: _t("action", "Action")},
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
                    .post(url ? url : route("Backend.Products.POS.Items").url(), {
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

