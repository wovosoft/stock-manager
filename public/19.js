(window.webpackJsonp=window.webpackJsonp||[]).push([[19],{"3fRZ":function(t,e,n){"use strict";var a=n("ex6f"),r={props:{value:{type:null|Object,default:function(){return null}},api_url:{type:String,default:null,required:!0},prepend:{type:String,default:""},append:{type:String,default:""},placeholder:{type:String,default:"Search Items"},size:{type:String,default:"sm"},autocomplete:{type:String,default:"off"},dropdownVariant:{type:String,default:"outline-secondary"},emptyOptionText:{type:String,default:"No items available to select"},inputClass:{type:String|Array,default:function(){return[]}},menuStyle:{type:String|Array,default:function(){return[]}},clearSearchOnItemSelected:{type:Boolean,default:!1},initOptions:{type:Boolean|String,default:!1},required:{type:Boolean,default:!1},state:{type:Boolean,default:null},hideDdIcon:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},menuClass:{type:String|Object,default:function(){return""}},getFiltered:{type:Function},clearSearchOnDropdownHidden:{type:Boolean,default:function(){return!0}},optionText:{type:Function},tagText:{Type:Function}},data:function(){return{options:[],query:"",selected_item:null}},mounted:function(){this.initOptions&&(Object(a.a)(this.initOptions)&&this.initOptions?this.getItems(""):this.query=this.initOptions),this.$set(this,"selected_item",this.value)},computed:{getOptions:function(){return"function"==typeof this.getFiltered&&this.getFiltered?this.getFiltered(this.options):this.options}},watch:{value:{deep:!0,handler:function(t){this.$set(this,"selected_item",t)}}},methods:{reset:function(){this.$emit("input",null),this.$set(this,"selected_item",null),this.query=""},itemSelected:function(t){this.$emit("input",t),this.$set(this,"selected_item",t),this.clearSearchOnItemSelected&&(this.query=null)},getItems:function(t){var e=this;axios.post(this.api_url,{query:this.query}).then((function(t){e.$set(e,"options",t.data||[])})).catch((function(t){e.$set(e,"options",[]),console.error(t.response)}))}}},i=(n("c9im"),n("KHd+")),o=Object(i.a)(r,(function(){var t=this,e=this,n=e.$createElement,a=e._self._c||n;return a("div",{staticClass:"vue-select form-control p-0",class:{"is-invalid":null!==e.state&&e.state,"is-valid":null!==e.state&&!e.state,"form-control-sm":"sm"===e.size,"form-control-lg":"lg"===e.size,"form-control-xl":"xl"===e.size}},[e.required?a("input",{staticStyle:{height:"0",position:"absolute",top:"0",border:"0",outline:"0","z-index":"-1"},attrs:{type:"text",required:!0},domProps:{value:e.value?"initialized":""}}):e._e(),e._v(" "),a("b-dropdown",{class:{"hide-dd-icon":e.hideDdIcon,disabled:e.disabled},style:e.menuStyle,attrs:{block:"",lazy:"",variant:e.dropdownVariant,size:e.size,disabled:e.disabled,"toggle-class":"text-left m-0 border-0 border-radius-0","menu-class":e.menuClass},on:{hidden:function(){e.$emit("hidden",!0),t.clearSearchOnDropdownHidden&&(t.query="")}},scopedSlots:e._u([{key:"button-content",fn:function(){return[e._t("tag",[e._v("\n                "+e._s("function"==typeof e.tagText?e.tagText(e.selected_item):(e.selected_item,e.placeholder))+"\n            ")],{tag:e.selected_item})]},proxy:!0}],null,!0)},[e._v(" "),a("div",{staticClass:"px-2"},[a("b-form-input",{class:e.inputClass,attrs:{autofocus:"",type:"search",size:e.size,placeholder:e.placeholder,autocomplete:e.autocomplete},on:{keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter"))return null;t.preventDefault()},input:function(t){return e.getItems(t)}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}})],1),e._v(" "),a("b-dropdown-divider"),e._v(" "),e._l(e.getOptions,(function(t,n){return a("b-dropdown-item",{key:n,on:{click:function(n){return e.itemSelected(t)}}},[e._t("option",[e._v("\n                "+e._s("function"==typeof e.optionText?e.optionText(t):t)+"\n            ")],{item:t,query:e.query})],2)})),e._v(" "),0===e.options.length?[e._t("empty",[0===e.options.length?a("b-dropdown-text",[e._v("\n                    "+e._s(e.emptyOptionText)+"\n                ")]):e._e()],{query:e.query})]:e._e(),e._v(" "),e._t("default_item",null,{query:e.query})],2)],1)}),[],!1,null,null,null);e.a=o.exports},"4IVG":function(t,e,n){"use strict";var a={props:{datatable:Object}},r=n("KHd+"),i=Object(r.a)(a,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"row"},[n("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),n("div",{staticClass:"col"},[n("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=i.exports},"63QV":function(t,e,n){"use strict";var a=n("YXO7"),r=n("4IVG"),i={components:{DtHeader:a.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},o=n("KHd+"),s=Object(o.a)(i,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[n("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[n("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=s.exports},EwT1:function(t,e,n){(e=n("JPst")(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e},J8vp:function(t,e,n){"use strict";n.r(e);var a=n("YXO7"),r=n("4IVG"),i=n("X/aF"),o=n("63QV"),s={name:"Add",components:{VueSelect:n("3fRZ").a},props:{item:{type:Object,default:null}},data:function(){return{supplier:null,product_temp:null,form:{supplier_id:null,items:[]}}},mounted:function(){var t=this;this.item&&(this.item.items||this.$set(this.item,"items",[]),this.item.supplier_id&&axios.post(route("Backend.Suppliers.GetByID",{id:this.item.supplier_id})).then((function(e){t.supplier=e.data})).catch((function(t){console.log(t.response)})),this.$set(this,"form",this.item))},methods:{colSum:i.d,resetForm:function(){this.supplier=null,this.product_temp=null,this.$set(this,"form",{supplier_id:null,items:[]})},addProduct:function(t){this.form.items.map((function(t){return t.product_id})).includes(t.id)?this.form.items.find((function(e){return e.product_id===t.id})).quantity++:this.form.items.push({name:t.name,product_id:t.id,amount:t.price,quantity:1})},handleSubmit:function(){var t=this;Array.isArray(this.form.items)&&this.form.items.length>0&&axios.post(route("Backend.PurchaseReturns.Store"),this.form).then((function(e){t.$root.msgBox(e.data),t.resetForm(),t.$emit("refresh",!0),t.$emit("hideModal",!0)})).catch((function(e){console.log(e.response),t.$root.msgBox(e.response)}))}}},l=n("KHd+"),u=Object(l.a)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-form",{on:{submit:function(e){return e.preventDefault(),t.handleSubmit(e)}}},[n("b-form-row",[n("b-col",{attrs:{md:"12",sm:"12"}},[n("b-form-group",{attrs:{label:t.__("supplier","Supplier")}},[n("b-input-group",{scopedSlots:t._u([{key:"append",fn:function(){return[n("b-button",{staticClass:"font-weight-bold",on:{click:function(e){t.supplier=null,t.form.supplier_id=null}}},[t._v("\n                            X\n                        ")])]},proxy:!0}])},[n("vue-select",{attrs:{"init-options":!0,required:!0,"tag-text":function(e){return e?[e.id,e.name,e.phone,e.village].join(" # "):t.__("not_selected","Not Selected")},"option-text":function(t){return t?[t.id,t.name,t.phone,t.village].join(" # "):""},api_url:t.route("Backend.Suppliers.Search")},on:{input:function(e){return t.form.supplier_id=e?e.id:null}},model:{value:t.supplier,callback:function(e){t.supplier=e},expression:"supplier"}})],1)],1)],1)],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("select_product","Select Product")}},[n("b-input-group",[n("vue-select",{ref:"productSelector",attrs:{"get-filtered":function(e){return e.filter((function(e){return!t.form.items.map((function(t){return t.code})).includes(e.code)}))},"init-options":!0,"option-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Products.Search")},on:{input:function(e){return t.addProduct(e)}},model:{value:t.product_temp,callback:function(e){t.product_temp=e},expression:"product_temp"}})],1),t._v(" "),n("b-table",{attrs:{"head-variant":"dark",small:"",hover:"",responsive:"",striped:"",bordered:"","foot-clone":"","foot-variant":"light","show-empty":"",items:t.form.items,fields:["product_id",{key:"name",label:t.__("name")},{key:"quantity",label:t.__("quantity")},{key:"amount",label:t.__("amount","Amount")},{key:"action",label:t.__("action"),tdClass:"text-right",thClass:"text-right"}]},scopedSlots:t._u([{key:"cell(quantity)",fn:function(e){return[n("input",{directives:[{name:"model",rawName:"v-model",value:e.item.quantity,expression:"row.item.quantity"}],staticClass:"border-0",staticStyle:{width:"100px"},attrs:{type:"number",step:"any"},domProps:{value:e.item.quantity},on:{input:function(n){n.target.composing||t.$set(e.item,"quantity",n.target.value)}}})]}},{key:"cell(amount)",fn:function(e){return[n("input",{directives:[{name:"model",rawName:"v-model",value:e.item.amount,expression:"row.item.amount"}],staticClass:"border-0",staticStyle:{width:"100px"},attrs:{type:"number",step:"any"},domProps:{value:e.item.amount},on:{input:function(n){n.target.composing||t.$set(e.item,"amount",n.target.value)}}})]}},{key:"cell(action)",fn:function(e){return[n("b-button",{attrs:{size:"sm",variant:"danger",title:"Remove"},on:{click:function(n){return t.form.items.splice(e.index,1)}}},[n("i",{staticClass:"fa fa-trash"})])]}},{key:"foot(amount)",fn:function(e){return[t._v("\n                "+t._s(t._f("currency")(t.colSum(t.form.items,"amount")))+"\n            ")]}},{key:"foot(quantity)",fn:function(e){return[t._v("\n                "+t._s(t._f("localNumber")(t.colSum(t.form.items,"quantity")))+"\n            ")]}}])})],1),t._v(" "),n("b-button",{attrs:{block:"",variant:"dark",type:"submit"}},[t._v("SUBMIT")])],1)}),[],!1,null,null,null).exports,c={name:"PurchaseReturnList",components:{DtHeader:a.a,DtFooter:r.a,DtTable:o.a,ReturnsAdd:u},mixins:[i.f],props:{title:{type:String,default:" Returns"},api_url:{type:String,default:function(){return route("Backend.PurchaseReturns.List")}},trash_url:{type:String,default:function(){return route("Backend.PurchaseReturns.Delete")}},submit_url:{type:String,default:function(){return route("Backend.PurchaseReturns.Store")}},custom_buttons:{type:Array,default:function(){return[]}}},methods:{colSum:i.d,setDataForEdit:function(t){this.$set(this,"form",{supplier_id:t.supplier_id,items:[{id:t.id,name:t.product.name,product_id:t.product_id,amount:t.amount,quantity:t.quantity}]}),this.$bvModal.show("returns-add")}},beforeMount:function(){var t=new Date;this.datatable.search_columns.starting_date=[t.getFullYear(),t.getMonth()+1,t.getDate()].join("-")},data:function(){var t=this;return{form:{},fields:[{key:"id",sortable:!0,label:_t("id","ID")},{key:"supplier_id",sortable:!0,label:_t("supplier","Supplier"),formatter:function(t,e,n){var a=n.supplier;return[a.id,a.name,a.village].join(" | ")}},{key:"product_id",sortable:!0,label:_t("product","Product"),formatter:function(t,e,n){var a=n.product;return[a.id,a.name].join(" # ")}},{key:"quantity",sortable:!0,label:_t("quantity","Quantity"),formatter:function(e){return t.$options.filters.localNumber(e)}},{key:"amount",sortable:!0,label:_t("amount","Amount"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"created_at",sortable:!0,label:_t("created_at","Created At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"updated_at",sortable:!0,visible:!1,label:_t("updated_at","Updated At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"action",sortable:!1,label:_t("action","Action"),searchable:!1,thClass:"text-right",tdClass:"text-right"}]}}},d=Object(l.a)(c,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("dt-table",{attrs:{title:t.__(t.title,t.startCase(t.title)),"enable-date-range":"",fields:t.fields,datatable:t.datatable,custom_buttons:t.custom_buttons},on:{refreshDatatable:function(e){return t.$refs.datatable.refresh()}},scopedSlots:t._u([{key:"table",fn:function(){return[n("b-table",t._b({ref:"datatable",scopedSlots:t._u([{key:"cell(action)",fn:function(e){return[n("b-button-group",{attrs:{size:"sm"}},[n("b-button",{attrs:{variant:"primary",title:t.__("view","View"),to:{name:"PurchaseReturnsView",params:{id:e.item.id}}},on:{click:function(n){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[n("i",{staticClass:"fa fa-eye"})]),t._v(" "),n("b-button",{attrs:{variant:"warning",title:t.__("edit","Edit")},on:{click:function(n){return t.setDataForEdit(e.item)}}},[n("i",{staticClass:"fa fa-edit"})]),t._v(" "),n("b-button",{attrs:{variant:"danger",title:t.__("delete","Delete")},on:{click:function(n){return t.trash(e.item.id)}}},[n("i",{staticClass:"fa fa-trash"})])],1)]}},{key:"foot(quantity)",fn:function(e){return[t._v("\n                    "+t._s(t._f("localNumber")(t.colSum(t.datatable.items,"quantity")))+"\n                ")]}},{key:"foot(amount)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"amount")))+"\n                ")]}}])},"b-table",t.commonDtOptions(),!1))]},proxy:!0},{key:"header_dropdowns",fn:function(){return[n("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal:returns-add",arg:"returns-add"}],attrs:{size:"sm",variant:"primary"}},[t._v("\n                "+t._s(t.__("add","Add"))+"\n            ")])]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),n("b-modal",{attrs:{id:"returns-add","hide-footer":"",size:"lg",title:"Add Return","header-bg-variant":"dark","header-text-variant":"light"},on:{hidden:function(e){t.form={}}},scopedSlots:t._u([{key:"default",fn:function(e){var a=e.hide;return[n("returns-add",{attrs:{item:t.form},on:{refresh:function(e){t.$refs.datatable.refresh(),a()}}})]}}])}),t._v(" "),n("router-view",{attrs:{item:t.currentItem},on:{reset:function(e){t.currentItem={}},refreshDatatable:function(){return t.$refs.datatable.refresh()}}})],1)}),[],!1,null,null,null);e.default=d.exports},QK5V:function(t,e,n){var a=n("LboF"),r=n("xA+E");"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var i={insert:"head",singleton:!1};a(r,i);t.exports=r.locals||{}},YXO7:function(t,e,n){"use strict";var a=n("X/aF"),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:"",the:void 0,col_size:2}},mounted:function(){this.datatable.per_page=this.getPerPage(),this.noSearch||this.col_size++,this.enableDateRange&&this.col_size++},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:a.b,startCase:a.v,range:a.q,setPerPage:a.t,getPerPage:a.h}},i=(n("tuhp"),n("KHd+")),o=Object(i.a)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("b-row",[n("b-col",{staticClass:"mb-2 mb-md-0",staticStyle:{"min-width":"150px"},attrs:{md:"2",sm:"12"}},[n("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[n("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():n("b-col",{staticClass:"mb-2 mb-md-0",staticStyle:{"min-width":"150px"},attrs:{md:"3",sm:"12"}},[n("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?n("b-col",{staticClass:"mb-2 mb-md-0",attrs:{md:"3",sm:"12"}},[n("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[n("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[n("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),n("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),n("b-col",{staticClass:"text-right",attrs:{md:t.enableDateRange?4:7,sm:"12"}},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?n("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,a){return[e.to?n("b-button",{key:a,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?n("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?n("b-button",{key:a,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?n("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):n("b-button",{key:a,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?n("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),n("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[n("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,a){return n("li",{key:a,staticClass:"list-group-item"},[n("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(n){return t.changeVisibility(e,a)}},model:{value:e.visible,callback:function(n){t.$set(e,"visible",n)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)],1),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=o.exports},c9im:function(t,e,n){"use strict";var a=n("QK5V");n.n(a).a},jUAY:function(t,e,n){var a=n("LboF"),r=n("EwT1");"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var i={insert:"head",singleton:!1};a(r,i);t.exports=r.locals||{}},tuhp:function(t,e,n){"use strict";var a=n("jUAY");n.n(a).a},"xA+E":function(t,e,n){(e=n("JPst")(!1)).push([t.i,".vue-select .dropdown-menu {\n  max-height: 300px;\n  overflow-y: auto;\n  width: 100%;\n}\n.vue-select .dropdown-toggle::after {\n  position: absolute;\n  right: 10px;\n  top: 49%;\n}\n.vue-select .border-radius-0 {\n  border-radius: 0 !important;\n}\n.vue-select .top-reverse-100 {\n  top: -100% !important;\n}\n.vue-select .hide-dd-icon .dropdown-toggle::after {\n  display: none !important;\n}\n.vue-select.is-invalid, .vue-select.is-valid {\n  background-position: right calc(1.4em + 0.1875rem) center !important;\n}",""]),t.exports=e}}]);