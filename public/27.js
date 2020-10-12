(window.webpackJsonp=window.webpackJsonp||[]).push([[27],{10:function(t,e,a){"use strict";var n=a(9),r=a(7),s={components:{DtHeader:n.a,DtFooter:r.a},props:{title:{type:String,default:""},fields:{type:Array,default:function(){return[]}},datatable:{type:Object,default:function(){return{per_page:10,current_page:1,total:0,from:0,to:0}}},value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},tableRef:{type:String,default:"datatable"},noSearch:{type:Boolean,default:!1}}},o=a(1),l=Object(o.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-card",{attrs:{title:t.title,"footer-class":"pb-0","body-class":"p-1"},scopedSlots:t._u([{key:"header",fn:function(){return[a("dt-header",{attrs:{"enable-date-range":t.enableDateRange,custom_buttons:t.custom_buttons,datatable:t.datatable,"no-search":t.noSearch,fields:t.fields,value:t.value,"column-dd-size":t.columnDdSize},on:{refreshDatatable:function(e){return t.$emit("refreshDatatable",e)},input:function(e){return t.$emit("input",e)}},scopedSlots:t._u([{key:"header_searches",fn:function(){return[t._t("header_dropdowns")]},proxy:!0},{key:"bottom_panel",fn:function(){return[t._t("header_bottom_panel")]},proxy:!0}],null,!0)})]},proxy:!0},{key:"footer",fn:function(){return[a("dt-footer",{attrs:{datatable:t.datatable}})]},proxy:!0}])},[t._v(" "),t._t("table")],2)}),[],!1,null,null,null);e.a=l.exports},140:function(t,e,a){"use strict";a.r(e);var n=a(9),r=a(7),s=a(2),o=a(10),l=a(8),i=a.n(l),c=a(16),u={props:{sale:{type:Object,required:!0},payment_options:{type:Array,default:function(){return c.a}}},data:function(){return{form:{payment_amount:0,payment_method:"Cash",date:i()().format("YYYY-MM-DD")}}},mounted:function(){this.form.payment_amount=this.sale.balance},methods:{handleSubmit:function(){var t=this;if(0===Number(this.form.sale_payment))return alert("Payment Amount Can't be 0"),!1;axios.post(route("Backend.Payments.Sales.Store",{sale:this.sale.id}).url(),this.form).then((function(e){t.$emit("msgBox",e.data),t.$emit("success",!0),t.$emit("refresh",!0)})).catch((function(e){t.$emit("success",!1),t.$emit("msgBox",e.response.data),console.log(e.response)}))}}},d=a(1),_=Object(d.a)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[0===t.form.payment_amount?a("b-alert",{attrs:{variant:"danger",show:""}},[t._v("\n        "+t._s(t.__("payment_is_completed_for_this_sale","Payment is completed for this Sale. No further action required."))+"\n    ")]):a("b-form",{on:{submit:function(e){return e.preventDefault(),t.handleSubmit(e)}}},[a("b-form-group",{attrs:{label:t.__("payment_amount","Payment Amount")}},[a("b-input",{attrs:{type:"number",step:"any",required:!0},model:{value:t.form.payment_amount,callback:function(e){t.$set(t.form,"payment_amount",e)},expression:"form.payment_amount"}})],1),t._v(" "),a("b-form-group",{attrs:{label:t.__("payment_method","Payment Method")}},[a("b-select",{attrs:{required:!0,options:t.payment_options},model:{value:t.form.payment_method,callback:function(e){t.$set(t.form,"payment_method",e)},expression:"form.payment_method"}})],1),t._v(" "),a("b-form-group",{attrs:{label:t.__("date","Date")}},[a("b-input",{attrs:{type:"date",required:!0},model:{value:t.form.date,callback:function(e){t.$set(t.form,"date",e)},expression:"form.date"}})],1),t._v(" "),a("b-button",{attrs:{block:"",variant:"dark",type:"submit"}},[t._v("\n            "+t._s(t.__("submit","SUBMIT"))+"\n        ")])],1)],1)}),[],!1,null,null,null).exports,m=a(61),b={components:{DtHeader:n.a,DtFooter:r.a,DtTable:o.a,AddPayment:_,PaymentsHistory:m.a},mixins:[s.d],props:{title:{type:String,default:"List of Sales"},api_url:{type:String,default:function(){return route("Backend.Sales.List").url()}},trash_url:{type:String,default:function(){return route("Backend.Sales.Delete").url()}},submit_url:{type:String,default:function(){return route("Backend.Sales.Store").url()}},custom_buttons:{type:Array,default:function(){return[{text:_t("add","Add"),variant:"dark",to:{name:"SalesAdd"}},{text:_t("history","History"),variant:"primary",to:{name:"ModelHistory",params:{model:"sales"}}}]}}},methods:{colSum:s.c,colCount:s.b,printInvoice:function(){var t=document.getElementById("print_invoice").contentWindow;t.focus(),t.print()}},data:function(){var t=this;return{invoice_type:"html",form:{},fields:[{key:"id",name:"sales.id",sortable:!0,label:_t("id","ID")},{key:"customer_name",name:"customers.name",sortable:!0,label:_t("customer","Customer")},{key:"total",sortable:!0,label:_t("total","Total"),formatter:function(e){return t.$options.filters.currency(e||0)}},{key:"tax",sortable:!0,label:_t("tax","Tax"),formatter:function(e){return t.$options.filters.localNumber(e||0)+"%"}},{key:"discount",sortable:!0,label:_t("discount","Discount"),formatter:function(e){return t.$options.filters.localNumber(e||0)+"%"}},{key:"payable",sortable:!0,label:_t("payable","Payable"),formatter:function(e){return t.$options.filters.currency(e||0)}},{key:"paid",sortable:!0,label:_t("paid","Paid"),formatter:function(e){return t.$options.filters.currency(e||0)}},{key:"balance",sortable:!0,label:_t("balance","Balance"),formatter:function(e){return t.$options.filters.currency(e||0)}},{key:"date",sortable:!0,label:_t("date","Date"),formatter:function(t){return new Date(t).toLocaleDateString(_s("locale"))}},{key:"status",sortable:!0,label:_t("status","Status")},{key:"note",sortable:!0,visible:!1,label:_t("note","Note"),formatter:function(e){return t.$options.filters.truncate(e||"")}},{key:"created_at",name:"sales.created_at",sortable:!0,label:_t("created_at","Created At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"updated_at",name:"sales.updated_at",sortable:!0,label:_t("updated_at","Updated At"),formatter:function(e){return t.$options.filters.localDateTime(e)}},{key:"action",sortable:!1,label:_t("action","Action"),searchable:!1,thClass:"text-right",tdClass:"text-right"}]}}},f=Object(d.a)(b,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t._v("\n    "+t._s(t.headers.sql)+"\n    "),a("b-row",{staticClass:"mb-3"},[a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-card",{attrs:{"bg-variant":"dark","text-variant":"light",title:t.__("sales_payable","Sales Payable")}},[t._v("\n                "+t._s(t._f("currency")(t.overview.sales_payable))+"\n            ")])],1),t._v(" "),a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-card",{attrs:{"bg-variant":"dark","text-variant":"light",title:t.__("sales_paid","Sales Paid")}},[t._v("\n                "+t._s(t._f("currency")(t.overview.sales_paid))+"\n            ")])],1),t._v(" "),a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-card",{attrs:{"bg-variant":"dark","text-variant":"light",title:t.__("sales_balance","Sales Balance")}},[t._v("\n                "+t._s(t._f("currency")(t.overview.sales_balance))+"\n            ")])],1)],1),t._v(" "),a("dt-table",{attrs:{title:t.title,fields:t.fields,datatable:t.datatable,custom_buttons:t.custom_buttons,"enable-date-range":""},on:{refreshDatatable:function(e){return t.$refs.datatable.refresh()}},scopedSlots:t._u([{key:"table",fn:function(){return[a("b-table",{ref:"datatable",staticClass:"mb-0",attrs:{variant:"primary",responsive:"md",hover:"",bordered:"",small:"",striped:"","head-variant":"dark",items:t.getItems,fields:t.fields,"sort-by":t.datatable.sortBy,"sort-desc":t.datatable.sortDesc,filter:t.search,"per-page":t.datatable.per_page,"current-page":t.datatable.current_page,"foot-clone":"","foot-variant":"light"},on:{refreshed:function(e){t.overview=JSON.parse(t.headers.overview||"{}")},"update:sortBy":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sort-by":function(e){return t.$set(t.datatable,"sortBy",e)},"update:sortDesc":function(e){return t.$set(t.datatable,"sortDesc",e)},"update:sort-desc":function(e){return t.$set(t.datatable,"sortDesc",e)}},scopedSlots:t._u([{key:"foot(customer_name)",fn:function(e){return[t._v("\n                    "+t._s(t._f("localNumber")(t.colCount(t.datatable.items,"customer_name")))+" "+t._s(t.__("persons","Persons"))+"\n                ")]}},{key:"foot(total)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"total")))+"\n                ")]}},{key:"foot(discount)",fn:function(e){return[t._v("\n                    "+t._s(t._f("localNumber")(t.colSum(t.datatable.items,"discount")))+"%\n                ")]}},{key:"foot(tax)",fn:function(e){return[t._v("\n                    "+t._s(t._f("localNumber")(t.colSum(t.datatable.items,"tax")))+"%\n                ")]}},{key:"foot(payable)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"payable")))+"\n                ")]}},{key:"foot(paid)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"paid")))+"\n                ")]}},{key:"foot(balance)",fn:function(e){return[t._v("\n                    "+t._s(t._f("currency")(t.colSum(t.datatable.items,"balance")))+"\n                ")]}},{key:"cell(action)",fn:function(e){return[a("b-button-group",{attrs:{size:"sm"}},[a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal:add-payment",arg:"add-payment"}],attrs:{variant:"dark",title:t.__("take_payment","Take Payment")},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-money-bill"})]),t._v(" "),a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal:payment-history",arg:"payment-history"}],attrs:{variant:"secondary",title:t.__("payment_history","Payment History")},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-money-bill-wave"})]),t._v(" "),a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal:invoice-modal",arg:"invoice-modal"}],attrs:{variant:"dark",title:t.__("view_invoice","View Invoice")},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-file-invoice"})]),t._v(" "),a("b-button",{attrs:{variant:"primary",title:t.__("view_sale_history","View Sale's Details"),to:{name:"SalesView",params:{id:e.item.id}}},on:{click:function(a){t.currentItem=JSON.parse(JSON.stringify(e.item))}}},[a("i",{staticClass:"fa fa-eye"})]),t._v(" "),a("b-button",{attrs:{variant:"danger",title:t.__("delete_the_sale","Delete the Sale")},on:{click:function(a){return t.trash(e.item.id)}}},[a("i",{staticClass:"fa fa-trash"})])],1)]}}])})]},proxy:!0}]),model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),t.currentItem?a("b-modal",{attrs:{id:"add-payment",title:t.__("take_payment","Take Payment"),"hide-footer":"","header-bg-variant":"dark","header-text-variant":"light"},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.hide;return[a("add-payment",{attrs:{sale:t.currentItem},on:{msgBox:function(e){return t.msgBox(e)},success:function(e){e&&(n(),t.$refs.datatable.refresh())}}})]}}],null,!1,365700112)}):t._e(),t._v(" "),t.currentItem?a("b-modal",{attrs:{id:"payment-history",size:"xl","body-class":"p-1",title:t.__("payment_history","Payment History"),"header-bg-variant":"dark","header-text-variant":"light"},scopedSlots:t._u([{key:"default",fn:function(e){e.hide;return[a("payments-history",{attrs:{sale:t.currentItem}})]}}],null,!1,4017182276)}):t._e(),t._v(" "),t.currentItem?a("b-modal",{attrs:{id:"invoice-modal",size:"xl","footer-class":"text-right","body-class":"p-0",title:t.__("sale_invoice","Sale Invoice"),"header-bg-variant":"dark","header-text-variant":"light","footer-bg-variant":"dark","footer-text-variant":"light"},on:{hidden:function(e){t.currentItem=null}},scopedSlots:t._u([{key:"modal-footer",fn:function(e){var n=e.close;return[a("b-button",{attrs:{variant:"primary"},on:{click:t.printInvoice}},[t._v("Print")]),t._v(" "),a("b-button",{attrs:{variant:"secondary"},on:{click:n}},[t._v("Close")])]}}],null,!1,2549302917)},[a("b-embed",{attrs:{id:"print_invoice",aspect:"16by9",allowfullscreen:"",src:t.route("Backend.Sales.Invoice.PDF",{sale:t.currentItem.id,type:"pdf"})}})],1):t._e(),t._v(" "),a("router-view",{attrs:{item:t.currentItem},on:{reset:function(e){t.currentItem={}},refreshDatatable:function(){return t.$refs.datatable.refresh()}}})],1)}),[],!1,null,null,null);e.default=f.exports},16:function(t,e,a){"use strict";e.a=[{text:_t("bank","Bank"),value:"Bank"},{text:_t("cash","Cash"),value:"Cash"},{text:_t("card","Card"),value:"Card"},{text:_t("bkash","bKash"),value:"bKash"},{text:_t("rocket","Rocket"),value:"Rocket"}]},45:function(t,e,a){var n=a(18),r=a(93);"string"==typeof(r=r.__esModule?r.default:r)&&(r=[[t.i,r,""]]);var s={insert:"head",singleton:!1};n(r,s);t.exports=r.locals||{}},61:function(t,e,a){"use strict";var n={props:{sale:{type:Object,required:!0},customerOverview:{type:Boolean,default:!0}},data:function(){var t=this;return{items:[],fields:[{key:"id",label:_t("id","ID")},{key:"payment_method",label:_t("payment_method","Method")},{key:"payment_amount",label:_t("payment_amount","Payment Amount"),formatter:function(e){return t.$options.filters.currency(e)}},{key:"bank",label:_t("bank","Bank")},{key:"check",label:_t("check","Check")},{key:"transaction_no",label:_t("transaction_no","Transaction No.")},{key:"taken_by",label:_t("taken_by","Taken By")},{key:"created_at",label:_t("created_at","Created At"),formatter:function(e){return t.$options.filters.dayjs(e)}}]}},mounted:function(){this.getItems(this.sale&&this.sale.id?this.sale.id:this.$route.params.id)},methods:{getItems:function(t){var e=this;axios.post(route("Backend.Payments.Single.Sales.Payments",{sale:t}).url()).then((function(t){e.$set(e,"items",t.data)})).catch((function(t){e.$set(e,"items",[]),console.log(t.response)}))}}},r=a(1),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-row",[t.customerOverview?a("b-col",{attrs:{md:"4",sm:"12"}},[a("table",{staticClass:"table table-sm table-striped table-bordered"},[a("tr",[a("th",[t._v(t._s(t.__("customer_id","Customer ID")))]),t._v(" "),a("td",[t._v(": "+t._s(t.sale.customer_id))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("customer_name","Customer Name")))]),t._v(" "),a("td",[t._v(": "+t._s(t.sale.customer_name))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("payable","Payable")))]),t._v(" "),a("td",[t._v(": "+t._s(t._f("currency")(t.sale.payable)))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("paid","Paid")))]),t._v(" "),a("td",[t._v(": "+t._s(t._f("currency")(t.sale.paid)))])]),t._v(" "),a("tr",[a("th",[t._v(t._s(t.__("balance","Balance")))]),t._v(" "),a("td",[t._v(": "+t._s(t._f("currency")(t.sale.balance)))])])])]):t._e(),t._v(" "),a("b-col",[a("b-table",{attrs:{small:"","head-variant":"dark",items:t.items,fields:t.fields}})],1)],1)}),[],!1,null,"1429012e",null);e.a=s.exports},7:function(t,e,a){"use strict";var n={props:{datatable:Object}},r=a(1),s=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[t.datatable.to?[t._v("\n            Showing "+t._s(t.datatable.from||0)+" to "+t._s(t.datatable.to||0)+" = "+t._s(t.datatable.to-t.datatable.from+t.datatable.from)+" items of\n            "+t._s(t.datatable.total)+" items.\n        ")]:[t._v("No Items Found")]],2),t._v(" "),a("div",{staticClass:"col"},[a("b-pagination",{staticClass:"mb-0",attrs:{align:"right",size:"sm","total-rows":t.datatable.total,"per-page":t.datatable.per_page,"aria-controls":"datatable"},on:{change:function(e){return t.$emit("refreshDatatable",e)}},model:{value:t.datatable.current_page,callback:function(e){t.$set(t.datatable,"current_page",e)},expression:"datatable.current_page"}})],1)])}),[],!1,null,"5eedc22a",null);e.a=s.exports},9:function(t,e,a){"use strict";var n=a(2),r={props:{fields:{type:Array,default:function(){return[]}},datatable:Object,value:{type:String,default:""},custom_buttons:{type:Array,default:function(){return[]}},columnDdSize:{type:String,default:"sm"},customButtonSize:{type:String,default:"sm"},searchSize:{type:String,default:"sm"},perPageSize:{type:String,default:"sm"},enableDateRange:{type:Boolean,default:!1},noSearch:{type:Boolean,default:!1}},data:function(){return{search:""}},mounted:function(){this.datatable.per_page=this.getPerPage()},watch:{"datatable.search_columns":{deep:!0,handler:function(t,e){this.$emit("refreshDatatable",!0)}}},methods:{changeVisibility:n.a,startCase:n.s,range:n.o,setPerPage:n.q,getPerPage:n.f}},s=(a(92),a(1)),o=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"min-width":"150px","max-width":"200px"}},[a("b-input-group",{attrs:{size:t.perPageSize,prepend:t.__("per_page","Per Page")}},[a("b-form-select",{staticClass:"form-control",attrs:{options:t.range()},on:{change:function(e){return t.setPerPage(e)}},model:{value:t.datatable.per_page,callback:function(e){t.$set(t.datatable,"per_page",e)},expression:"datatable.per_page"}})],1)],1),t._v(" "),t.noSearch?t._e():a("div",{staticClass:"col",staticStyle:{"min-width":"150px"}},[a("b-form-input",{attrs:{type:"search",size:t.searchSize,placeholder:t.__("type_and_hit_enter_to_search_the_table","Type and Hit Enter to Search the table, ESC to clear")},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:(e.target.value="",void t.$emit("input",""))},change:function(e){t.datatable.current_page=1},input:function(e){return t.$emit("input",t.search)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),t.enableDateRange?a("div",{staticClass:"col"},[a("b-input-group",{attrs:{size:t.searchSize},scopedSlots:t._u([{key:"append",fn:function(){return[a("b-button",{on:{click:function(){t.$set(t.datatable.search_columns,"starting_date",void 0),t.$set(t.datatable.search_columns,"ending_date",void 0),t.$emit("refreshDatatable")}}},[t._v("\n                        x\n                    ")])]},proxy:!0}],null,!1,2283915669)},[a("b-form-input",{attrs:{type:"date",title:t.__("starting_date","Starting Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.starting_date,callback:function(e){t.$set(t.datatable.search_columns,"starting_date",e)},expression:"datatable.search_columns.starting_date"}}),t._v(" "),a("b-form-input",{attrs:{type:"date",disabled:!t.datatable.search_columns.starting_date,min:t.datatable.search_columns.starting_date,title:t.__("ending_date","Ending Date")},on:{change:function(e){return t.$emit("refreshDatatable")}},model:{value:t.datatable.search_columns.ending_date,callback:function(e){t.$set(t.datatable.search_columns,"ending_date",e)},expression:"datatable.search_columns.ending_date"}})],1)],1):t._e(),t._v(" "),a("div",{staticClass:"col text-right"},[t._t("header_searches"),t._v(" "),t.custom_buttons&&t.custom_buttons.length?a("b-button-group",{attrs:{v0i:"",size:t.customButtonSize}},[t._l(t.custom_buttons,(function(e,n){return[e.to?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",to:e.to,exact:"","exact-active-class":"active"}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):e.cb?a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark",exact:"","exact-active-class":"active"},on:{click:e.cb}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")]):a("b-button",{key:n,attrs:{title:e.title,variant:e.variant?e.variant:"dark"},on:{click:e.method}},[e.icon?a("i",{class:e.icon}):t._e(),t._v(" "+t._s(e.text)+"\n                    ")])]}))],2):t._e(),t._v(" "),a("b-dropdown",{staticClass:"columns-dropdown p-0",attrs:{text:t.__("columns","Columns"),size:t.columnDdSize,right:"",variant:"primary"}},[a("ul",{staticClass:"list-group"},t._l(t.fields,(function(e,n){return a("li",{key:n,staticClass:"list-group-item"},[a("b-form-checkbox",{attrs:{value:!0,"uncheched-value":!1},on:{change:function(a){return t.changeVisibility(e,n)}},model:{value:e.visible,callback:function(a){t.$set(e,"visible",a)},expression:"field.visible"}},[t._v("\n                            "+t._s(t.startCase(e.label||e.key))+"\n                        ")])],1)})),0)])],2)]),t._v(" "),t._t("bottom_panel")],2)}),[],!1,null,null,null);e.a=o.exports},92:function(t,e,a){"use strict";var n=a(45);a.n(n).a},93:function(t,e,a){(e=a(19)(!1)).push([t.i,".columns-dropdown .dropdown-menu {\n  padding: 0 !important;\n  border: 0 !important;\n  max-height: 400px;\n  overflow-y: auto;\n}\n.columns-dropdown .list-group-item label {\n  cursor: pointer;\n}",""]),t.exports=e}}]);