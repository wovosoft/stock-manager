(window.webpackJsonp=window.webpackJsonp||[]).push([[20],{"4IVG":function(t,e,a){"use strict";var n={props:{datatable:Object}},r=a("KHd+"),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},"63QV":function(t,e,a){"use strict";var n=a("YXO7"),r=a("4IVG"),s={components:{DtHeader:n.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},o=a("KHd+"),i=Object(o.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[a("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=i.exports},EwT1:function(t,e,a){(e=a("JPst")(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e},TwBE:function(t,e,a){"use strict";a.r(e);var n=a("YXO7"),r=a("4IVG"),s=a("X/aF"),o=a("63QV"),i={mixins:[a("j01/").a],props:{expenseCategoryId:{type:Number,required:!0},submit_url:{type:String,default:function(){return route("Backend.Expenses.Store")}}},mounted:function(){this.$set(this.form,"expense_category_id",this.expenseCategoryId)},methods:{hitSubmit:function(){this.$refs.theForm.reportValidity()&&this.onSubmit()}}},l=a("KHd+"),u=Object(l.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("form",{ref:"theForm",on:{submit:function(e){return e.preventDefault(),t.hitSubmit(e)}}},[a("b-form-group",{attrs:{label:t.__("amount","Amount")+" *"}},[a("b-input",{attrs:{type:"number",step:"any",placeholder:t.__("expense_amount","Expense Amount"),required:!0},model:{value:t.form.amount,callback:function(e){t.$set(t.form,"amount",e)},expression:"form.amount"}})],1),t._v(" "),a("b-form-group",{attrs:{label:t.__("reference","Reference")}},[a("b-input",{attrs:{type:"text",placeholder:t.__("expense_reference","Expense Reference")},model:{value:t.form.reference,callback:function(e){t.$set(t.form,"reference",e)},expression:"form.reference"}})],1),t._v(" "),a("b-form-group",{attrs:{label:t.__("description","Description")}},[a("b-form-textarea",{attrs:{placeholder:t.__("description","Description")},model:{value:t.form.description,callback:function(e){t.$set(t.form,"description",e)},expression:"form.description"}})],1),t._v(" "),a("b-button",{attrs:{variant:"dark",type:"submit",block:""}},[t._v("\n            "+t._s(t.__("submit","SUBMIT"))+"\n        ")])],1)}),[],!1,null,"5e8be2d9",null).exports,c={name:"ExpenseCategoriesList",components:{DtHeader:n.a,DtFooter:r.a,DtTable:o.a,AddExpense:u},mixins:[s.f],props:{title:{type:String,default:_t("expense_categories","Expense Categories")},api_url:{type:String,default:function(){return route("Backend.Expenses.Categories.List")}},trash_url:{type:String,default:function(){return route("Backend.Expenses.Categories.Delete")}},submit_url:{type:String,default:function(){return route("Backend.Expenses.Categories.Store")}},custom_buttons:{type:Array,default:function(){return[{text:_t("add","Add"),title:_t("new_category","New Category"),variant:"dark",to:{name:"ExpenseCategoriesAdd"}},{text:_t("history","History"),variant:"primary",to:{name:"ModelHistory",params:{model:"expense_categories"}}}]}}},methods:{colSum:s.d},data:function(){var t=this;return{form:{},fields:[{key:"id",name:"expense_categories.id",sortable:!0,label:_t("id","ID")},{key:"name",name:"expense_categories.name",sortable:!0,label:_t("name","Name")},{key:"total_expense_quantity",sortable:!0,searchable:!1,label:_t("total_expense_quantity","Total Expenses Quantity"),formatter:function(e){return t.$options.filters.localNumber(e)}},{key:"total_expense_amount",sortable:!0,searchable:!1,label:_t("total_expense_amount","Total Expenses Amount"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"description",name:"expense_categories.description",label:_t("description","Description"),sortable:!0,formatter:function(e){return t.$options.filters.truncate(e||"")}},{key:"created_at",name:"expense_categories.created_at",sortable:!0,label:_t("created_at","Created At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"updated_at",name:"expense_categories.updated_at",sortable:!0,label:_t("updated_at","Updated At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"action",sortable:!1,label:_t("action","Action"),searchable:!1,thClass:"text-right",tdClass:"text-right"}]}}},d=Object(l.a)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-row",{staticClass:"mb-3"},[a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-card",{attrs:{header:t.__("total_expense_amount","Total Expense Amount"),"bg-variant":"dark","text-variant":"light"}},[a("h4",[t._v(t._s(t._f("currency")(t.overview.total_expense_amount)))])])],1),t._v(" "),a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-card",{attrs:{header:t.__("total_expense_quantity","Total Expense Quantity"),"bg-variant":"dark","text-variant":"light"}},[a("h4",[t._v(t._s(t._f("localNumber")(t.overview.total_expense_quantity)))])])],1)],1),t._v(" "),a("dt-table",{attrs:{title:t.title,fields:t.fields,datatable:t.datatable,custom_buttons:t.custom_buttons},scopedSlots:t._u([{key:"table",fn:function(){return[a("b-table",{ref:"datatable",staticClass:"mb-0",attrs:{variant:"primary",responsive:"md",hover:"",bordered:"",small:"",striped:"","head-variant":"dark",items:t.getItems,fields:t.fields,"sort-by":t.datatable.sortBy,"sort-desc":t.datatable.sortDesc,filter:t.search,"per-page":t.datatable.per_page,"current-page":t.datatable.current_page,"foot-clone":"","foot-variant":"light"},on:{refreshed:function(e){t.overview=JSON.parse(t.headers.overview)},"update:sortBy":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sort-by":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sortDesc":function(e){return t.$set(t.datatable,"sortDesc",e)},"update:sort-desc":function(e){return t.$set(t.datatable,"sortDesc",e)}},scopedSlots:t._u([{key:"foot(total_expense_amount)",fn:function(e){return[t._v("\n                        "+t._s(t._f("currency")(t.colSum(t.datatable.items,"total_expense_amount")))+"\n                    ")]}},{key:"foot(total_expense_quantity)",fn:function(e){return[t._v("\n                        "+t._s(t._f("localNumber")(t.colSum(t.datatable.items,"total_expense_quantity")))+"\n                    ")]}},{key:"cell(action)",fn:function(e){return[a("b-button-group",{attrs:{size:"sm"}},[a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal:addExpenseModal",arg:"addExpenseModal"}],attrs:{variant:"dark",title:t.__("add_expense","Add Expense")},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-plus"})]),t._v(" "),a("b-button",{attrs:{variant:"primary",title:t.__("view","View"),to:{name:"ExpenseCategoriesView",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-eye"})]),t._v(" "),a("b-button",{attrs:{variant:"warning",title:t.__("edit","Edit"),to:{name:"ExpenseCategoriesAdd",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-edit"})]),t._v(" "),a("b-button",{attrs:{variant:"danger",title:t.__("delete","Delete")},on:{click:function(a){return t.trash(e.item.id)}}},[a("i",{staticClass:"fa fa-trash"})])],1)]}}])})]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),a("router-view",{attrs:{item:t.currentItem},on:{reset:function(e){t.currentItem={}},refreshDatatable:function(){return t.$refs.datatable.refresh()}}}),t._v(" "),t.currentItem&&t.currentItem.id?a("b-modal",{attrs:{id:"addExpenseModal","hide-footer":"","body-class":"p-2",lazy:"",title:t.__("add_expense","Add Expense"),"header-bg-variant":"dark","header-text-variant":"light"},on:{hidden:function(e){t.currentItem={}}},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.hide;return[a("add-expense",{attrs:{"expense-category-id":t.currentItem.id},on:{created:function(t){return n()},refreshDatatable:function(){return t.$refs.datatable.refresh()}}})]}}],null,!1,3790644167)}):t._e()],1)}),[],!1,null,null,null);e.default=d.exports},YXO7:function(t,e,a){"use strict";var n=a("X/aF"),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:"",the:void 0}},mounted:function(){this.datatable.per_page=this.getPerPage()},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:n.b,startCase:n.v,range:n.q,setPerPage:n.t,getPerPage:n.h}},s=(a("tuhp"),a("KHd+")),o=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"min-width":"150px","max-width":"200px"}},[a("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[a("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():a("div",{staticClass:"col",staticStyle:{"min-width":"150px"}},[a("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?a("div",{staticClass:"col"},[a("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[a("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),a("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),a("div",{staticClass:"col text-right"},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?a("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,n){return[e.to?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),a("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[a("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,n){return a("li",{key:n,staticClass:"list-group-item"},[a("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(a){return t.changeVisibility(e,n)}},model:{value:e.visible,callback:function(a){t.$set(e,"visible",a)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)]),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=o.exports},"j01/":function(t,e,a){"use strict";var n=a("X/aF");e.a={props:{getCreatedItem:{type:Boolean,default:!1},item:{type:Object,default:function(){return{}}}},mounted:function(){this.form=this.item,Object(n.i)(this,(function(){}))},data:function(){return{form:{},errors:null,visible:!0}},methods:{getItem:n.g,onSubmit:n.o,hitSubmit:function(){this.$refs.submitBtn.click()},hasError:function(t){return!!(this.errors&&this.errors[t]&&this.errors[t].length)},getErrorMsg:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:",";return this.hasError(t)?this.errors[t].join(e):""}}}},jUAY:function(t,e,a){var n=a("LboF"),r=a("EwT1");"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},tuhp:function(t,e,a){"use strict";var n=a("jUAY");a.n(n).a}}]);