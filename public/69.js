(window.webpackJsonp=window.webpackJsonp||[]).push([[69],{kQN2:function(t,e,a){"use strict";var r=a("X/aF"),n=a("EIrz");e.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:r.m,startCase:n.a,getItem:r.g},data:function(){return{the_item:{}}},mounted:function(){var t=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url||this.$parent._data.api_url).then((function(e){t.the_item=e.data})).catch((function(t){return console.log(t.response)}))}}},pogq:function(t,e,a){"use strict";a.r(e);var r={mixins:[a("kQN2").a],data:function(){return{the_item:{},browse:{start_date:null,end_date:null}}}},n=a("KHd+"),s=Object(n.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"","ok-title":t.__("ok","OK"),"cancel-title":t.__("cancel","Cancel"),title:t.__("view_supplier","View Supplier"),lazy:""},on:{hidden:function(e){t.$router.go(-1),t.$emit("reset",!0)}}},[a("b-row",[a("b-col",{attrs:{md:"3",sm:"12"}},[t.the_item.photo?a("b-img-lazy",{attrs:{fluid:"",thumbnail:"",src:"storage/"+t.the_item.photo}}):a("b-img-lazy",{attrs:{fluid:"",thumbnail:"",src:"https://plchldr.co/i/500x250?bg=111111&&text=No Image"}}),t._v(" "),a("h4",{staticClass:"my-2 text-center"},[t._v(t._s(t.__("financial_report","Financial Report")))]),t._v(" "),a("table",{staticClass:"table table-sm table-bordered table-striped table-hover"},t._l(["payable","returned","paid","balance"],(function(e){return a("tr",[a("th",[t._v(t._s(t.__("purchases_"+e,t.startCase("purchases_"+e))))]),t._v(" "),a("td",[t._v(t._s(t._f("currency")(t.the_item[e])))])])})),0)],1),t._v(" "),a("b-col",[a("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:t.obj2Table(t.the_item,["deleted_at","photo","payable","paid","returned","balance"]),fields:[{label:t.__("key","Key"),key:"key",sortable:!0,formatter:function(e){return t.__(e,t.startCase(e))}},{label:t.__("value","Value"),key:"value",sortable:!0}]},scopedSlots:t._u([{key:"cell(value)",fn:function(e){return[["created_at","updated_at"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("dayjs")(e.item.value))+"\n                    ")]:["description"].includes(e.item.key)?[a("div",{domProps:{innerHTML:t._s(e.item.value)}})]:["deposit_amount","withdrawn_amount","funds_balance","purchases_payable","purchases_paid","purchases_balance","final_balance"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("currency")(e.item.value))+"\n                    ")]:[t._v(t._s(e.item.value))]]}}])})],1)],1),t._v(" "),a("b-row",[a("b-col",[a("h4",{staticClass:"text-center"},[t._v("\n                "+t._s(t.__("financial_report","Financial Report"))+"\n            ")]),t._v(" "),a("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[a("b-input-group-text",[t._v("\n                        "+t._s(t.__("start","Start"))+"\n                    ")])]},proxy:!0},{key:"append",fn:function(){return[a("b-button",{attrs:{variant:"danger",target:"_blank"},on:{click:function(e){t.browse.start_date=null,t.browse.end_date=null}}},[t._v("\n                        "+t._s(t.__("reset","Reset"))+"\n                    ")]),t._v(" "),t.the_item&&t.the_item.id?a("b-button",{attrs:{variant:"primary",target:"_blank",href:t.route("Backend.Suppliers.Payments.shortFinancialReport",{supplier:t.the_item.id,type:"pdf",start_date:t.browse.start_date,end_date:t.browse.end_date})}},[t._v("\n                        "+t._s(t.__("short_report","Short Report"))+"\n                    ")]):t._e(),t._v(" "),t.the_item&&t.the_item.id?a("b-button",{attrs:{variant:"dark",target:"_blank",href:t.route("Backend.Suppliers.Payments.fullFinancialReport",{supplier:t.the_item.id,type:"pdf",start_date:t.browse.start_date,end_date:t.browse.end_date})}},[t._v("\n                        "+t._s(t.__("full_report","Full Report"))+"\n                    ")]):t._e()]},proxy:!0}])},[t._v(" "),a("b-input",{staticClass:"rounded-0",attrs:{type:"date"},model:{value:t.browse.start_date,callback:function(e){t.$set(t.browse,"start_date",e)},expression:"browse.start_date"}}),t._v(" "),a("b-input-group-text",{staticClass:"rounded-0"},[t._v("\n                    "+t._s(t.__("end","End"))+"\n                ")]),t._v(" "),a("b-input",{attrs:{type:"date"},model:{value:t.browse.end_date,callback:function(e){t.$set(t.browse,"end_date",e)},expression:"browse.end_date"}})],1)],1)],1)],1)}),[],!1,null,null,null);e.default=s.exports}}]);