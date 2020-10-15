(window.webpackJsonp=window.webpackJsonp||[]).push([[28],{10:function(t,e,a){"use strict";var n=a(9),r=a(7),s={components:{DtHeader:n.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},o=a(1),l=Object(o.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[a("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=l.exports},161:function(t,e,a){"use strict";a.r(e);var n=a(9),r=a(7),s=a(2),o=a(10),l=a(30),i=a.n(l),c=a(86),u=a.n(c),d=a(88);u()(i.a);var _={name:"CapitalDepositsList",components:{DtHeader:n.a,DtFooter:r.a,DtTable:o.a,Highcharts:Object(d.a)("Highcharts",i.a)},mixins:[s.d],props:{title:{type:String,default:_t("capital_debit_credit","Capital Debit Credit")},api_url:{type:String,default:function(){return route("Backend.Capital.Balance").url()}},custom_buttons:{type:Array,default:function(){return[]}}},methods:{colSum:s.c,colCount:s.b},data:function(){var t=this;return{overview:{total_deposit:0,total_withdrawals:0,balance:0},chartOptions:{chart:{type:"bar"},title:{text:_t("funding_overview","Funding Overview")},subtitle:{text:_t("overview","Overview")},xAxis:{title:{text:_t("amount","Amount")},categories:[]},yAxis:{title:{text:_t("funds","Funds")}},plotOptions:{line:{dataLabels:{enabled:!0},enableMouseTracking:!1}},series:[{name:_t("deposit_amount","Deposit Amount"),data:[0]},{name:_t("withdrawal_amount","Withdrawal Amount"),data:[0]},{name:_t("balance","Balance"),data:[0]}]},fields:[{key:"id",sortable:!0,label:_t("id","ID")},{key:"created_at",sortable:!0,label:_t("created_at","Created At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"debit",label:_t("debit","Debit"),sortable:!0,formatter:function(e){return e?t.$options.filters.currency(e):""}},{key:"credit",label:_t("credit","Credit"),sortable:!0,formatter:function(e){return e?t.$options.filters.currency(e):""}},{key:"payment_amount",label:_t("payment_amount","Payment Amount"),sortable:!0,formatter:function(e){return t.$options.filters.currency(e)}},{key:"payment_method",label:_t("payment_method","Payment Method"),sortable:!0},{key:"bank",sortable:!0,label:_t("bank","Bank")},{key:"check_no",sortable:!0,label:_t("check_no","Check No.")},{key:"transaction_no",sortable:!0,label:_t("transaction_no","Transaction No.")},{key:"type",sortable:!0,label:_t("type","Type")}]}}},b=a(1),p=Object(b.a)(_,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-row",{staticClass:"mb-3"},[a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-card",{staticClass:"h-100",attrs:{header:t.__("overview","Overview"),"body-class":"p-2","bg-variant":"dark","text-variant":"light"}},[a("table",{staticClass:"table table-sm table-hover table-borderless table-striped text-white"},[a("tr",[a("th",[t._v(t._s(t.__("total_deposit","Total Deposit")))]),t._v(" "),a("td",[t._v(t._s(t._f("currency")(t.overview.total_deposit)))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("total_withdrawals","Total Withdrawals")))]),t._v(" "),a("td",[t._v(t._s(t._f("currency")(t.overview.total_withdrawals)))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("balance","Balance")))]),t._v(" "),a("td",[t._v(t._s(t._f("currency")(t.overview.balance)))])])])])],1),t._v(" "),a("b-col",{attrs:{md:"8",sm:"12"}},[a("b-card",{attrs:{"no-body":""}},[a("Highcharts",{attrs:{options:t.chartOptions}})],1)],1)],1),t._v(" "),a("dt-table",{attrs:{title:t.title,fields:t.fields,datatable:t.datatable,"enable-date-range":"","no-search":"",custom_buttons:t.custom_buttons},on:{refreshDatatable:function(e){return t.$refs.datatable.refresh()}},scopedSlots:t._u([{key:"table",fn:function(){return[a("b-table",{ref:"datatable",staticClass:"mb-0",attrs:{variant:"primary",responsive:"md",hover:"",bordered:"",small:"",striped:"","head-variant":"dark",items:t.getItems,fields:t.fields,"sort-by":t.datatable.sortBy,"sort-desc":t.datatable.sortDesc,filter:t.search,"sort-by":"created_at","sort-desc":"","foot-clone":"","foot-variant":"light","per-page":t.datatable.per_page,"current-page":t.datatable.current_page},on:{"update:sortBy":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sort-by":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sortDesc":function(e){return t.$set(t.datatable,"sortDesc",e)},"update:sort-desc":function(e){return t.$set(t.datatable,"sortDesc",e)},refreshed:function(){t.overview=JSON.parse(t.headers.overview||"{}"),t.chartOptions.series[0].data=[t.overview.total_deposit],t.chartOptions.series[1].data=[t.overview.total_withdrawals],t.chartOptions.series[2].data=[t.overview.balance]}},scopedSlots:t._u([{key:"foot(id)",fn:function(e){return[t._v("\n                    "+t._s(t.__("total","Total"))+" "+t._s(t._f("localNumber")(t.colCount(t.datatable.items,"id")))+"\n                ")]}},{key:"foot(debit)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"debit")))+"\n                ")]}},{key:"foot(credit)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"credit")))+"\n                ")]}}])})]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1)}),[],!1,null,null,null);e.default=p.exports},45:function(t,e,a){var n=a(18),r=a(91);"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},7:function(t,e,a){"use strict";var n={props:{datatable:Object}},r=a(1),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},9:function(t,e,a){"use strict";var n=a(2),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:""}},mounted:function(){this.datatable.per_page=this.getPerPage()},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:n.a,startCase:n.t,range:n.o,setPerPage:n.r,getPerPage:n.f}},s=(a(90),a(1)),o=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"min-width":"150px","max-width":"200px"}},[a("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[a("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():a("div",{staticClass:"col",staticStyle:{"min-width":"150px"}},[a("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?a("div",{staticClass:"col"},[a("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[a("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),a("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),a("div",{staticClass:"col text-right"},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?a("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,n){return[e.to?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),a("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[a("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,n){return a("li",{key:n,staticClass:"list-group-item"},[a("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(a){return t.changeVisibility(e,n)}},model:{value:e.visible,callback:function(a){t.$set(e,"visible",a)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)]),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=o.exports},90:function(t,e,a){"use strict";var n=a(45);a.n(n).a},91:function(t,e,a){(e=a(19)(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e}}]);