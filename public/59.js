(window.webpackJsonp=window.webpackJsonp||[]).push([[59],{kQN2:function(t,e,a){"use strict";var i=a("X/aF"),r=a("EIrz");e.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:i.m,startCase:r.a,getItem:i.g},data:function(){return{the_item:{}}},mounted:function(){var t=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url||this.$parent._data.api_url).then((function(e){t.the_item=e.data})).catch((function(t){return console.log(t.response)}))}}},uz6P:function(t,e,a){"use strict";a.r(e);var i={mixins:[a("kQN2").a]},r=a("KHd+"),n=Object(r.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-modal",{attrs:{visible:"",size:"lg","header-bg-variant":"dark","header-text-variant":"light","body-class":"p-1","footer-class":"p-2",title:t.__("view_product","View Product"),"ok-title":t.__("ok","Ok"),"cancel-title":t.__("cancel","Cancel"),lazy:""},on:{hidden:function(e){t.$router.go(-1),t.$emit("reset",!0)}}},[a("b-row",[t.the_item.photo_url?a("b-col",{attrs:{md:"4"}},[a("b-img-lazy",{attrs:{thumbnail:"",fluid:"",src:t.the_item.photo_url}})],1):t._e(),t._v(" "),a("b-col",[a("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:t.obj2Table(t.the_item,["photo_url","photo","deleted_at","unit","brand","category","subcategory","subcategory_id","unit_id","brand_id","category_id"]),fields:[{key:"key",sortable:!0,label:t.__("key","Key"),formatter:function(e){return t.__(e,t.startCase(e))}},{key:"value",label:t.__("value","Value"),sortable:!0}]},scopedSlots:t._u([{key:"cell(value)",fn:function(e){return[["created_at","updated_at"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("localDateTime")(e.item.value))+"\n                    ")]:["cost","price","total_cost","total_price","probable_profit"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("currency")(e.item.value))+"\n                    ")]:["quantity","alert_quantity"].includes(e.item.key)?[t._v("\n                        "+t._s(t._f("localNumber")(e.item.value))+"\n                    ")]:["status"].includes(e.item.key)?[t._v("\n                        "+t._s(Number(e.item.value)?t.__("active","Active"):t.__("inactive","Inactive"))+"\n                    ")]:["description"].includes(e.item.key)?[a("div",{domProps:{innerHTML:t._s(e.item.value)}})]:[t._v(t._s(e.item.value))]]}}])})],1)],1)],1)}),[],!1,null,null,null);e.default=n.exports}}]);