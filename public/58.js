(window.webpackJsonp=window.webpackJsonp||[]).push([[58],{"3FcU":function(e,t,a){"use strict";a.r(t);var s=a("kQN2"),i=a("X/aF"),r={mixins:[s.a],data:function(){return{BasicModalOptions:i.a,disabled:!1}},methods:{makePayment:function(){var e=this;this.disabled=!0,axios.post(route("Backend.Collections.MakePayment",{customer:this.the_item.customer_id,order_collection:this.the_item.id})).then((function(t){e.$root.msgBox(t.data),e.getItem(e.the_item.id,route("Backend.Collections.List")).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))})).catch((function(t){console.log(t.response),e.$root.msgBox(t.response.data)}))}}},n=a("KHd+"),o=Object(n.a)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("b-modal",e._b({attrs:{visible:"",title:e.__("view_collection","View Collection")},on:{hidden:function(t){return e.$router.go(-1)}}},"b-modal",Object.assign({},e.BasicModalOptions,{size:"xl"}),!1),[a("b-form-row",[a("b-col",{attrs:{md:"4",sm:"12"}},[a("b-card",{attrs:{header:e.__("customer_details","Customer Details"),"body-class":"p-0","header-text-variant":"light","header-bg-variant":"dark"}},[e.the_item.customer?a("b-table",{staticClass:"mb-0",attrs:{"thead-class":"d-none",small:"",striped:"",bordered:"",hover:"",fields:[{key:"key",formatter:function(t){return e.__(t)}},"value"],items:e.obj2Table(e.the_item.customer)}}):e._e()],1),e._v(" "),a("b-card",{staticClass:"mt-3",attrs:{header:e.__("user_details","User Details"),"body-class":"p-0","header-text-variant":"light","header-bg-variant":"dark"}},[e.the_item.user?a("b-table",{staticClass:"mb-0",attrs:{"thead-class":"d-none",small:"",striped:"",bordered:"",hover:"",fields:[{key:"key",formatter:function(t){return e.__(t)}},"value"],items:e.obj2Table(e.the_item.user)}}):e._e()],1)],1),e._v(" "),a("b-col",{attrs:{md:"8",sm:"12"}},[a("b-table",{attrs:{small:"",bordered:"",hover:"",striped:"","head-variant":"dark",items:e.obj2Table(e.the_item,["deleted_at","user","customer","user_id","customer_id"]),fields:[{key:"key",sortable:!0,label:e.__("key","Key"),formatter:function(t){return e.__(t,e.startCase(t))}},{key:"value",label:e.__("value","Value"),sortable:!0}]},scopedSlots:e._u([{key:"cell(value)",fn:function(t){return[["created_at","updated_at"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("localDateTime")(t.item.value))+"\n                    ")]:["previous_balance","payment_amount","current_balance"].includes(t.item.key)?[e._v("\n                        "+e._s(e._f("currency")(t.item.value))+"\n                    ")]:["status"].includes(t.item.key)?[e._v("\n                        "+e._s(e.__(t.item.value,e.startCase(t.item.value)))+"\n                    ")]:[e._v(e._s(t.item.value))]]}}])})],1)],1),e._v(" "),e.the_item.payment_id||e.disabled?a("b-alert",{attrs:{variant:"success",show:""}},[e._v("\n        "+e._s(e.__("payment_completed","Payment Completed"))+"\n    ")]):a("div",{staticClass:"text-center",on:{click:e.makePayment}},[a("b-button",{attrs:{variant:"dark",size:"sm"}},[e._v(e._s(e.__("make_payment","Make Payment")))])],1)],1)}),[],!1,null,null,null);t.default=o.exports},kQN2:function(e,t,a){"use strict";var s=a("X/aF"),i=a("EIrz");t.a={props:{item:{type:Object,default:function(){return{}}}},methods:{obj2Table:s.m,startCase:i.a,getItem:s.g},data:function(){return{the_item:{}}},mounted:function(){var e=this;this.the_item=this.item,this.the_item&&Object.keys(this.item).length||this.getItem(this.$route.params.id,this.$parent.$props.api_url||this.$parent._data.api_url).then((function(t){e.the_item=t.data})).catch((function(e){return console.log(e.response)}))}}}}]);