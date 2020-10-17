(window.webpackJsonp=window.webpackJsonp||[]).push([[14],{166:function(t,e,a){"use strict";a.r(e);var n=a(8),r=a(7),s=a(2),o=a(9),i=a(19),l={name:"ExpensesList",components:{DtHeader:n.a,DtFooter:r.a,DtTable:o.a,VueSelect:i.a},mixins:[s.f],props:{title:{type:String,default:_t("expenses","Expenses")},api_url:{type:String,default:function(){return route("Backend.Expenses.List").url()}},trash_url:{type:String,default:function(){return route("Backend.Expenses.Delete").url()}},submit_url:{type:String,default:function(){return route("Backend.Expenses.Store").url()}},custom_buttons:{type:Array,default:function(){return[{text:_t("add","Add"),variant:"dark",to:{name:"ExpensesAdd"}},{text:_t("history","History"),variant:"primary",to:{name:"ModelHistory",params:{model:"expenses"}}}]}}},data:function(){var t=this;return{form:{},total_expense_amount:0,fields:[{key:"id",name:"expenses.id",sortable:!0,label:_t("id","ID")},{key:"expense_category_name",name:"expense_categories.name",label:_t("category","Category"),sortable:!0},{key:"amount",sortable:!0,label:_t("amount","Amount"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"reference",label:_t("reference","Reference"),sortable:!0},{key:"taken_by_name",name:"users.name",sortable:!0,label:_t("taken_by","Taken By")},{key:"description",name:"expenses.description",label:_t("description","Description"),sortable:!0,formatter:function(e){return t.$options.filters.truncate(e||"")}},{key:"created_at",name:"expenses.created_at",label:_t("created_at","Created At"),sortable:!0,formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"updated_at",name:"expenses.updated_at",label:_t("updated_at","Updated At"),sortable:!0,formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"action",label:_t("action","Action"),sortable:!1,searchable:!1,thClass:"text-right",tdClass:"text-right"}]}},methods:{colSum:s.d}},u=a(1),c=Object(u.a)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-row",{staticClass:"mb-3"},[a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-card",{attrs:{header:t.__("total_expense_amount","Total Expense Amount"),"bg-variant":"dark","text-variant":"light"}},[a("h4",[t._v(t._s(t._f("currency")(t.overview.total_expense_amount)))])])],1),t._v(" "),a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-card",{attrs:{header:t.__("total_expense_quantity","Total Expense Quantity"),"bg-variant":"dark","text-variant":"light"}},[a("h4",[t._v(t._s(t._f("localNumber")(t.overview.total_expense_quantity)))])])],1)],1),t._v(" "),a("dt-table",{attrs:{title:t.title,fields:t.fields,datatable:t.datatable,custom_buttons:t.custom_buttons,"enable-date-range":!0},on:{refreshDatatable:function(e){return t.$refs.datatable.refresh()}},scopedSlots:t._u([{key:"header_dropdowns",fn:function(){return[a("b-button",{directives:[{name:"b-toggle",rawName:"v-b-toggle:advanced_search",arg:"advanced_search"}],ref:"ht",attrs:{variant:"dark",size:"sm"}},[t._v("\n                "+t._s(t.__("more","More"))+"\n            ")])]},proxy:!0},{key:"header_bottom_panel",fn:function(){return[a("b-collapse",{staticClass:"mt-3",attrs:{id:"advanced_search"}},[a("b-form-row",[a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-input-group",{attrs:{prepend:t.__("category","Category")},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(e){t.datatable.search_columns.expense_category_id=void 0,t.datatable.expense_category=void 0}}},[t._v("\n                                    x\n                                ")])]},proxy:!0}])},[a("vue-select",{attrs:{"init-options":!0,required:!0,api_url:t.route("Backend.Expenses.Categories.Search").url()},on:{input:function(e){return t.$set(t.datatable.search_columns,"expense_category_id",e?e.id:void 0)}},scopedSlots:t._u([{key:"option",fn:function(e){return[t._v("\n                                    "+t._s([e.item.id,e.item.name].join(" # "))+"\n                                ")]}},{key:"tag",fn:function(e){return[t._v("\n                                    "+t._s(e.tag?[e.tag.id,e.tag.name].join(" # "):t.__("not_selected","Not Selected"))+"\n                                ")]}}]),model:{value:t.datatable.expense_category,callback:function(e){t.$set(t.datatable,"expense_category",e)},expression:"datatable.expense_category"}})],1)],1),t._v(" "),a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-input-group",{attrs:{prepend:t.__("reference","Reference")}},[a("b-input",{attrs:{type:"search",placeholder:t.__("reference","Reference")},model:{value:t.datatable.search_columns.reference,callback:function(e){t.$set(t.datatable.search_columns,"reference",e)},expression:"datatable.search_columns.reference"}})],1)],1)],1)],1)]},proxy:!0},{key:"table",fn:function(){return[a("b-table",{ref:"datatable",staticClass:"mb-0",attrs:{variant:"primary",responsive:"md",hover:"",bordered:"",small:"",striped:"","head-variant":"dark",items:t.getItems,fields:t.fields,"sort-by":t.datatable.sortBy,"sort-desc":t.datatable.sortDesc,filter:t.search,"per-page":t.datatable.per_page,"current-page":t.datatable.current_page,"foot-clone":"","foot-variant":"secondary"},on:{"update:sortBy":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sort-by":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sortDesc":function(e){return t.$set(t.datatable,"sortDesc",e)},"update:sort-desc":function(e){return t.$set(t.datatable,"sortDesc",e)},refreshed:function(e){t.overview=JSON.parse(t.headers.overview)}},scopedSlots:t._u([{key:"foot(amount)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"amount")))+"\n                ")]}},{key:"cell(action)",fn:function(e){return[a("b-button-group",{attrs:{size:"sm"}},[a("b-button",{attrs:{variant:"primary",title:t.__("view","View"),to:{name:"ExpensesView",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-eye"})]),t._v(" "),a("b-button",{attrs:{variant:"warning",title:t.__("edit","Edit"),to:{name:"ExpensesAdd",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-edit"})]),t._v(" "),a("b-button",{attrs:{variant:"danger",title:t.__("delete","Delete")},on:{click:function(a){return t.trash(e.item.id)}}},[a("i",{staticClass:"fa fa-trash"})])],1)]}}])})]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),a("router-view",{attrs:{item:t.currentItem},on:{reset:function(e){t.currentItem={}},refreshDatatable:function(){return t.$refs.datatable.refresh()}}})],1)}),[],!1,null,null,null);e.default=c.exports},19:function(t,e,a){"use strict";var n=a(0),r={props:{value:{type:null|Object,default:function(){return null}},api_url:{type:String,default:null,required:!0},prepend:{type:String,default:""},append:{type:String,default:""},placeholder:{type:String,default:"Search Items"},size:{type:String,default:"sm"},autocomplete:{type:String,default:"off"},dropdownVariant:{type:String,default:"outline-secondary"},emptyOptionText:{type:String,default:"No items available to select"},inputClass:{type:String|Array,default:function(){return[]}},menuStyle:{type:String|Array,default:function(){return[]}},clearSearchOnItemSelected:{type:Boolean,default:!1},initOptions:{type:Boolean|String,default:!1},required:{type:Boolean,default:!1},state:{type:Boolean,default:null},hideDdIcon:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},menuClass:{type:String|Object,default:function(){return""}},getFiltered:{type:Function},clearSearchOnDropdownHidden:{type:Boolean,default:function(){return!0}},optionText:{type:Function},tagText:{Type:Function}},data:function(){return{options:[],query:"",selected_item:null}},mounted:function(){this.initOptions&&(Object(n.a)(this.initOptions)&&this.initOptions?this.getItems(""):this.query=this.initOptions),this.$set(this,"selected_item",this.value)},computed:{getOptions:function(){return"function"==typeof this.getFiltered&&this.getFiltered?this.getFiltered(this.options):this.options}},watch:{value:{deep:!0,handler:function(t){this.$set(this,"selected_item",t)}}},methods:{reset:function(){this.$emit("input",null),this.$set(this,"selected_item",null),this.query=""},itemSelected:function(t){this.$emit("input",t),this.$set(this,"selected_item",t),this.clearSearchOnItemSelected&&(this.query=null)},getItems:function(t){var e=this;axios.post(this.api_url,{query:this.query}).then((function(t){e.$set(e,"options",t.data||[])})).catch((function(t){e.$set(e,"options",[]),console.error(t.response)}))}}},s=(a(73),a(1)),o=Object(s.a)(r,(function(){var t=this,e=this,a=e.$createElement,n=e._self._c||a;return n("div",{staticClass:"vue-select form-control p-0",class:{"is-invalid":null!==e.state&&e.state,"is-valid":null!==e.state&&!e.state}},[e.required?n("input",{staticStyle:{height:"0",position:"absolute",top:"0",border:"0",outline:"0","z-index":"-1"},attrs:{type:"text",required:!0},domProps:{value:e.value?"initialized":""}}):e._e(),e._v(" "),n("b-dropdown",{class:{"hide-dd-icon":e.hideDdIcon,disabled:e.disabled},style:e.menuStyle,attrs:{block:"",lazy:"",variant:e.dropdownVariant,disabled:e.disabled,"toggle-class":"text-left m-0 border-0 border-radius-0","menu-class":e.menuClass},on:{hidden:function(){e.$emit("hidden",!0),t.clearSearchOnDropdownHidden&&(t.query="")}},scopedSlots:e._u([{key:"button-content",fn:function(){return[e._t("tag",[e._v("\n                "+e._s("function"==typeof e.tagText?e.tagText(e.selected_item):(e.selected_item,e.placeholder))+"\n            ")],{tag:e.selected_item})]},proxy:!0}],null,!0)},[e._v(" "),n("div",{staticClass:"px-2"},[n("b-form-input",{class:e.inputClass,attrs:{autofocus:"",type:"search",size:e.size,placeholder:e.placeholder,autocomplete:e.autocomplete},on:{keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter"))return null;t.preventDefault()},input:function(t){return e.getItems(t)}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}})],1),e._v(" "),n("b-dropdown-divider"),e._v(" "),e._l(e.getOptions,(function(t,a){return n("b-dropdown-item",{key:a,on:{click:function(a){return e.itemSelected(t)}}},[e._t("option",[e._v("\n                "+e._s("function"==typeof e.optionText?e.optionText(t):t)+"\n            ")],{item:t,query:e.query})],2)})),e._v(" "),0===e.options.length?[e._t("empty",[0===e.options.length?n("b-dropdown-text",[e._v("\n                    "+e._s(e.emptyOptionText)+"\n                ")]):e._e()],{query:e.query})]:e._e(),e._v(" "),e._t("default_item",null,{query:e.query})],2)],1)}),[],!1,null,null,null);e.a=o.exports},33:function(t,e,a){var n=a(17),r=a(72);"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},34:function(t,e,a){var n=a(17),r=a(74);"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},7:function(t,e,a){"use strict";var n={props:{datatable:Object}},r=a(1),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},71:function(t,e,a){"use strict";var n=a(33);a.n(n).a},72:function(t,e,a){(e=a(18)(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e},73:function(t,e,a){"use strict";var n=a(34);a.n(n).a},74:function(t,e,a){(e=a(18)(!1)).push([t.i,".vue-select .dropdown-menu {\n  max-height: 300px;\n  overflow-y: auto;\n  width: 100%;\n}\n.vue-select .dropdown-toggle::after {\n  position: absolute;\n  right: 10px;\n  top: 49%;\n}\n.vue-select .border-radius-0 {\n  border-radius: 0 !important;\n}\n.vue-select .top-reverse-100 {\n  top: -100% !important;\n}\n.vue-select .hide-dd-icon .dropdown-toggle::after {\n  display: none !important;\n}\n.vue-select.is-invalid, .vue-select.is-valid {\n  background-position: right calc(1.4em + 0.1875rem) center !important;\n}",""]),t.exports=e},8:function(t,e,a){"use strict";var n=a(2),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:""}},mounted:function(){this.datatable.per_page=this.getPerPage()},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:n.b,startCase:n.u,range:n.p,setPerPage:n.s,getPerPage:n.h}},s=(a(71),a(1)),o=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"min-width":"150px","max-width":"200px"}},[a("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[a("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():a("div",{staticClass:"col",staticStyle:{"min-width":"150px"}},[a("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?a("div",{staticClass:"col"},[a("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[a("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),a("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),a("div",{staticClass:"col text-right"},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?a("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,n){return[e.to?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),a("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[a("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,n){return a("li",{key:n,staticClass:"list-group-item"},[a("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(a){return t.changeVisibility(e,n)}},model:{value:e.visible,callback:function(a){t.$set(e,"visible",a)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)]),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=o.exports},9:function(t,e,a){"use strict";var n=a(8),r=a(7),s={components:{DtHeader:n.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},o=a(1),i=Object(o.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[a("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=i.exports}}]);