(window.webpackJsonp=window.webpackJsonp||[]).push([[24],{"3fRZ":function(t,e,i){"use strict";var n=i("ex6f"),r={props:{value:{type:null|Object,default:function(){return null}},api_url:{type:String,default:null,required:!0},prepend:{type:String,default:""},append:{type:String,default:""},placeholder:{type:String,default:"Search Items"},size:{type:String,default:"sm"},autocomplete:{type:String,default:"off"},dropdownVariant:{type:String,default:"outline-secondary"},emptyOptionText:{type:String,default:"No items available to select"},inputClass:{type:String|Array,default:function(){return[]}},menuStyle:{type:String|Array,default:function(){return[]}},clearSearchOnItemSelected:{type:Boolean,default:!1},initOptions:{type:Boolean|String,default:!1},required:{type:Boolean,default:!1},state:{type:Boolean,default:null},hideDdIcon:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},menuClass:{type:String|Object,default:function(){return""}},getFiltered:{type:Function},clearSearchOnDropdownHidden:{type:Boolean,default:function(){return!0}},optionText:{type:Function},tagText:{Type:Function}},data:function(){return{options:[],query:"",selected_item:null}},mounted:function(){this.initOptions&&(Object(n.a)(this.initOptions)&&this.initOptions?this.getItems(""):this.query=this.initOptions),this.$set(this,"selected_item",this.value)},computed:{getOptions:function(){return"function"==typeof this.getFiltered&&this.getFiltered?this.getFiltered(this.options):this.options}},watch:{value:{deep:!0,handler:function(t){this.$set(this,"selected_item",t)}}},methods:{reset:function(){this.$emit("input",null),this.$set(this,"selected_item",null),this.query=""},itemSelected:function(t){this.$emit("input",t),this.$set(this,"selected_item",t),this.clearSearchOnItemSelected&&(this.query=null)},getItems:function(t){var e=this;axios.post(this.api_url,{query:this.query}).then((function(t){e.$set(e,"options",t.data||[])})).catch((function(t){e.$set(e,"options",[]),console.error(t.response)}))}}},a=(i("c9im"),i("KHd+")),o=Object(a.a)(r,(function(){var t=this,e=this,i=e.$createElement,n=e._self._c||i;return n("div",{staticClass:"vue-select form-control p-0",class:{"is-invalid":null!==e.state&&e.state,"is-valid":null!==e.state&&!e.state,"form-control-sm":"sm"===e.size,"form-control-lg":"lg"===e.size,"form-control-xl":"xl"===e.size}},[e.required?n("input",{staticStyle:{height:"0",position:"absolute",top:"0",border:"0",outline:"0","z-index":"-1"},attrs:{type:"text",required:!0},domProps:{value:e.value?"initialized":""}}):e._e(),e._v(" "),n("b-dropdown",{class:{"hide-dd-icon":e.hideDdIcon,disabled:e.disabled},style:e.menuStyle,attrs:{block:"",lazy:"",variant:e.dropdownVariant,size:e.size,disabled:e.disabled,"toggle-class":"text-left m-0 border-0 border-radius-0","menu-class":e.menuClass},on:{hidden:function(){e.$emit("hidden",!0),t.clearSearchOnDropdownHidden&&(t.query="")}},scopedSlots:e._u([{key:"button-content",fn:function(){return[e._t("tag",[e._v("\n                "+e._s("function"==typeof e.tagText?e.tagText(e.selected_item):(e.selected_item,e.placeholder))+"\n            ")],{tag:e.selected_item})]},proxy:!0}],null,!0)},[e._v(" "),n("div",{staticClass:"px-2"},[n("b-form-input",{class:e.inputClass,attrs:{autofocus:"",type:"search",size:e.size,placeholder:e.placeholder,autocomplete:e.autocomplete},on:{keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter"))return null;t.preventDefault()},input:function(t){return e.getItems(t)}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}})],1),e._v(" "),n("b-dropdown-divider"),e._v(" "),e._l(e.getOptions,(function(t,i){return n("b-dropdown-item",{key:i,on:{click:function(i){return e.itemSelected(t)}}},[e._t("option",[e._v("\n                "+e._s("function"==typeof e.optionText?e.optionText(t):t)+"\n            ")],{item:t,query:e.query})],2)})),e._v(" "),0===e.options.length?[e._t("empty",[0===e.options.length?n("b-dropdown-text",[e._v("\n                    "+e._s(e.emptyOptionText)+"\n                ")]):e._e()],{query:e.query})]:e._e(),e._v(" "),e._t("default_item",null,{query:e.query})],2)],1)}),[],!1,null,null,null);e.a=o.exports},CbKX:function(t,e,i){"use strict";i.r(e);var n=i("kQN2"),r=i("WaG5"),a=i("3fRZ"),o={mixins:[n.a],components:{VueSelect:a.a},methods:{handleSubmit:function(){var t=this;this.form.items.length&&axios.post(route("Backend.PurchaseItems.Store",{purchase:this.the_item.id}),JSON.parse(JSON.stringify(this.form))).then((function(e){t.dirty=!0,t.getItem(t.the_item.id,t.$parent.$props.api_url).then((function(e){t.the_item=e.data,t.form.items=[]})).catch((function(t){return console.log(t.response)}))})).catch((function(t){console.log(t.response)}))},trash:function(t){var e=this;confirm(_t("are_you_sure","Are You Sure?"))&&axios.post(route("Backend.PurchaseItems.Delete",{purchase:t.purchase_id,purchase_item:t.id})).then((function(t){e.dirty=!0,e.getItem(e.the_item.id,e.$parent.$props.api_url).then((function(t){e.the_item=t.data})).catch((function(t){return console.log(t.response)}))})).catch((function(t){console.log(t.response)}))},itemEdit:function(t){this.form.items.find((function(e){return e.product_id===t.product_id}))||this.form.items.push({id:t.id,product_id:t.product_id,price:t.price||0,quantity:t.quantity,code:t.code,name:t.product_name,total:t.price})},addProductToCart:function(t){var e=JSON.parse(JSON.stringify(this.form.items)),i=e.find((function(e){return e.code===t.code}));i?i.quantity++:e.push({product_id:t.id,price:t.price||0,quantity:1,code:t.code,name:[t.id,t.name].join(" # "),total:t.price}),this.$set(this,"product_temp",null),this.$set(this.form,"items",e)}},data:function(){var t=this;return{product_temp:null,dirty:!1,statuses:r.a,the_item:{},form:{items:[]},purchaseItemFields:[{key:"product_name",label:_t("product_name","Product Name")},{key:"quantity",label:_t("quantity","Quantity")},{key:"price",label:_t("price","Price"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"total",label:_t("total","Total"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"action",label:_t("action","Action"),thClass:"text-right",tdClass:"text-right"}]}}},s=i("KHd+"),u=Object(s.a)(o,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"",title:t.__("view_purchase","View Purchase"),lazy:""},on:{hidden:function(){t.$router.go(-1),t.$emit("reset",!0),t.dirty&&t.$emit("refreshDatatable",!0)}}},[i("b-row",[i("b-col",{attrs:{sm:"12",md:"4"}},[i("h4",[t._v(t._s(t.__("supplier_details","Supplier Details")))]),t._v(" "),i("b-table",{attrs:{items:t.obj2Table(t.the_item.supplier,["deleted_at","created_at","updated_at","photo","shipping_address","id"]),fields:[{key:"key",label:t.__("key","Key"),formatter:function(e){return t.__(e,t.startCase(e))}},{key:"value",label:t.__("value","Value")}],striped:"",bordered:"",small:"","head-variant":"dark"},scopedSlots:t._u([{key:"cell(value)",fn:function(e){return[["created_at","updated_at"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("dayjs")(e.item.value))+"\n                    ")]:[t._v(t._s(e.item.value))]]}}])})],1),t._v(" "),i("b-col",{attrs:{sm:"12",md:"8"}},[i("h4",[t._v(t._s(t.__("purchase_details","Purchase Details")))]),t._v(" "),i("b-table",{attrs:{small:"",hover:"",striped:"",bordered:"","head-variant":"dark",items:t.obj2Table(t.the_item,["deleted_at","image","items","supplier","supplier_name","supplier_id","tax","discount","updated_at","total","status"]),fields:[{label:t.__("key","Key"),key:"key",sortable:!0,formatter:function(e){return t.__(e,t.startCase(e))}},{label:t.__("value","Value"),key:"value",sortable:!0}]},scopedSlots:t._u([{key:"cell(value)",fn:function(e){return[["created_at","updated_at"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("dayjs")(e.item.value))+"\n                    ")]:[t._v(t._s(e.item.value))]]}}])})],1)],1),t._v(" "),i("h3",{staticClass:"text-center"},[t._v(t._s(t.__("purchase_items","Purchase Items")))]),t._v(" "),i("b-table",{attrs:{small:"",striped:"",bordered:"","head-variant":"dark",items:t.the_item.items,fields:t.purchaseItemFields},scopedSlots:t._u([{key:"cell(action)",fn:function(e){return[i("b-button-group",{attrs:{size:"sm"}},[i("b-button",{attrs:{variant:"primary"},on:{click:function(i){return t.itemEdit(e.item)}}},[i("i",{staticClass:"fa fa-edit"})]),t._v(" "),i("b-button",{attrs:{variant:"dark"},on:{click:function(i){return t.trash(e.item)}}},[i("i",{staticClass:"fa fa-trash"})])],1)]}}])}),t._v(" "),i("b-card",{attrs:{header:t.__("add_product","Add Product"),"body-class":"p-2"}},[i("b-form-group",{staticClass:"mb-1"},[i("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[i("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                        "+t._s(t.__("select_product","Select Product"))+"\n                    ")])]},proxy:!0}])},[t._v(" "),i("vue-select",{ref:"productSelector",attrs:{"get-filtered":function(e){return e.filter((function(e){return!(t.form.items||[]).map((function(t){return t.code})).includes(e.code)}))},"init-options":!0,"option-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Products.Search")},on:{input:function(e){t.addProductToCart(e)}},model:{value:t.product_temp,callback:function(e){t.product_temp=e},expression:"product_temp"}})],1)],1),t._v(" "),i("b-form",{on:{submit:function(e){return e.preventDefault(),t.handleSubmit(e)}}},[i("b-table",{attrs:{items:t.form.items,small:"","head-variant":"dark",fields:[{key:"name",label:t.__("name","Name")},{key:"code",label:t.__("code","Code")},{key:"price",label:t.__("price","Price")},{key:"quantity",label:t.__("quantity","Quantity")},{key:"total",label:t.__("total","Total"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"action",label:t.__("action","Action"),tdClass:"text-right",thClass:"text-right"}],hover:"",striped:""},scopedSlots:t._u([{key:"cell(price)",fn:function(e){return[i("input",{directives:[{name:"model",rawName:"v-model",value:e.item.price,expression:"row.item.price"}],attrs:{type:"number",step:"any",required:!0,placeholder:t.__("price","Price")},domProps:{value:e.item.price},on:{input:[function(i){i.target.composing||t.$set(e.item,"price",i.target.value)},function(t){e.item.total=Number(e.item.price)*Number(e.item.quantity||0)}]}})]}},{key:"cell(quantity)",fn:function(e){return[i("input",{directives:[{name:"model",rawName:"v-model",value:e.item.quantity,expression:"row.item.quantity"}],attrs:{type:"number",step:"any",required:!0,placeholder:t.__("quantity","Quantity")},domProps:{value:e.item.quantity},on:{input:[function(i){i.target.composing||t.$set(e.item,"quantity",i.target.value)},function(t){e.item.total=Number(e.item.price)*Number(e.item.quantity||0)}]}})]}},{key:"cell(action)",fn:function(e){return[i("b-button",{attrs:{size:"sm",variant:"dark"},on:{click:function(i){return t.form.items.splice(e.index,1)}}},[i("i",{staticClass:"fa fa-trash"})])]}}])}),t._v(" "),i("b-form-group",{attrs:{align:"right"}},[i("b-button",{attrs:{disabled:t.form.items.length<=0,variant:"dark",type:"submit"}},[t._v("SUBMIT")])],1)],1)],1)],1)}),[],!1,null,null,null);e.default=u.exports},QK5V:function(t,e,i){var n=i("LboF"),r=i("xA+E");"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var a={insert:"head",singleton:!1};n(r,a);t.exports=r.locals||{}},WaG5:function(t,e,i){"use strict";e.a=[{text:_t("pending","Pending"),value:"Pending"},{text:_t("accepted","Accepted"),value:"Accepted"},{text:_t("returned","Returned"),value:"Returned"},{text:_t("processed","Processed"),value:"Processed"},{text:_t("cancelled","Cancelled"),value:"Cancelled"}]},c9im:function(t,e,i){"use strict";var n=i("QK5V");i.n(n).a},kQN2:function(t,e,i){"use strict";var n=i("X/aF"),r=i("EIrz");e.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:n.m,startCase:r.a,getItem:n.g},data:function(){return{the_item:{}}},mounted:function(){var t=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url||this.$parent._data.api_url).then((function(e){t.the_item=e.data})).catch((function(t){return console.log(t.response)}))}}},"xA+E":function(t,e,i){(e=i("JPst")(!1)).push([t.i,".vue-select .dropdown-menu {\n  max-height: 300px;\n  overflow-y: auto;\n  width: 100%;\n}\n.vue-select .dropdown-toggle::after {\n  position: absolute;\n  right: 10px;\n  top: 49%;\n}\n.vue-select .border-radius-0 {\n  border-radius: 0 !important;\n}\n.vue-select .top-reverse-100 {\n  top: -100% !important;\n}\n.vue-select .hide-dd-icon .dropdown-toggle::after {\n  display: none !important;\n}\n.vue-select.is-invalid, .vue-select.is-valid {\n  background-position: right calc(1.4em + 0.1875rem) center !important;\n}",""]),t.exports=e}}]);