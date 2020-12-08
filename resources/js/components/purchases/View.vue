<template>
    <b-modal @hidden="()=>{
                $router.go(-1);
                $emit('reset',true);
                if (dirty){
                    $emit('refreshDatatable',true);
                }
             }"
             visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_purchase','View Purchase')"
             lazy>
        <b-row>
            <b-col sm="12" md="4">
                <h4>{{__('supplier_details','Supplier Details')}}</h4>
                <b-table
                    :items="obj2Table(the_item.supplier,['deleted_at','created_at','updated_at','photo','shipping_address','id'])"
                    :fields="[
                        {key:'key',label:__('key','Key'),formatter:v=>__(v,startCase(v))},
                        {key:'value',label:__('value','Value')}
                    ]"
                    striped
                    bordered
                    small head-variant="dark">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
            <b-col sm="12" md="8">
                <h4>{{__('purchase_details','Purchase Details')}}</h4>
                <b-table small hover striped bordered
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','image','items','supplier','supplier_name','supplier_id','tax','discount','updated_at','total','status'])"
                         :fields="[
                            {
                                label:__('key','Key'),
                                key: 'key', sortable: true,
                                formatter: (v) => __(v,startCase(v))
                            },
                            {
                                label:__('value','Value'),
                                key: 'value',
                                sortable: true
                            }
                       ]">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-row>

        <h3 class="text-center">{{__('purchase_items','Purchase Items')}}</h3>
        <b-table
            small
            striped
            bordered
            head-variant="dark"
            :items="the_item.items"
            :fields="purchaseItemFields">
            <template #cell(action)="row">
                <b-button-group size="sm">
                    <b-button variant="primary" @click="itemEdit(row.item)">
                        <i class="fa fa-edit"></i>
                    </b-button>
                    <b-button variant="dark" @click="trash(row.item)">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </b-button-group>
            </template>
        </b-table>
        <b-card :header="__('add_product','Add Product')"
                body-class="p-2">
            <b-form-group class="mb-1">
                <b-input-group>
                    <template #prepend>
                        <b-input-group-text style="min-width: 200px">
                            {{ __("select_product", "Select Product") }}
                        </b-input-group-text>
                    </template>
                    <vue-select
                        :get-filtered="(o) => o.filter((op) => !(form.items || []).map((i) => i.code).includes(op.code))"
                        :init-options="true"
                        ref="productSelector"
                        @input="v=>{addProductToCart(v)}"
                        v-model="product_temp"
                        :option-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                        :tag-text="op=>op?[op.id, op.name, op.code].join(' # '):__('not_selected','Not Selected')"
                        :api_url="route('Backend.Products.Search').url()">
                    </vue-select>
                </b-input-group>
            </b-form-group>
            <b-form @submit.prevent="handleSubmit">
                <b-table :items="form.items"
                         small head-variant="dark"
                         :fields="[{key:'name',label:__('name','Name')},
                     {key:'code',label:__('code','Code')},
                     {key:'price',label:__('price','Price')},
                     {key:'quantity',label:__('quantity','Quantity')},
                     {key:'total',label:__('total','Total'),formatter:v=>$options.filters.currency(v)},
                     {key:'action',label:__('action','Action'),tdClass:'text-right',thClass:'text-right'},]"
                         hover striped>
                    <template #cell(price)="row">
                        <input type="number" step="any"
                               :required="true"
                               @input="row.item.total=Number(row.item.price)*Number(row.item.quantity || 0)"
                               v-model="row.item.price"
                               :placeholder="__('price','Price')"/>
                    </template>
                    <template #cell(quantity)="row">
                        <input type="number" step="any"
                               :required="true"
                               @input="row.item.total=Number(row.item.price)*Number(row.item.quantity || 0)"
                               v-model="row.item.quantity"
                               :placeholder="__('quantity','Quantity')"/>
                    </template>
                    <template #cell(action)="row">
                        <b-button size="sm" variant="dark" @click="form.items.splice(row.index,1)">
                            <i class="fa fa-trash"></i>
                        </b-button>
                    </template>
                </b-table>
                <b-form-group align="right">
                    <b-button :disabled="form.items.length<=0" variant="dark" type="submit">SUBMIT</b-button>
                </b-form-group>
            </b-form>
        </b-card>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import statuses from "@/shared/statuses";
    import VueSelect from "@/partials/VueSelect";

    export default {
        mixins: [view],
        components: {
            VueSelect
        },
        methods: {
            handleSubmit() {
                if (this.form.items.length) {
                    axios
                        .post(route('Backend.PurchaseItems.Store', {purchase: this.the_item.id}).url(), JSON.parse(JSON.stringify(this.form)))
                        .then(res => {
                            this.dirty = true;
                            this.getItem(this.the_item.id, this.$parent.$props.api_url)
                                .then(res => {
                                    this.the_item = res.data
                                    this.form.items = [];
                                })
                                .catch(err => console.log(err.response));
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                }
            },
            trash(item) {
                if (confirm(_t('are_you_sure', 'Are You Sure?'))) {
                    axios
                        .post(route('Backend.PurchaseItems.Delete', {
                            purchase: item.purchase_id,
                            purchase_item: item.id
                        }).url()).then(res => {
                        this.dirty = true;
                        this.getItem(this.the_item.id, this.$parent.$props.api_url).then(res => {
                            this.the_item = res.data
                        }).catch(err => console.log(err.response));
                    }).catch(err => {
                        console.log(err.response);
                    });
                }
            },
            itemEdit(item) {
                let found = this.form.items.find((i) => i.product_id === item.product_id);
                if (!found) {
                    this.form.items.push({
                        id: item.id,
                        product_id: item.product_id,
                        price: item.price || 0,
                        quantity: item.quantity,
                        code: item.code,
                        name: item.product_name,
                        total: item.price
                    });
                }
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
                        name: [v.id, v.name].join(' # '),
                        total: v.price
                    });
                }

                //UI not updating, so doing it here manually
                this.$set(this, "product_temp", null);
                this.$set(this.form, "items", items);
            }
        },
        data() {
            return {
                product_temp: null,
                dirty: false,
                statuses,
                the_item: {},
                form: {
                    items: []
                },
                purchaseItemFields: [
                    // {key: 'id', label: _t('id', 'ID')},
                    {key: 'product_name', label: _t('product_name', 'Product Name')},
                    {key: 'quantity', label: _t('quantity', 'Quantity')},
                    {
                        key: 'price', label: _t('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'total',
                        label: _t('total', 'Total'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'action',
                        label: _t('action', 'Action'),
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    }
                ]
            }
        }
    }
</script>
