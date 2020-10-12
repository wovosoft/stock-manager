<template>
    <div>
        <b-row class="mb-3">
            <b-col md="4" sm="12">
                <b-card :title="__('total_selling_price','Total Selling Price')">
                    {{overview.price | currency}}
                </b-card>
            </b-col>
            <b-col md="4" sm="12">
                <b-card :title="__('total_buying_cost','Total Buying Cost')">
                    {{overview.cost | currency}}
                </b-card>
            </b-col>

            <b-col md="4" sm="12">
                <b-card :title="__('probable_profit_loss','Probable Profit & Loss')">
                    {{overview.balance | currency}}
                </b-card>
            </b-col>
        </b-row>
        <dt-table :title="title"
                  v-model="search"
                  :fields="fields"
                  :datatable="datatable"
                  :custom_buttons="custom_buttons"
                  enable-date-range
                  @refreshDatatable="$refs.datatable.refresh()"
        >
            <template v-slot:header_dropdowns>
                <b-button size="sm" @click="advance_search_shown=!advance_search_shown">
                    <i class="fa fa-search"/> More
                    <i class="fa" :class="{'fa-caret-down':!advance_search_shown,'fa-caret-up':advance_search_shown}"/>
                </b-button>
            </template>
            <template v-slot:header_bottom_panel>
                <b-collapse v-model="advance_search_shown">
                    <b-card body-class="p-2" class="mt-2">
                        <b-form-row>
                            <b-col>
                                <b-form-group :label="__('category','Category')">
                                    <b-input-group>
                                        <vue-select
                                            :init-options="true"
                                            @input="v=>{
                                                $set(datatable.search_columns,'products.category_id',v?v.id:undefined);
                                                $set(datatable.search_columns,'products.subcategory_id',undefined);
                                                $set(datatable,'subcategories',v.subcategories);
                                            }"
                                            v-model="datatable.category"
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
                                            <b-button
                                                @click="datatable.category=null,datatable.search_columns['products.category_id']=undefined">
                                                x
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('subcategory','Subcategory')">
                                    <b-input-group>
                                        <b-form-select
                                            :options="datatable.subcategories"
                                            text-field="name"
                                            value-field="id"
                                            v-model="datatable.search_columns.subcategory_id"
                                        />
                                        <template v-slot:append>
                                            <b-button
                                                @click="$set(datatable.search_columns,'subcategory_id',undefined)">
                                                x
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group :label="__('brand','Brand')">
                                    <b-input-group>
                                        <vue-select
                                            :init-options="true"
                                            @input="v=>$set(datatable.search_columns,'brand_id',v?v.id:undefined)"
                                            v-model="datatable.brand"
                                            :api_url="route('Backend.Brands.Search').url()">
                                            <template v-slot:option="op">
                                                {{[op.item.id,op.item.name].join(' # ')}}
                                            </template>
                                            <template v-slot:tag="op">
                                                {{op.tag?[op.tag.id,op.tag.name].join(' # ')
                                                :'Not Selected'}}
                                            </template>
                                        </vue-select>
                                        <template v-slot:append>
                                            <b-button
                                                @click="datatable.brand=null,datatable.search_columns.brand_id=undefined">
                                                x
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-form-row>
                        <!--                        <pre v-html="datatable.search_columns"></pre>-->
                    </b-card>
                </b-collapse>
            </template>
            <template v-slot:table>
                <b-table ref="datatable" variant="primary"
                         responsive
                         hover bordered small striped
                         head-variant="dark"
                         :items="getItems"
                         class="mb-0"
                         :fields="fields"
                         :sort-by.sync="datatable.sortBy"
                         :sort-desc.sync="datatable.sortDesc"
                         :filter="search"
                         foot-clone
                         foot-variant="light"
                         @refreshed="overview=JSON.parse(headers.overview||'{}')"
                         :per-page="datatable.per_page" :current-page="datatable.current_page"
                >
                    <template v-slot:foot(quantity)="row">
                        {{colSum(datatable.items,'quantity')|localNumber}}
                    </template>
                    <template v-slot:foot(cost)="row">
                        {{colSum(datatable.items,'cost')|currency}}
                    </template>
                    <template v-slot:foot(price)="row">
                        {{colSum(datatable.items,'price')|currency}}
                    </template>
                    <template v-slot:foot(total_cost)="row">
                        {{colSum(datatable.items,'total_cost')|currency}}
                    </template>
                    <template v-slot:foot(total_price)="row">
                        {{colSum(datatable.items,'total_price')|currency}}
                    </template>
                    <template v-slot:foot(probable_profit)="row">
                        {{colSum(datatable.items,'probable_profit')|currency}}
                    </template>
                    <template v-slot:foot(alert_quantity)="row">
                        {{colSum(datatable.items,'alert_quantity')|localNumber}}
                    </template>
                    <template v-slot:cell(action)="row">
                        <b-button-group size="sm">
                            <b-button variant="primary"
                                      :to="{name:'ProductsView',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-eye"></i>
                            </b-button>
                            <b-button variant="warning"
                                      :to="{name:'ProductsEdit',params:{id:row.item.id}}"
                                      @click="currentItem=JSON.parse(JSON.stringify(row.item))">
                                <i class="fa fa-edit"></i>
                            </b-button>
                            <b-button variant="danger" @click="trash(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </template>
                </b-table>
            </template>
        </dt-table>
        <router-view @reset="currentItem={}"
                     @refreshDatatable="()=>$refs.datatable.refresh()"
                     :item="currentItem"></router-view>
    </div>
