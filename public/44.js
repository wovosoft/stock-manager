(window.webpackJsonp=window.webpackJsonp||[]).push([[44],{"4IVG":function(t,e,a){"use strict";var r={props:{datatable:Object}},n=a("KHd+"),s=Object(n.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},sTew:function(t,e,a){"use strict";e.a={sortBy:"id",sortDesc:!0,per_page:50,current_page:1,total:0,from:0,to:0,data:[]}},uT8Q:function(t,e,a){"use strict";a.r(e);var r=a("4IVG"),n=a("X/aF"),s=a("sTew"),o=a("Wgwc"),c=a.n(o);function d(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,r)}return a}function l(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?d(Object(a),!0).forEach((function(e){i(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):d(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function i(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var u={name:"CustomerSalesReports",components:{DtFooter:r.a},data:function(){var t=this;return{dt:l({},s.a),form:{},browse:{start_date:null,end_date:null},fields:[{key:"id",label:_t("id","ID")},{key:"name",label:_t("name","Name")},{key:"payable",label:_t("total","Total"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"paid",label:_t("sales.paid","Paid"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"returned",label:_t("returned","Returned"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"balance",label:_t("balance","Balance"),formatter:function(e){return t.$options.filters.currency(e)}}]}},mounted:function(){this.setToday()},methods:{colSum:n.d,setToday:function(){this.$set(this.browse,"start_date",c()().format("YYYY-MM-DD")),this.$set(this.browse,"end_date",c()().format("YYYY-MM-DD"))},getItems:function(t){var e=this;return axios.post(t.apiUrl,{per_page:t.perPage,orderBy:t.sortBy||"id",order:Object(n.k)(t.sortDesc)?"desc":"asc"}).then((function(t){return e.$set(e,"dt",t.data),t.data.data})).catch((function(t){return console.log(t.response),e.dt=l({},s.a),[]}))}}},p=a("KHd+"),b=Object(p.a)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-card",{staticClass:"mb-3",attrs:{"bg-variant":"dark","text-variant":"light","body-class":"text-center"}},[a("h4",[t._v("\n            "+t._s(t.__("customer_sales_report","Customer Sales Report"))+"\n        ")]),t._v(" "),a("div",[t._v("\n            "+t._s(t._f("localDate")(t.browse.start_date))+" - "+t._s(t._f("localDate")(t.browse.end_date))+"\n        ")])]),t._v(" "),a("b-card",{attrs:{"body-class":"p-0"},scopedSlots:t._u([{key:"header",fn:function(){return[a("b-row",[a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-input-group",{attrs:{prepend:t.__("per_page","Per Page"),size:"sm"}},[a("b-select",{attrs:{options:[10,30,50,100,150,200,300,500,1e3]},model:{value:t.dt.per_page,callback:function(e){t.$set(t.dt,"per_page",e)},expression:"dt.per_page"}})],1)],1),t._v(" "),a("b-col",{staticClass:"text-center",attrs:{md:"2",sm:"12"}},[a("b-button",{attrs:{size:"sm",variant:"dark"},on:{click:t.setToday}},[t._v("\n                        "+t._s(t.__("todays_report","Today's Report"))+"\n                    ")]),t._v(" "),a("b-button",{attrs:{size:"sm",variant:"dark",target:"_blank",href:t.route("Backend.Reports.Customers.Sales",{start_date:t.browse.start_date,end_date:t.browse.end_date,pdf:"pdf"})}},[t._v("\n                        "+t._s(t.__("export","Export"))+"\n                    ")])],1),t._v(" "),a("b-col",{attrs:{md:"6",sm:"12"}},[a("div",{staticClass:"float-right"},[a("b-form-row",[a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-input-group",{attrs:{prepend:t.__("start","Start"),size:"sm"},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{attrs:{variant:"dark"},on:{click:function(e){t.browse.start_date=null}}},[t._v("\n                                            Reset\n                                        ")])]},proxy:!0}])},[a("b-input",{attrs:{type:"date"},model:{value:t.browse.start_date,callback:function(e){t.$set(t.browse,"start_date",e)},expression:"browse.start_date"}})],1)],1),t._v(" "),a("b-col",{attrs:{md:"6",sm:"12"}},[a("b-input-group",{attrs:{prepend:t.__("end","End"),size:"sm"},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{attrs:{variant:"dark"},on:{click:function(e){t.browse.end_date=null}}},[t._v("\n                                            Reset\n                                        ")])]},proxy:!0}])},[a("b-input",{attrs:{type:"date"},model:{value:t.browse.end_date,callback:function(e){t.$set(t.browse,"end_date",e)},expression:"browse.end_date"}})],1)],1)],1)],1)])],1)]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.dt}})]},proxy:!0}])},[t._v(" "),a("b-table",{ref:"dt_table",staticClass:"mb-0",attrs:{hover:"",small:"",striped:"",bordered:"",items:t.getItems,"current-page":t.dt.current_page,"head-variant":"dark",fields:t.fields,"per-page":t.dt.per_page,"foot-clone":"","foot-variant":"light","api-url":t.route("Backend.Reports.Customers.Sales",{start_date:t.browse.start_date,end_date:t.browse.end_date,page:t.dt.current_page})},scopedSlots:t._u([{key:"foot(payable)",fn:function(e){return[t._v("\n                "+t._s(t._f("currency")(t.colSum(t.dt.data,"payable")))+"\n            ")]}},{key:"foot(paid)",fn:function(e){return[t._v("\n                "+t._s(t._f("currency")(t.colSum(t.dt.data,"paid")))+"\n            ")]}},{key:"foot(returned)",fn:function(e){return[t._v("\n                "+t._s(t._f("currency")(t.colSum(t.dt.data,"returned")))+"\n            ")]}},{key:"foot(balance)",fn:function(e){return[t._v("\n                "+t._s(t._f("currency")(t.colSum(t.dt.data,"balance")))+"\n            ")]}}])})],1)],1)}),[],!1,null,null,null);e.default=b.exports}}]);