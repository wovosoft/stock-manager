(window.webpackJsonp=window.webpackJsonp||[]).push([[66],{12:function(e,t,a){"use strict";var i=a(2),n=a(21);t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:i.l,startCase:n.a,getItem:i.e},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}},198:function(e,t,a){"use strict";a.r(t);var i={mixins:[a(12).a]},n=a(1),l=Object(n.a)(i,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"",scrollable:"",title:e.__("view_language","View Language"),lazy:""},on:{hidden:function(t){e.$router.go(-1),e.$emit("reset",!0)}}},[a("b-row",[a("b-col",[a("b-table",{attrs:{small:"",bordered:"","head-variant":"dark",items:e.obj2Table(e.the_item,["deleted_at"]),fields:[{key:"key",sortable:!0,label:e.__("key","Key"),formatter:function(t){return e.startCase(e.__(t))}},{key:"value",label:e.__("value","Value"),sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("dayjs")(t.item.value))+"\n                    ")]:["description"].includes(t.item.key)?[a("div",{domProps:{innerHTML:e._s(t.item.value)}})]:["definitions"].includes(t.item.key)?[a("b-table",{attrs:{hover:"",items:t.item.value,fields:["key","value"]}})]:[e._v(e._s(t.item.value))]]}}])})],1)],1)],1)}),[],!1,null,null,null);t.default=l.exports}}]);