(window.webpackJsonp=window.webpackJsonp||[]).push([[36],{10:function(e,t,a){"use strict";var r=a(1),s=a(21);t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:r.m,startCase:s.a,getItem:r.g},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}},153:function(e,t,a){"use strict";a.r(t);var r=a(10),s=a(25),i={mixins:[r.a],data:function(){var e=this;return{dirty:!1,statuses:s.a,purchaseItemFields:[{key:"product_name",label:_t("product_name","Product Name")},{key:"quantity",label:_t("quantity","Quantity")},{key:"price",label:_t("price","Price"),formatter:function(t){return e.$options.filters.currency(t)}},{key:"total",label:_t("total","Total"),formatter:function(t){return e.$options.filters.currency(t)}}]}}},l=a(2),n=Object(l.a)(i,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"",title:e.__("view_purchase","View Purchase"),lazy:""},on:{hidden:function(){e.$router.go(-1),e.$emit("reset",!0),e.dirty&&e.$emit("refreshDatatable",!0)}}},[a("b-row",[a("b-col",{attrs:{sm:"12",md:"4"}},[a("h4",[e._v(e._s(e.__("supplier_details","Supplier Details")))]),e._v(" "),a("b-table",{attrs:{items:e.obj2Table(e.the_item.supplier,["deleted_at","created_at","updated_at","photo","shipping_address","id"]),fields:[{key:"key",label:e.__("key","Key"),formatter:function(t){return e.__(t,e.startCase(t))}},{key:"value",label:e.__("value","Value")}],striped:"",bordered:"",small:"","head-variant":"dark"},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("dayjs")(t.item.value))+"\n                    ")]:[e._v(e._s(t.item.value))]]}}])})],1),e._v(" "),a("b-col",{attrs:{sm:"12",md:"8"}},[a("h4",[e._v(e._s(e.__("purchase_details","Purchase Details")))]),e._v(" "),a("b-table",{attrs:{small:"",hover:"",striped:"",bordered:"","head-variant":"dark",items:e.obj2Table(e.the_item,["deleted_at","image","items","supplier","supplier_name","supplier_id","tax","discount","updated_at","total","status"]),fields:[{label:e.__("key","Key"),key:"key",sortable:!0,formatter:function(t){return e.__(t,e.startCase(t))}},{label:e.__("value","Value"),key:"value",sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("dayjs")(t.item.value))+"\n                    ")]:[e._v(e._s(t.item.value))]]}}])})],1)],1),e._v(" "),a("h3",{staticClass:"text-center"},[e._v(e._s(e.__("purchase_items","Purchase Items")))]),e._v(" "),a("b-table",{attrs:{small:"",striped:"",bordered:"","head-variant":"dark",items:e.the_item.items,fields:e.purchaseItemFields}})],1)}),[],!1,null,null,null);t.default=n.exports},25:function(e,t,a){"use strict";t.a=[{text:_t("returned","Returned"),value:"Returned"},{text:_t("processed","Processed"),value:"Processed"},{text:_t("cancelled","Cancelled"),value:"Cancelled"}]}}]);