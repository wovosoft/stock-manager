(window.webpackJsonp=window.webpackJsonp||[]).push([[30],{"4IVG":function(t,e,a){"use strict";var n={props:{datatable:Object}},r=a("KHd+"),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},"63QV":function(t,e,a){"use strict";var n=a("YXO7"),r=a("4IVG"),s={components:{DtHeader:n.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},i=a("KHd+"),o=Object(i.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[a("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=o.exports},EwT1:function(t,e,a){(e=a("JPst")(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e},SxBp:function(t,e,a){"use strict";a.r(e);var n=a("YXO7"),r=a("4IVG"),s=a("X/aF"),i=a("63QV"),o={name:"LanguagesList",components:{DtHeader:n.a,DtFooter:r.a,DtTable:i.a},mixins:[s.f],props:{title:{type:String,default:_t("languages","Languages")},api_url:{type:String,default:function(){return route("Backend.Languages.List")}},trash_url:{type:String,default:function(){return route("Backend.Languages.Delete")}},submit_url:{type:String,default:function(){return route("Backend.Languages.Store")}},custom_buttons:{type:Array,default:function(){return[{text:"Add",variant:"dark",to:{name:"LanguagesAdd"}}]}}},data:function(){var t=this;return{form:{},fields:[{key:"id",sortable:!0,label:this.__("id","ID")},{key:"name",sortable:!0,label:this.__("name","Name")},{key:"description",label:this.__("description","Description"),sortable:!0,formatter:function(e){return t.$options.filters.truncate(e||"")}},{key:"created_at",label:this.__("created_at","Created At"),visible:!1,sortable:!0,formatter:function(e){return t.dayjs(e)}},{key:"updated_at",visible:!1,label:this.__("updated_at","Updated At"),sortable:!0,formatter:function(e){return t.dayjs(e)}},{key:"action",label:this.__("action","Action"),sortable:!1,searchable:!1,thClass:"text-right",tdClass:"text-right"}]}}},l=a("KHd+"),c=Object(l.a)(o,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("dt-table",{attrs:{title:t.title,fields:t.fields,datatable:t.datatable,custom_buttons:t.custom_buttons},scopedSlots:t._u([{key:"table",fn:function(){return[a("b-table",{ref:"datatable",staticClass:"mb-0",attrs:{variant:"primary",responsive:"md",hover:"",bordered:"",small:"",striped:"","head-variant":"dark",items:t.getItems,fields:t.fields,"sort-by":t.datatable.sortBy,"sort-desc":t.datatable.sortDesc,filter:t.search,"per-page":t.datatable.per_page,"current-page":t.datatable.current_page},on:{"update:sortBy":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sort-by":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sortDesc":function(e){return t.$set(t.datatable,"sortDesc",e)},"update:sort-desc":function(e){return t.$set(t.datatable,"sortDesc",e)}},scopedSlots:t._u([{key:"cell(action)",fn:function(e){return[a("b-button-group",{attrs:{size:"sm"}},[a("b-button",{attrs:{variant:"primary",to:{name:"LanguagesView",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-eye"})]),t._v(" "),a("b-button",{attrs:{variant:"warning",to:{name:"LanguagesEdit",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-edit"})]),t._v(" "),a("b-button",{attrs:{variant:"danger"},on:{click:function(a){return t.trash(e.item.id)}}},[a("i",{staticClass:"fa fa-trash"})])],1)]}}])})]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),a("router-view",{attrs:{item:t.currentItem},on:{reset:function(e){t.currentItem={}},refreshDatatable:function(){return t.$refs.datatable.refresh()}}})],1)}),[],!1,null,null,null);e.default=c.exports},YXO7:function(t,e,a){"use strict";var n=a("X/aF"),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:"",the:void 0}},mounted:function(){this.datatable.per_page=this.getPerPage()},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:n.b,startCase:n.v,range:n.q,setPerPage:n.t,getPerPage:n.h}},s=(a("tuhp"),a("KHd+")),i=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"min-width":"150px","max-width":"200px"}},[a("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[a("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():a("div",{staticClass:"col",staticStyle:{"min-width":"150px"}},[a("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?a("div",{staticClass:"col"},[a("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[a("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),a("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),a("div",{staticClass:"col text-right"},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?a("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,n){return[e.to?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),a("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[a("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,n){return a("li",{key:n,staticClass:"list-group-item"},[a("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(a){return t.changeVisibility(e,n)}},model:{value:e.visible,callback:function(a){t.$set(e,"visible",a)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)]),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=i.exports},jUAY:function(t,e,a){var n=a("LboF"),r=a("EwT1");"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},tuhp:function(t,e,a){"use strict";var n=a("jUAY");a.n(n).a}}]);