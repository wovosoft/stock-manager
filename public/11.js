(window.webpackJsonp=window.webpackJsonp||[]).push([[11],{11:function(t,e,n){"use strict";var r=n(2);e.a={props:{getCreatedItem:{type:Boolean,default:!1},item:{type:Object,default:function(){return{}}}},mounted:function(){this.form=this.item,Object(r.i)(this,(function(){}))},data:function(){return{form:{},errors:null,visible:!0}},methods:{getItem:r.g,onSubmit:r.o,hitSubmit:function(){this.$refs.submitBtn.click()},hasError:function(t){return!!(this.errors&&this.errors[t]&&this.errors[t].length)},getErrorMsg:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:",";return this.hasError(t)?this.errors[t].join(e):""}}}},142:function(t,e,n){"use strict";n.r(e);var r=n(11),o=n(19),i=n(10),a=n.n(i),s=n(16),u=n(25),l=n(51),c=n(2),d={mixins:[r.a],components:{VueSelect:o.a,Invoice:l.a},props:{submit_url:{type:String,default:function(){return route("Backend.Purchases.Store").url()}},payment_options:{type:Array,default:function(){return s.a}},statuses:{type:Array,default:function(){return u.a}}},data:function(){return{purchase_id:null,search_category:null,searched_items:{data:[]},supplier_add_modal_visible:!1,item_fields:[{key:"product_id",label:_t("pid","PID")},{key:"name",label:_t("name","Name")},{key:"code",label:_t("code","Code")},{key:"price",label:_t("price","Price")},{key:"quantity",label:_t("quantity","Quantity")},{key:"total",label:_t("total","Total")},{key:"action",label:_t("action","Action")}]}},mounted:function(){this.$set(this,"form",{items:[],date:a()().format("YYYY-MM-DD"),status:"Processed",tax:0,discount:0,supplier:null,payment_method:"Cash",payment_amount:0}),this.getCatProducts()},watch:{search_category:function(){this.getCatProducts()}},computed:{getTotal:function(){var t=0;for(var e in this.form.items)t+=this.getItemPayable(this.form.items[e]);return t},getPayable:function(){return this.getTotal*(1+this.form.tax/100-this.form.discount/100)}},methods:{colSum:c.d,printInvoice:function(){var t=document.getElementById("print_invoice").contentWindow;t.focus(),t.print()},handleSubmit:function(){var t=this;if(this.$refs.theForm.reportValidity()){if(!(Array.isArray(this.form.items)&&this.form.items.length>0))return alert("Please Select Items First"),this.$refs.productSelector.$el.querySelector("button").click(),!1;this.onSubmit((function(e){t.$bvModal.show("invoice-modal"),t.purchase_id=e.data.purchase_id,t.$set(t,"form",{items:[],date:a()().format("YYYY-MM-DD"),status:"Processed",tax:0,discount:0,supplier:null,payment_method:"Cash",payment_amount:0})}))}},addProductToCart:function(t){var e=JSON.parse(JSON.stringify(this.form.items)),n=e.find((function(e){return e.code===t.code}));n?n.quantity++:e.push({product_id:t.id,price:t.price||0,quantity:1,code:t.code,name:t.name}),this.$set(this.form,"product_temp",null),this.$set(this.form,"items",e)},getItemPayable:function(t){return t.quantity*t.price},removeCartItem:function(t){confirm("Are You Sure?")&&this.form.items.splice(t.index,1)},getCatProducts:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;axios.post(e||route("Backend.Products.POS.Items").url(),{category_id:this.search_category?this.search_category.id:null}).then((function(e){t.$set(t,"searched_items",e.data)})).catch((function(e){t.$set(t,"searched_items",{data:[]}),console.log(e.response)}))}}},p=(n(81),n(1)),m=Object(p.a)(d,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("b-form-row",[n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-card",{staticClass:"h-100  overflow-auto",attrs:{"body-class":"p-2"}},[n("b-form",{ref:"theForm",on:{submit:function(e){return e.preventDefault(),t.handleSubmit(e)}}},[n("b-form-group",[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                    "+t._s(t.__("supplier","Supplier"))+"\n                                ")])]},proxy:!0},{key:"append",fn:function(){return[n("b-button",{staticClass:"font-weight-bold",on:{click:function(e){t.form.supplier=null,t.form.supplier_id=null}}},[t._v("\n                                    X\n                                ")])]},proxy:!0}])},[t._v(" "),n("vue-select",{attrs:{"init-options":!0,required:!0,"tag-text":function(e){return e?[e.id,e.name,e.phone].join(" # "):t.__("not_selected","Not Selected")},"option-text":function(t){return t?[t.id,t.name,t.phone].join(" # "):""},api_url:t.route("Backend.Suppliers.Search").url()},on:{input:function(e){return t.form.supplier_id=e?e.id:null}},model:{value:t.form.supplier,callback:function(e){t.$set(t.form,"supplier",e)},expression:"form.supplier"}})],1)],1),t._v(" "),n("b-form-group",{staticClass:"mb-1"},[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                    "+t._s(t.__("select_product","Select Product"))+"\n                                ")])]},proxy:!0}])},[t._v(" "),n("vue-select",{ref:"productSelector",attrs:{"get-filtered":function(e){return e.filter((function(e){return!t.form.items.map((function(t){return t.code})).includes(e.code)}))},"init-options":!0,"option-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Products.Search").url()},on:{input:function(e){t.addProductToCart(e),t.$set(t.form,"product_temp",null)}},model:{value:t.form.product_temp,callback:function(e){t.$set(t.form,"product_temp",e)},expression:"form.product_temp"}})],1)],1),t._v(" "),n("b-table",{attrs:{bordered:"",small:"",hover:"",striped:"","head-variant":"dark",fields:t.item_fields,items:t.form.items},scopedSlots:t._u([{key:"cell(price)",fn:function(e){return[n("b-input-group",{attrs:{size:"sm",append:t.$options.filters.currencySymbol(0)}},[n("b-input",{attrs:{type:"number",step:"any",placeholder:t.__("price","Price"),required:!0},model:{value:e.item.price,callback:function(n){t.$set(e.item,"price",n)},expression:"row.item.price"}})],1)]}},{key:"cell(quantity)",fn:function(e){return[n("b-input",{attrs:{type:"number",step:"any",min:0,placeholder:t.__("quantity","Quantity"),required:!0,size:"sm"},model:{value:e.item.quantity,callback:function(n){t.$set(e.item,"quantity",n)},expression:"row.item.quantity"}})]}},{key:"cell(total)",fn:function(e){return[t._v("\n                            "+t._s(t._f("currency")(Number(e.item.quantity*e.item.price)))+"\n                        ")]}},{key:"cell(action)",fn:function(e){return[n("b-button",{attrs:{size:"sm",variant:"danger"},on:{click:function(n){return t.removeCartItem(e)}}},[n("b-icon-trash")],1)]}},{key:"custom-foot",fn:function(){return[n("b-tr",[n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:5}},[t._v("\n                                    "+t._s(t.__("total","Total"))+"\n                                ")]),t._v(" "),n("b-td",{staticClass:"font-weight-bold",attrs:{colspan:2}},[t._v("\n                                    "+t._s(t._f("currency")(t.getPayable))+"\n                                ")])],1)]},proxy:!0}])}),t._v(" "),n("b-form-row",[n("b-col",[n("b-form-group",{attrs:{label:t.__("payment_amount","Payment Amount")}},[n("b-input-group",{scopedSlots:t._u([{key:"append",fn:function(){return[n("b-button",{attrs:{variant:"dark"},on:{click:function(e){t.form.payment_amount=t.getPayable}}},[t._v("\n                                            "+t._s(t.__("full","Full"))+"\n                                        ")])]},proxy:!0}])},[n("b-input",{attrs:{step:"any",type:"number",placeholder:t.__("payment_amount","Payment Amount"),required:!0},model:{value:t.form.payment_amount,callback:function(e){t.$set(t.form,"payment_amount",e)},expression:"form.payment_amount"}})],1)],1)],1),t._v(" "),n("b-col",[n("b-form-group",{attrs:{label:t.__("payment_method","Payment Method")}},[n("b-form-select",{attrs:{options:t.payment_options},model:{value:t.form.payment_method,callback:function(e){t.$set(t.form,"payment_method",e)},expression:"form.payment_method"}})],1)],1)],1),t._v(" "),n("b-form-row",[n("b-col",[n("b-form-group",{attrs:{label:t.__("date","Date")}},[n("b-form-input",{attrs:{type:"date"},model:{value:t.form.date,callback:function(e){t.$set(t.form,"date",e)},expression:"form.date"}})],1)],1),t._v(" "),n("b-col",[n("b-form-group",{attrs:{label:"Status"}},[n("b-form-select",{attrs:{required:!0,options:t.statuses},model:{value:t.form.status,callback:function(e){t.$set(t.form,"status",e)},expression:"form.status"}})],1)],1)],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("note","Note")}},[n("b-form-textarea",{attrs:{rows:4,placeholder:t.__("sales_note","Sales Note")},model:{value:t.form.note,callback:function(e){t.$set(t.form,"note",e)},expression:"form.note"}})],1),t._v(" "),n("b-button",{attrs:{type:"submit",block:"",variant:"dark"}},[t._v("\n                        "+t._s(t.__("submit","SUBMIT"))+"\n                    ")])],1)],1)],1),t._v(" "),n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-card",{staticClass:"h-100",attrs:{"body-class":"p-2 mh-60vh overflow-auto","header-class":"px-2"},scopedSlots:t._u([{key:"header",fn:function(){return[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                "+t._s(t.__("select_category","Select Category"))+"\n                            ")])]},proxy:!0},{key:"append",fn:function(){return[n("b-button",{on:{click:function(e){t.search_category=null}}},[t._v("x")])]},proxy:!0}])},[t._v(" "),t._v(" "),n("vue-select",{attrs:{"init-options":!0,"option-text":function(t){return[t.id,t.name,t.code].join(" # ")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Categories.Search").url()},model:{value:t.search_category,callback:function(e){t.search_category=e},expression:"search_category"}})],1)]},proxy:!0},{key:"footer",fn:function(){return[n("b-row",[n("b-col",[t._v("\n                            "+t._s(t.__("total","Total"))+" : "+t._s(t._f("localNumber")(t.searched_items.total))+"\n                            "+t._s(t.__("items","Items"))+",\n                            "+t._s(t.__("page","Page"))+" : "+t._s(t._f("localNumber")(t.searched_items.current_page))+"/\n                            "+t._s(t._f("localNumber")(t.searched_items.last_page))+"\n                        ")]),t._v(" "),n("b-col",{staticClass:"text-right"},[t.searched_items.prev_page_url?n("b-button",{attrs:{variant:"dark",size:"sm"},on:{click:function(e){return t.getCatProducts(t.searched_items.prev_page_url)}}},[n("i",{staticClass:"fa fa-angle-double-left"}),t._v("\n                                "+t._s(t.__("previous","Previous"))+"\n                            ")]):t._e(),t._v(" "),t.searched_items.next_page_url?n("b-button",{attrs:{variant:"dark",size:"sm"},on:{click:function(e){return t.getCatProducts(t.searched_items.next_page_url)}}},[t._v("\n                                "+t._s(t.__("next","Next"))+"\n                                "),n("i",{staticClass:"fa fa-angle-double-right"})]):t._e()],1)],1)]},proxy:!0}])},[t._v(" "),n("b-form-row",t._l(t.searched_items.data,(function(e,r){return n("b-col",{key:r,staticClass:"mb-2",attrs:{md:"4",sm:"6"}},[n("b-card",{staticClass:"h-100",staticStyle:{"background-size":"cover",cursor:"pointer"},style:{backgroundImage:"url("+e.photo_url+")"},attrs:{"body-class":"text-white product-image",title:e.name},on:{click:function(n){return t.addProductToCart(e)}}},[n("table",[n("tr",[n("td",[t._v(t._s(t.__("code","Code")))]),t._v(" "),n("td",[t._v(": "+t._s(e.code))])]),t._v(" "),n("tr",[n("td",[t._v(t._s(t.__("price","Price")))]),t._v(" "),n("td",[t._v(": "+t._s(t._f("currency")(e.price)))])]),t._v(" "),n("tr",[n("td",[t._v(t._s(t.__("quantity","Quantity")))]),t._v(" "),n("td",[t._v(": "+t._s(t._f("localNumber")(e.quantity)))])])])])],1)})),1)],1)],1)],1),t._v(" "),n("b-modal",{attrs:{size:"xl","body-class":"p-0","header-bg-variant":"dark","header-text-variant":"light","footer-bg-variant":"dark","footer-text-variant":"light",title:t.__("purchase_invoice","Purchase Invoice"),id:"invoice-modal",lazy:"","no-close-on-backdrop":"","no-close-on-esc":""},on:{hidden:function(e){t.sale_id=null}},scopedSlots:t._u([{key:"modal-footer",fn:function(e){var r=e.close;return[n("b-button",{attrs:{variant:"primary"},on:{click:t.printInvoice}},[t._v("Print")]),t._v(" "),n("b-button",{attrs:{variant:"secondary"},on:{click:r}},[t._v("Close")])]}}])},[n("b-embed",{attrs:{id:"print_invoice",aspect:"16by9",allowfullscreen:"",src:t.route("Backend.Purchases.Invoice.PDF",{purchase:t.purchase_id,type:"pdf"})}})],1)],1)}),[],!1,null,null,null);e.default=m.exports},16:function(t,e,n){"use strict";e.a=[{text:_t("bank","Bank"),value:"Bank"},{text:_t("cash","Cash"),value:"Cash"},{text:_t("card","Card"),value:"Card"},{text:_t("bkash","bKash"),value:"bKash"},{text:_t("rocket","Rocket"),value:"Rocket"}]},19:function(t,e,n){"use strict";var r=n(0),o={props:{value:{type:null|Object,default:function(){return null}},api_url:{type:String,default:null,required:!0},prepend:{type:String,default:""},append:{type:String,default:""},placeholder:{type:String,default:"Search Items"},size:{type:String,default:"sm"},autocomplete:{type:String,default:"off"},dropdownVariant:{type:String,default:"outline-secondary"},emptyOptionText:{type:String,default:"No items available to select"},inputClass:{type:String|Array,default:function(){return[]}},menuStyle:{type:String|Array,default:function(){return[]}},clearSearchOnItemSelected:{type:Boolean,default:!1},initOptions:{type:Boolean|String,default:!1},required:{type:Boolean,default:!1},state:{type:Boolean,default:null},hideDdIcon:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},menuClass:{type:String|Object,default:function(){return""}},getFiltered:{type:Function},clearSearchOnDropdownHidden:{type:Boolean,default:function(){return!0}},optionText:{type:Function},tagText:{Type:Function}},data:function(){return{options:[],query:"",selected_item:null}},mounted:function(){this.initOptions&&(Object(r.a)(this.initOptions)&&this.initOptions?this.getItems(""):this.query=this.initOptions),this.$set(this,"selected_item",this.value)},computed:{getOptions:function(){return"function"==typeof this.getFiltered&&this.getFiltered?this.getFiltered(this.options):this.options}},watch:{value:{deep:!0,handler:function(t){this.$set(this,"selected_item",t)}}},methods:{reset:function(){this.$emit("input",null),this.$set(this,"selected_item",null),this.query=""},itemSelected:function(t){this.$emit("input",t),this.$set(this,"selected_item",t),this.clearSearchOnItemSelected&&(this.query=null)},getItems:function(t){var e=this;axios.post(this.api_url,{query:this.query}).then((function(t){e.$set(e,"options",t.data||[])})).catch((function(t){e.$set(e,"options",[]),console.error(t.response)}))}}},i=(n(73),n(1)),a=Object(i.a)(o,(function(){var t=this,e=this,n=e.$createElement,r=e._self._c||n;return r("div",{staticClass:"vue-select form-control p-0",class:{"is-invalid":null!==e.state&&e.state,"is-valid":null!==e.state&&!e.state}},[e.required?r("input",{staticStyle:{height:"0",position:"absolute",top:"0",border:"0",outline:"0","z-index":"-1"},attrs:{type:"text",required:!0},domProps:{value:e.value?"initialized":""}}):e._e(),e._v(" "),r("b-dropdown",{class:{"hide-dd-icon":e.hideDdIcon,disabled:e.disabled},style:e.menuStyle,attrs:{block:"",lazy:"",variant:e.dropdownVariant,disabled:e.disabled,"toggle-class":"text-left m-0 border-0 border-radius-0","menu-class":e.menuClass},on:{hidden:function(){e.$emit("hidden",!0),t.clearSearchOnDropdownHidden&&(t.query="")}},scopedSlots:e._u([{key:"button-content",fn:function(){return[e._t("tag",[e._v("\n                "+e._s("function"==typeof e.tagText?e.tagText(e.selected_item):(e.selected_item,e.placeholder))+"\n            ")],{tag:e.selected_item})]},proxy:!0}],null,!0)},[e._v(" "),r("div",{staticClass:"px-2"},[r("b-form-input",{class:e.inputClass,attrs:{autofocus:"",type:"search",size:e.size,placeholder:e.placeholder,autocomplete:e.autocomplete},on:{keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter"))return null;t.preventDefault()},input:function(t){return e.getItems(t)}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}})],1),e._v(" "),r("b-dropdown-divider"),e._v(" "),e._l(e.getOptions,(function(t,n){return r("b-dropdown-item",{key:n,on:{click:function(n){return e.itemSelected(t)}}},[e._t("option",[e._v("\n                "+e._s("function"==typeof e.optionText?e.optionText(t):t)+"\n            ")],{item:t,query:e.query})],2)})),e._v(" "),0===e.options.length?[e._t("empty",[0===e.options.length?r("b-dropdown-text",[e._v("\n                    "+e._s(e.emptyOptionText)+"\n                ")]):e._e()],{query:e.query})]:e._e(),e._v(" "),e._t("default_item",null,{query:e.query})],2)],1)}),[],!1,null,null,null);e.a=a.exports},25:function(t,e,n){"use strict";e.a=[{text:_t("returned","Returned"),value:"Returned"},{text:_t("processed","Processed"),value:"Processed"},{text:_t("cancelled","Cancelled"),value:"Cancelled"}]},34:function(t,e,n){var r=n(17),o=n(74);"string"==typeof(o=o.__esModule?o.default:o)&&(o=[[t.i,o,""]]);var i={insert:"head",singleton:!1};r(o,i);t.exports=o.locals||{}},39:function(t,e,n){var r=n(17),o=n(82);"string"==typeof(o=o.__esModule?o.default:o)&&(o=[[t.i,o,""]]);var i={insert:"head",singleton:!1};r(o,i);t.exports=o.locals||{}},51:function(t,e,n){"use strict";var r={name:"Invoice"},o=n(1),i=Object(o.a)(r,(function(){var t=this.$createElement;return(this._self._c||t)("div")}),[],!1,null,"52743ccd",null);e.a=i.exports},73:function(t,e,n){"use strict";var r=n(34);n.n(r).a},74:function(t,e,n){(e=n(18)(!1)).push([t.i,".vue-select .dropdown-menu {\n  max-height: 300px;\n  overflow-y: auto;\n  width: 100%;\n}\n.vue-select .dropdown-toggle::after {\n  position: absolute;\n  right: 10px;\n  top: 49%;\n}\n.vue-select .border-radius-0 {\n  border-radius: 0 !important;\n}\n.vue-select .top-reverse-100 {\n  top: -100% !important;\n}\n.vue-select .hide-dd-icon .dropdown-toggle::after {\n  display: none !important;\n}\n.vue-select.is-invalid, .vue-select.is-valid {\n  background-position: right calc(1.4em + 0.1875rem) center !important;\n}",""]),t.exports=e},81:function(t,e,n){"use strict";var r=n(39);n.n(r).a},82:function(t,e,n){(e=n(18)(!1)).push([t.i,".product-image {\n  background-color: rgba(0, 0, 0, 0.8);\n}",""]),t.exports=e}}]);