(window.webpackJsonp=window.webpackJsonp||[]).push([[58],{12:function(e,t,i){"use strict";var a=i(2),n=i(21);t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:a.l,startCase:n.a,getItem:a.e},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}},160:function(e,t,i){"use strict";i.r(t);var a={mixins:[i(12).a]},n=i(1),r=Object(n.a)(a,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("b-modal",{attrs:{visible:"",size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"",title:e.__("view_employee","View Employee"),lazy:""},on:{hidden:function(t){e.$router.go(-1),e.$emit("reset",!0)}}},[i("b-row",[e.the_item.photo?i("b-col",{attrs:{md:"3",sm:"12"}},[i("b-img-lazy",{attrs:{fluid:"",thumbnail:"",src:"storage/"+e.the_item.photo}})],1):e._e(),e._v(" "),i("b-col",[i("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:e.obj2Table(e.the_item,["deleted_at","photo"]),fields:[{key:"key",sortable:!0,formatter:function(t){return e.__(t,e.startCase(t))}},{key:"value",sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at","joining_date","leaving_date"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("dayjs")(t.item.value))+"\n                    ")]:["description"].includes(t.item.key)?[i("div",{domProps:{innerHTML:e._s(t.item.value)}})]:[e._v(e._s(t.item.value))]]}}])})],1)],1)],1)}),[],!1,null,null,null);t.default=r.exports}}]);