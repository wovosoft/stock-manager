(window.webpackJsonp=window.webpackJsonp||[]).push([[62],{"+LNK":function(e,t,a){"use strict";a.r(t);var i={mixins:[a("kQN2").a]},n=a("KHd+"),r=Object(n.a)(i,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","body-class":"p-0","footer-class":"p-2","ok-title":e.__("ok","Ok"),"cancel-title":e.__("cancel","Cancel"),title:e.__("view_sms","View SMS"),lazy:""},on:{hidden:function(t){return e.$router.go(-1)}}},[a("b-row",[a("b-col",[a("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:e.obj2Table(e.the_item,["deleted_at"]),fields:[{key:"key",sortable:!0,label:e.__("key","Key"),formatter:function(t){return e.__(t,e.startCase(t))}},{key:"value",label:e.__("value","Value"),sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("localDateTime")(t.item.value))+"\n                    ")]:["contacts"].includes(t.item.key)?[e._v("\n                        "+e._s(t.item.value.join(", "))+"\n                    ")]:[e._v(e._s(t.item.value))]]}}])})],1)],1)],1)}),[],!1,null,null,null);t.default=r.exports},kQN2:function(e,t,a){"use strict";var i=a("X/aF"),n=a("EIrz");t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:i.m,startCase:n.a,getItem:i.g},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url||this.$parent._data.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}}}]);