(window.webpackJsonp=window.webpackJsonp||[]).push([[56],{12:function(e,t,i){"use strict";var a=i(2),r=i(21);t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:a.m,startCase:r.a,getItem:a.g},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}},172:function(e,t,i){"use strict";i.r(t);var a={mixins:[i(12).a]},r=i(1),n=Object(r.a)(a,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("b-modal",{attrs:{visible:"",size:"lg","header-bg-variant":"dark","header-text-variant":"light","body-class":"p-1","footer-class":"p-2",title:e.__("view_product","View Product"),"ok-title":e.__("ok","Ok"),"cancel-title":e.__("cancel","Cancel"),lazy:""},on:{hidden:function(t){e.$router.go(-1),e.$emit("reset",!0)}}},[i("b-row",[e.the_item.photo_url?i("b-col",{attrs:{md:"4"}},[i("b-img-lazy",{attrs:{thumbnail:"",fluid:"",src:e.the_item.photo_url}})],1):e._e(),e._v(" "),i("b-col",[i("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:e.obj2Table(e.the_item,["photo_url","photo","deleted_at","unit","brand","category","subcategory","subcategory_id","unit_id","brand_id","category_id"]),fields:[{key:"key",sortable:!0,label:e.__("key","Key"),formatter:function(t){return e.__(t,e.startCase(t))}},{key:"value",label:e.__("value","Value"),sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("localDateTime")(t.item.value))+"\n                    ")]:["cost","price","total_cost","total_price","probable_profit"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("currency")(t.item.value))+"\n                    ")]:["quantity","alert_quantity"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("localNumber")(t.item.value))+"\n                    ")]:["status"].includes(t.item.key)?[e._v("\n                        "+e._s(Number(t.item.value)?e.__("active","Active"):e.__("inactive","Inactive"))+"\n                    ")]:["description"].includes(t.item.key)?[i("div",{domProps:{innerHTML:e._s(t.item.value)}})]:[e._v(e._s(t.item.value))]]}}])})],1)],1)],1)}),[],!1,null,null,null);t.default=n.exports}}]);