</template>

<script>
    import DtHeader from '@/partials/DtHeader'
    import DtFooter from '@/partials/DtFooter'
    import Datatable, {colSum, colCount} from "@/partials/datatable";
    import DtTable from "@/partials/DtTable";
    import VueSelect from "@/partials/VueSelect";
    import ClickOutside from 'vue-click-outside'

    export default {
        name: "ProductsList",
        directives: {ClickOutside},
        components: {
            DtHeader,
            DtFooter,
            DtTable,
            VueSelect
        },
        mixins: [Datatable],
        props: {
            title: {
                type: String,
                default: ' Products'
            },
            api_url: {
                type: String,
                default: () => route('Backend.Products.List').url()
            },
            trash_url: {
                type: String,
                default: () => route('Backend.Products.Delete').url()
            },
            submit_url: {
                type: String,
                default: () => route('Backend.Products.Store').url()
            },
            custom_buttons: {
                type: Array,
                default: () => [
                    {
                        text: 'Add',
                        variant: 'dark',
                        to: {name: 'ProductsAdd'}
                    },
                    {
                        text: 'History',
                        variant: 'primary',
                        to: {
                            name: 'ModelHistory',
                            params: {
                                model: 'products'
                            }
                        }
                    }
                ]
            },
        },
        methods: {
            colCount, colSum
        },
        data() {
            return {
                advance_search_shown: false,
                form: {},
                overview: {cost: 0, price: 0, balance: 0},
                fields: [
                    {key: 'id', name: 'products.id', sortable: true, label: this.__('id', 'ID')},
                    {key: 'name', name: 'products.name', sortable: true, label: this.__('name', 'Name')},
                    {key: 'code', name: 'products.code', sortable: true, label: this.__('code', 'Code')},
                    {
                        key: 'quantity',
                        name: 'products.quantity',
                        sortable: true,
                        label: this.__('quantity', 'Qty.'),
                        formatter: (x, y, z) => (this.$options.filters.localNumber(z.quantity || 0) + ' ' + z.unit_name)
                    },
                    {
                        key: 'cost',
                        name: 'products.cost',
                        sortable: true,
                        label: this.__('cost', 'Cost'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'price',
                        name: 'products.price',
                        sortable: true,
                        label: this.__('price', 'Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'total_cost',
                        searchable: false,
                        sortable: true,
                        label: this.__('total_cost', 'Total Cost'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'total_price',
                        searchable: false,
                        sortable: true,
                        label: this.__('total_price', 'Total Price'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'probable_profit',
                        searchable: false,
                        sortable: true,
                        label: this.__('probable_profit', 'Probable Profit'),
                        formatter: v => this.$options.filters.currency(v)
                    },
                    {
                        key: 'barcode_symbology',
                        name: 'products.barcode_symbology',
                        sortable: true,
                        visible: false,
                        label: this.__('barcode_symbology', 'Barcode Symbology')
                    },
                    {
                        key: 'brand_name',
                        name: 'brands.name',
                        label: this.__('brand', 'Brand'),
                        sortable: true
                    },
                    {
                        key: 'category_name',
                        name: 'categories.name',
                        label: this.__('category', 'Category'),
                        sortable: true
                    },
                    {
                        key: 'subcategory_name',
                        name: 'subcategories.name',
                        label: this.__('sub_category', 'Subcategory'),
                        sortable: true
                    },
                    {
                        key: 'status',
                        name: 'products.status',
                        label: this.__('status', 'Status'),
                        sortable: true,
                        formatter: v => !!v ? 'Active' : 'Inactive'
                    },

                    {
                        key: 'alert_quantity',
                        name: 'products.alert_quantity',
                        sortable: true,
                        label: this.__('alert_quantity', 'Alert Qty.'),
                        formatter: (x, y, z) => (z.alert_quantity + ' ' + z.unit_name)
                    },
                    {
                        key: 'unit_name',
                        name: 'units.name',
                        label: this.__('unit', 'Unit'),
                        sortable: true,
                        visible: false
                    },
                    {
                        key: 'description',
                        name: 'products.description',
                        label: this.__('description', 'Description'),
                        visible: false,
                        sortable: false,
                        formatter: v => this.$options.filters.truncate(v || "")
                    },
                    {
                        key: 'created_at',
                        name: 'products.created_at',
                        label: this.__('created_at', 'Created At'),
                        visible: false,
                        sortable: true,
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'updated_at',
                        name: 'products.updated_at',
                        label: this.__('updated_at', 'Updated At'),
                        visible: false,
                        sortable: true,
                        formatter: v => this.$options.filters.localDateTime(v)
                    },
                    {
                        key: 'action',
                        label: this.__('action', 'Action'),
                        sortable: false,
                        searchable: false,
                        thClass: 'text-right',
                        tdClass: 'text-right'
                    },
                ]
            }
        }
    }
</script>
<style lang="scss">
    .dd-search .dropdown-menu {
        min-width: 300px;
    }
</style>
