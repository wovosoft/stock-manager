(window.webpackJsonp=window.webpackJsonp||[]).push([[6,36],{"/4Mc":function(t,e,n){"use strict";var i=n("1ZF1");n.n(i).a},"06ki":function(t,e,n){(e=n("JPst")(!1)).push([t.i,".product-image {\n  background-color: rgba(0, 0, 0, 0.8);\n}",""]),t.exports=e},"1ZF1":function(t,e,n){var i=n("LboF"),a=n("06ki");"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.i,a,""]]);var o={insert:"head",singleton:!1};i(a,o);t.exports=a.locals||{}},"3fRZ":function(t,e,n){"use strict";var i=n("ex6f"),a={props:{value:{type:null|Object,default:function(){return null}},api_url:{type:String,default:null,required:!0},prepend:{type:String,default:""},append:{type:String,default:""},placeholder:{type:String,default:"Search Items"},size:{type:String,default:"sm"},autocomplete:{type:String,default:"off"},dropdownVariant:{type:String,default:"outline-secondary"},emptyOptionText:{type:String,default:"No items available to select"},inputClass:{type:String|Array,default:function(){return[]}},menuStyle:{type:String|Array,default:function(){return[]}},clearSearchOnItemSelected:{type:Boolean,default:!1},initOptions:{type:Boolean|String,default:!1},required:{type:Boolean,default:!1},state:{type:Boolean,default:null},hideDdIcon:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},menuClass:{type:String|Object,default:function(){return""}},getFiltered:{type:Function},clearSearchOnDropdownHidden:{type:Boolean,default:function(){return!0}},optionText:{type:Function},tagText:{Type:Function}},data:function(){return{options:[],query:"",selected_item:null}},mounted:function(){this.initOptions&&(Object(i.a)(this.initOptions)&&this.initOptions?this.getItems(""):this.query=this.initOptions),this.$set(this,"selected_item",this.value)},computed:{getOptions:function(){return"function"==typeof this.getFiltered&&this.getFiltered?this.getFiltered(this.options):this.options}},watch:{value:{deep:!0,handler:function(t){this.$set(this,"selected_item",t)}}},methods:{reset:function(){this.$emit("input",null),this.$set(this,"selected_item",null),this.query=""},itemSelected:function(t){this.$emit("input",t),this.$set(this,"selected_item",t),this.clearSearchOnItemSelected&&(this.query=null)},getItems:function(t){var e=this;axios.post(this.api_url,{query:this.query}).then((function(t){e.$set(e,"options",t.data||[])})).catch((function(t){e.$set(e,"options",[]),console.error(t.response)}))}}},o=(n("c9im"),n("KHd+")),r=Object(o.a)(a,(function(){var t=this,e=this,n=e.$createElement,i=e._self._c||n;return i("div",{staticClass:"vue-select form-control p-0",class:{"is-invalid":null!==e.state&&e.state,"is-valid":null!==e.state&&!e.state}},[e.required?i("input",{staticStyle:{height:"0",position:"absolute",top:"0",border:"0",outline:"0","z-index":"-1"},attrs:{type:"text",required:!0},domProps:{value:e.value?"initialized":""}}):e._e(),e._v(" "),i("b-dropdown",{class:{"hide-dd-icon":e.hideDdIcon,disabled:e.disabled},style:e.menuStyle,attrs:{block:"",lazy:"",variant:e.dropdownVariant,disabled:e.disabled,"toggle-class":"text-left m-0 border-0 border-radius-0","menu-class":e.menuClass},on:{hidden:function(){e.$emit("hidden",!0),t.clearSearchOnDropdownHidden&&(t.query="")}},scopedSlots:e._u([{key:"button-content",fn:function(){return[e._t("tag",[e._v("\n                "+e._s("function"==typeof e.tagText?e.tagText(e.selected_item):(e.selected_item,e.placeholder))+"\n            ")],{tag:e.selected_item})]},proxy:!0}],null,!0)},[e._v(" "),i("div",{staticClass:"px-2"},[i("b-form-input",{class:e.inputClass,attrs:{autofocus:"",type:"search",size:e.size,placeholder:e.placeholder,autocomplete:e.autocomplete},on:{keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter"))return null;t.preventDefault()},input:function(t){return e.getItems(t)}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}})],1),e._v(" "),i("b-dropdown-divider"),e._v(" "),e._l(e.getOptions,(function(t,n){return i("b-dropdown-item",{key:n,on:{click:function(n){return e.itemSelected(t)}}},[e._t("option",[e._v("\n                "+e._s("function"==typeof e.optionText?e.optionText(t):t)+"\n            ")],{item:t,query:e.query})],2)})),e._v(" "),0===e.options.length?[e._t("empty",[0===e.options.length?i("b-dropdown-text",[e._v("\n                    "+e._s(e.emptyOptionText)+"\n                ")]):e._e()],{query:e.query})]:e._e(),e._v(" "),e._t("default_item",null,{query:e.query})],2)],1)}),[],!1,null,null,null);e.a=r.exports},"4Gdk":function(t,e,n){"use strict";e.a=[{id:"1",division_id:"3",name:"Dhaka",bn_name:"ঢাকা",lat:"23.7115253",long:"90.4111451"},{id:"2",division_id:"3",name:"Faridpur",bn_name:"ফরিদপুর",lat:"23.6070822",long:"89.8429406"},{id:"3",division_id:"3",name:"Gazipur",bn_name:"গাজীপুর",lat:"24.0022858",long:"90.4264283"},{id:"4",division_id:"3",name:"Gopalganj",bn_name:"গোপালগঞ্জ",lat:"23.0050857",long:"89.8266059"},{id:"5",division_id:"8",name:"Jamalpur",bn_name:"জামালপুর",lat:"24.937533",long:"89.937775"},{id:"6",division_id:"3",name:"Kishoreganj",bn_name:"কিশোরগঞ্জ",lat:"24.444937",long:"90.776575"},{id:"7",division_id:"3",name:"Madaripur",bn_name:"মাদারীপুর",lat:"23.164102",long:"90.1896805"},{id:"8",division_id:"3",name:"Manikganj",bn_name:"মানিকগঞ্জ",lat:"0",long:"0"},{id:"9",division_id:"3",name:"Munshiganj",bn_name:"মুন্সিগঞ্জ",lat:"0",long:"0"},{id:"10",division_id:"8",name:"Mymensingh",bn_name:"ময়মনসিংহ",lat:"0",long:"0"},{id:"11",division_id:"3",name:"Narayanganj",bn_name:"নারায়াণগঞ্জ",lat:"23.63366",long:"90.496482"},{id:"12",division_id:"3",name:"Narsingdi",bn_name:"নরসিংদী",lat:"23.932233",long:"90.71541"},{id:"13",division_id:"8",name:"Netrokona",bn_name:"নেত্রকোণা",lat:"24.870955",long:"90.727887"},{id:"14",division_id:"3",name:"Rajbari",bn_name:"রাজবাড়ি",lat:"23.7574305",long:"89.6444665"},{id:"15",division_id:"3",name:"Shariatpur",bn_name:"শরীয়তপুর",lat:"0",long:"0"},{id:"16",division_id:"8",name:"Sherpur",bn_name:"শেরপুর",lat:"25.0204933",long:"90.0152966"},{id:"17",division_id:"3",name:"Tangail",bn_name:"টাঙ্গাইল",lat:"0",long:"0"},{id:"18",division_id:"5",name:"Bogura",bn_name:"বগুড়া",lat:"24.8465228",long:"89.377755"},{id:"19",division_id:"5",name:"Joypurhat",bn_name:"জয়পুরহাট",lat:"0",long:"0"},{id:"20",division_id:"5",name:"Naogaon",bn_name:"নওগাঁ",lat:"0",long:"0"},{id:"21",division_id:"5",name:"Natore",bn_name:"নাটোর",lat:"24.420556",long:"89.000282"},{id:"22",division_id:"5",name:"Nawabganj",bn_name:"নবাবগঞ্জ",lat:"24.5965034",long:"88.2775122"},{id:"23",division_id:"5",name:"Pabna",bn_name:"পাবনা",lat:"23.998524",long:"89.233645"},{id:"24",division_id:"5",name:"Rajshahi",bn_name:"রাজশাহী",lat:"0",long:"0"},{id:"25",division_id:"5",name:"Sirajgonj",bn_name:"সিরাজগঞ্জ",lat:"24.4533978",long:"89.7006815"},{id:"26",division_id:"6",name:"Dinajpur",bn_name:"দিনাজপুর",lat:"25.6217061",long:"88.6354504"},{id:"27",division_id:"6",name:"Gaibandha",bn_name:"গাইবান্ধা",lat:"25.328751",long:"89.528088"},{id:"28",division_id:"6",name:"Kurigram",bn_name:"কুড়িগ্রাম",lat:"25.805445",long:"89.636174"},{id:"29",division_id:"6",name:"Lalmonirhat",bn_name:"লালমনিরহাট",lat:"0",long:"0"},{id:"30",division_id:"6",name:"Nilphamari",bn_name:"নীলফামারী",lat:"25.931794",long:"88.856006"},{id:"31",division_id:"6",name:"Panchagarh",bn_name:"পঞ্চগড়",lat:"26.3411",long:"88.5541606"},{id:"32",division_id:"6",name:"Rangpur",bn_name:"রংপুর",lat:"25.7558096",long:"89.244462"},{id:"33",division_id:"6",name:"Thakurgaon",bn_name:"ঠাকুরগাঁও",lat:"26.0336945",long:"88.4616834"},{id:"34",division_id:"1",name:"Barguna",bn_name:"বরগুনা",lat:"0",long:"0"},{id:"35",division_id:"1",name:"Barishal",bn_name:"বরিশাল",lat:"0",long:"0"},{id:"36",division_id:"1",name:"Bhola",bn_name:"ভোলা",lat:"22.685923",long:"90.648179"},{id:"37",division_id:"1",name:"Jhalokati",bn_name:"ঝালকাঠি",lat:"0",long:"0"},{id:"38",division_id:"1",name:"Patuakhali",bn_name:"পটুয়াখালী",lat:"22.3596316",long:"90.3298712"},{id:"39",division_id:"1",name:"Pirojpur",bn_name:"পিরোজপুর",lat:"0",long:"0"},{id:"40",division_id:"2",name:"Bandarban",bn_name:"বান্দরবান",lat:"22.1953275",long:"92.2183773"},{id:"41",division_id:"2",name:"Brahmanbaria",bn_name:"ব্রাহ্মণবাড়িয়া",lat:"23.9570904",long:"91.1119286"},{id:"42",division_id:"2",name:"Chandpur",bn_name:"চাঁদপুর",lat:"23.2332585",long:"90.6712912"},{id:"43",division_id:"2",name:"Chattogram",bn_name:"চট্টগ্রাম",lat:"22.335109",long:"91.834073"},{id:"44",division_id:"2",name:"Cumilla",bn_name:"কুমিল্লা",lat:"23.4682747",long:"91.1788135"},{id:"45",division_id:"2",name:"Cox's Bazar",bn_name:"কক্স বাজার",lat:"0",long:"0"},{id:"46",division_id:"2",name:"Feni",bn_name:"ফেনী",lat:"23.023231",long:"91.3840844"},{id:"47",division_id:"2",name:"Khagrachari",bn_name:"খাগড়াছড়ি",lat:"23.119285",long:"91.984663"},{id:"48",division_id:"2",name:"Lakshmipur",bn_name:"লক্ষ্মীপুর",lat:"22.942477",long:"90.841184"},{id:"49",division_id:"2",name:"Noakhali",bn_name:"নোয়াখালী",lat:"22.869563",long:"91.099398"},{id:"50",division_id:"2",name:"Rangamati",bn_name:"রাঙ্গামাটি",lat:"0",long:"0"},{id:"51",division_id:"7",name:"Habiganj",bn_name:"হবিগঞ্জ",lat:"24.374945",long:"91.41553"},{id:"52",division_id:"7",name:"Maulvibazar",bn_name:"মৌলভীবাজার",lat:"24.482934",long:"91.777417"},{id:"53",division_id:"7",name:"Sunamganj",bn_name:"সুনামগঞ্জ",lat:"25.0658042",long:"91.3950115"},{id:"54",division_id:"7",name:"Sylhet",bn_name:"সিলেট",lat:"24.8897956",long:"91.8697894"},{id:"55",division_id:"4",name:"Bagerhat",bn_name:"বাগেরহাট",lat:"22.651568",long:"89.785938"},{id:"56",division_id:"4",name:"Chuadanga",bn_name:"চুয়াডাঙ্গা",lat:"23.6401961",long:"88.841841"},{id:"57",division_id:"4",name:"Jashore",bn_name:"যশোর",lat:"23.16643",long:"89.2081126"},{id:"58",division_id:"4",name:"Jhenaidah",bn_name:"ঝিনাইদহ",lat:"23.5448176",long:"89.1539213"},{id:"59",division_id:"4",name:"Khulna",bn_name:"খুলনা",lat:"22.815774",long:"89.568679"},{id:"60",division_id:"4",name:"Kushtia",bn_name:"কুষ্টিয়া",lat:"23.901258",long:"89.120482"},{id:"61",division_id:"4",name:"Magura",bn_name:"মাগুরা",lat:"23.487337",long:"89.419956"},{id:"62",division_id:"4",name:"Meherpur",bn_name:"মেহেরপুর",lat:"23.762213",long:"88.631821"},{id:"63",division_id:"4",name:"Narail",bn_name:"নড়াইল",lat:"23.172534",long:"89.512672"},{id:"64",division_id:"4",name:"Satkhira",bn_name:"সাতক্ষীরা",lat:"0",long:"0"}]},"7asN":function(t,e,n){"use strict";var i={name:"Invoice"},a=n("KHd+"),o=Object(a.a)(i,(function(){var t=this.$createElement;return(this._self._c||t)("div")}),[],!1,null,"52743ccd",null);e.a=o.exports},QK5V:function(t,e,n){var i=n("LboF"),a=n("xA+E");"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.i,a,""]]);var o={insert:"head",singleton:!1};i(a,o);t.exports=a.locals||{}},UYTr:function(t,e,n){"use strict";e.a=[{text:_t("bank","Bank"),value:"Bank"},{text:_t("cash","Cash"),value:"Cash"},{text:_t("card","Card"),value:"Card"},{text:_t("bkash","bKash"),value:"bKash"},{text:_t("rocket","Rocket"),value:"Rocket"}]},WaG5:function(t,e,n){"use strict";e.a=[{text:_t("returned","Returned"),value:"Returned"},{text:_t("processed","Processed"),value:"Processed"},{text:_t("cancelled","Cancelled"),value:"Cancelled"}]},Wfu5:function(t,e,n){"use strict";n.r(e);var i=n("j01/"),a=n("X/aF"),o=n("3fRZ"),r=n("Wgwc"),s=n.n(r),l=n("UYTr"),d=n("WaG5"),u=n("fW/5"),c=n("7asN"),m={mixins:[i.a],components:{VueSelect:o.a,CustomerAdd:u.default,Invoice:c.a},props:{submit_url:{type:String,default:function(){return route("Backend.Sales.Store")}},payment_options:{type:Array,default:function(){return l.a}},statuses:{type:Array,default:function(){return d.a}}},data:function(){return{submit_disabled:!1,sale_id:null,search_category:null,searched_items:{data:[]},customer_balance:0,customer_add_modal_visible:!1,item_fields:[{key:"action",label:_t("action","Action")},{key:"name",label:_t("name","Name"),formatter:function(t,e,n){return[n.product_id,n.name,n.code].join(" # ")}},{key:"price",label:_t("sales.price","Price")},{key:"quantity",label:_t("quantity","Quantity")},{key:"payable",label:_t("total","Total")}]}},mounted:function(){this.$set(this,"form",{items:[],date:s()().format("YYYY-MM-DD"),status:"Processed",tax:0,discount:0,customer:null,payment_method:"Cash",payment_amount:0}),this.getCatProducts()},watch:{search_category:function(){this.getCatProducts()}},computed:{getTotal:function(){var t=0;for(var e in this.form.items)t+=this.getItemPayable(this.form.items[e]);return t},getPayable:function(){return this.getTotal*(1+this.form.tax/100-this.form.discount/100)}},methods:{colSum:a.d,printInvoice:function(){var t=document.getElementById("print_invoice").contentWindow;t.focus(),t.print()},handleSubmit:function(){var t=this;if(this.$refs.theForm.reportValidity()){if(!(Object(a.j)(this.form.items)&&this.form.items.length>0))return alert("Please Select Items First"),this.$refs.productSelector.$el.querySelector("button").click(),!1;this.submit_disabled=!0,this.onSubmit((function(e){t.$bvModal.show("invoice-modal"),t.sale_id=e.data.sale_id,t.$set(t,"form",{items:[],date:s()().format("YYYY-MM-DD"),status:"Processed",tax:0,discount:0,customer:null,payment_method:"Cash",payment_amount:0}),t.submit_disabled=!1,t.$set(t,"customer_balance",0)}))}},slugify:a.u,objPhotoUrl:a.n,addProductToCart:function(t){var e=JSON.parse(JSON.stringify(this.form.items)),n=e.find((function(e){return e.code===t.code}));n?n.quantity++:e.push({product_id:t.id,price:t.price||0,quantity:1,code:t.code,name:t.name,tax:t.tax||0,discount:t.discount||0}),this.$set(this.form,"product_temp",null),this.$set(this.form,"items",e)},getItemPayable:function(t){return t.quantity*t.price*(1-Number(t.discount)/100+Number(t.tax)/100)},removeCartItem:function(t){confirm("Are You Sure?")&&this.form.items.splice(t.index,1)},getCatProducts:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;axios.post(e||route("Backend.Products.POS.Items"),{category_id:this.search_category?this.search_category.id:null}).then((function(e){t.$set(t,"searched_items",e.data)})).catch((function(e){t.$set(t,"searched_items",{data:[]}),console.log(e.response)}))}}},_=(n("/4Mc"),n("KHd+")),p=Object(_.a)(m,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("b-form-row",[n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-card",{staticClass:"h-100",attrs:{"body-class":"p-2"}},[n("b-form",{ref:"theForm",on:{submit:function(e){return e.preventDefault(),t.handleSubmit(e)}}},[n("b-form-group",[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                    "+t._s(t.__("customer","Customer"))+"\n                                ")])]},proxy:!0},{key:"append",fn:function(){return[n("b-button",{staticClass:"font-weight-bold",on:{click:function(e){t.form.customer=null,t.form.customer_id=null,t.customer_balance=0}}},[t._v("\n                                    X\n                                ")]),t._v(" "),n("b-button",{attrs:{variant:"dark"},on:{click:function(e){t.customer_add_modal_visible=!0}}},[n("i",{staticClass:"fa fa-plus"})])]},proxy:!0}])},[t._v(" "),n("vue-select",{attrs:{"init-options":!0,required:!0,"tag-text":function(e){return e?[e.id,e.name,e.phone,e.village].join(" # "):t.__("not_selected","Not Selected")},"option-text":function(t){return t?[t.id,t.name,t.phone,t.village].join(" # "):""},api_url:t.route("Backend.Customers.Search")},on:{input:function(e){t.form.customer_id=e?e.id:null,t.customer_balance=e?e.balance:0}},model:{value:t.form.customer,callback:function(e){t.$set(t.form,"customer",e)},expression:"form.customer"}})],1)],1),t._v(" "),n("b-form-group",{staticClass:"mb-1"},[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                    "+t._s(t.__("select_product","Select Product"))+"\n                                ")])]},proxy:!0}])},[t._v(" "),n("vue-select",{ref:"productSelector",attrs:{"get-filtered":function(e){return e.filter((function(e){return!t.form.items.map((function(t){return t.code})).includes(e.code)}))},"init-options":!0,"option-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Products.Search")},on:{input:function(e){t.addProductToCart(e),t.$set(t.form,"product_temp",null)}},model:{value:t.form.product_temp,callback:function(e){t.$set(t.form,"product_temp",e)},expression:"form.product_temp"}})],1)],1),t._v(" "),n("b-table",{attrs:{responsive:"",bordered:"",small:"",hover:"",striped:"","head-variant":"dark",fields:t.item_fields,items:t.form.items},scopedSlots:t._u([{key:"cell(price)",fn:function(e){return[n("b-input-group",{attrs:{size:"sm",append:t.$options.filters.currencySymbol(0)}},[n("b-input",{staticStyle:{"min-width":"100px"},attrs:{type:"number",step:"any",placeholder:t.__("sales.price","Price"),required:!0},model:{value:e.item.price,callback:function(n){t.$set(e.item,"price",n)},expression:"row.item.price"}})],1)]}},{key:"cell(quantity)",fn:function(e){return[n("b-input",{staticStyle:{"min-width":"50px"},attrs:{type:"number",step:"any",placeholder:t.__("quantity","Quantity"),required:!0,size:"sm"},model:{value:e.item.quantity,callback:function(n){t.$set(e.item,"quantity",n)},expression:"row.item.quantity"}})]}},{key:"cell(total)",fn:function(e){return[t._v("\n                            "+t._s(t._f("currency")(e.item.quantity*e.item.price))+"\n                        ")]}},{key:"cell(tax)",fn:function(e){return[n("b-input-group",{attrs:{append:"%",size:"sm"}},[n("b-input",{attrs:{type:"number",step:"any",placeholder:t.__("tax","Tax"),required:!0},model:{value:e.item.tax,callback:function(n){t.$set(e.item,"tax",n)},expression:"row.item.tax"}})],1)]}},{key:"cell(discount)",fn:function(e){return[n("b-input-group",{attrs:{append:"%",size:"sm"}},[n("b-input",{attrs:{type:"number",step:"any",placeholder:t.__("discount","Discount"),required:!0},model:{value:e.item.discount,callback:function(n){t.$set(e.item,"discount",n)},expression:"row.item.discount"}})],1)]}},{key:"cell(payable)",fn:function(e){return[t._v("\n                            "+t._s(t._f("currency")(t.getItemPayable(e.item)))+"\n                        ")]}},{key:"cell(action)",fn:function(e){return[n("b-button",{attrs:{size:"sm"},on:{click:function(n){return t.removeCartItem(e)}}},[n("b-icon-trash")],1)]}},{key:"custom-foot",fn:function(){return[n("b-tr",[n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:3}},[t._v("\n                                    "+t._s(t.__("price","Price"))+"\n                                ")]),t._v(" "),n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:4}},[t._v("\n                                    "+t._s(t._f("currency")(t.getPayable))+"\n                                ")])],1),t._v(" "),n("b-tr",[n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:3}},[t._v("\n                                    "+t._s(t.__("previous_balance","Previous Balance"))+"\n                                ")]),t._v(" "),n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:4}},[t._v("\n                                    "+t._s(t._f("currency")(t.customer_balance))+"\n                                ")])],1),t._v(" "),n("b-tr",[n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:3}},[t._v("\n                                    "+t._s(t.__("total","Total"))+"\n                                ")]),t._v(" "),n("b-td",{staticClass:"text-right font-weight-bold",attrs:{colspan:4}},[t._v("\n                                    "+t._s(t._f("currency")(t.customer_balance+t.getPayable))+"\n                                ")])],1)]},proxy:!0}])}),t._v(" "),n("b-form-row",[n("b-col",{attrs:{md:"6",sm:"12"}},[n("b-form-group",{attrs:{label:t.__("payment_method","Payment Method")}},[n("b-form-select",{attrs:{options:t.payment_options},model:{value:t.form.payment_method,callback:function(e){t.$set(t.form,"payment_method",e)},expression:"form.payment_method"}})],1)],1),t._v(" "),n("b-col",{attrs:{md:"6",sm:"12"}},[n("b-form-group",{attrs:{label:t.__("sales.payment_amount","Payment Amount")}},[n("b-input-group",{scopedSlots:t._u([{key:"append",fn:function(){return[n("b-button",{attrs:{variant:"dark"},on:{click:function(e){t.form.payment_amount=t.getPayable+t.customer_balance}}},[t._v("\n                                            "+t._s(t.__("full","Full"))+"\n                                        ")])]},proxy:!0}])},[n("b-input",{attrs:{step:"any",type:"number",placeholder:t.__("sales.payment_amount","Payment Amount"),required:!0},model:{value:t.form.payment_amount,callback:function(e){t.$set(t.form,"payment_amount",e)},expression:"form.payment_amount"}})],1)],1)],1)],1),t._v(" "),n("b-form-row",[n("b-col",{attrs:{md:"6",sm:"12"}},[n("b-form-group",{attrs:{label:t.__("date","Date")}},[n("b-form-input",{attrs:{type:"date"},model:{value:t.form.date,callback:function(e){t.$set(t.form,"date",e)},expression:"form.date"}})],1)],1),t._v(" "),n("b-col",{attrs:{md:"6",sm:"12"}},[n("b-form-group",{attrs:{label:t.__("current_balance","Current Balance")}},[n("div",{staticClass:"form-control"},[t._v("\n                                    "+t._s(t._f("currency")(Number(t.customer_balance)+Number(t.getPayable)-Number(t.form.payment_amount)))+"\n                                ")])])],1)],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("note","Note")}},[n("b-form-textarea",{attrs:{rows:4,placeholder:t.__("sales_note","Sales Note")},model:{value:t.form.note,callback:function(e){t.$set(t.form,"note",e)},expression:"form.note"}})],1),t._v(" "),n("b-button",{attrs:{type:"submit",block:"",variant:"dark",disabled:t.submit_disabled}},[t._v("\n                        "+t._s(t.__("submit","SUBMIT"))+"\n                    ")])],1)],1)],1),t._v(" "),n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-card",{staticClass:"h-100",attrs:{"body-class":"p-2 mh-60vh overflow-auto","header-class":"px-2"},scopedSlots:t._u([{key:"header",fn:function(){return[n("b-input-group",{scopedSlots:t._u([{key:"prepend",fn:function(){return[n("b-input-group-text",{staticStyle:{"min-width":"200px"}},[t._v("\n                                "+t._s(t.__("select_category","Select Category"))+"\n                            ")])]},proxy:!0},{key:"append",fn:function(){return[n("b-button",{on:{click:function(e){t.search_category=null}}},[t._v("x")])]},proxy:!0}])},[t._v(" "),t._v(" "),n("vue-select",{attrs:{"init-options":!0,"option-text":function(t){return[t.id,t.name,t.code].join(" # ")},"tag-text":function(e){return e?[e.id,e.name,e.code].join(" # "):t.__("not_selected","Not Selected")},api_url:t.route("Backend.Categories.Search")},model:{value:t.search_category,callback:function(e){t.search_category=e},expression:"search_category"}})],1)]},proxy:!0},{key:"footer",fn:function(){return[n("b-row",[n("b-col",[t._v("\n                            "+t._s(t.__("total","Total"))+" : "+t._s(t._f("localNumber")(t.searched_items.total))+"\n                            "+t._s(t.__("items","Items"))+",\n                            "+t._s(t.__("page","Page"))+" : "+t._s(t._f("localNumber")(t.searched_items.current_page))+"/\n                            "+t._s(t._f("localNumber")(t.searched_items.last_page))+"\n                        ")]),t._v(" "),n("b-col",{staticClass:"text-right"},[t.searched_items.prev_page_url?n("b-button",{attrs:{variant:"dark",size:"sm"},on:{click:function(e){return t.getCatProducts(t.searched_items.prev_page_url)}}},[n("i",{staticClass:"fa fa-angle-double-left"}),t._v("\n                                "+t._s(t.__("previous","Previous"))+"\n                            ")]):t._e(),t._v(" "),t.searched_items.next_page_url?n("b-button",{attrs:{variant:"dark",size:"sm"},on:{click:function(e){return t.getCatProducts(t.searched_items.next_page_url)}}},[t._v("\n                                "+t._s(t.__("next","Next"))+"\n                                "),n("i",{staticClass:"fa fa-angle-double-right"})]):t._e()],1)],1)]},proxy:!0}])},[t._v(" "),n("b-form-row",t._l(t.searched_items.data,(function(e,i){return n("b-col",{key:i,staticClass:"mb-2",attrs:{md:"4",sm:"6"}},[n("b-card",{staticClass:"h-100",staticStyle:{"background-size":"cover",cursor:"pointer"},style:{backgroundImage:"url("+e.photo_url+")"},attrs:{"body-class":"text-white product-image",title:e.name},on:{click:function(n){return t.addProductToCart(e)}}},[n("table",[n("tr",[n("td",[t._v(t._s(t.__("code","Code")))]),t._v(" "),n("td",[t._v(": "+t._s(e.code))])]),t._v(" "),n("tr",[n("td",[t._v(t._s(t.__("price","Price")))]),t._v(" "),n("td",[t._v(": "+t._s(t._f("currency")(e.price)))])]),t._v(" "),n("tr",[n("td",[t._v(t._s(t.__("quantity","Quantity")))]),t._v(" "),n("td",[t._v(": "+t._s(t._f("localNumber")(e.quantity)))])])])])],1)})),1)],1)],1)],1),t._v(" "),n("customer-add",{attrs:{visibility:t.customer_add_modal_visible,"hidden-callback":function(){t.customer_add_modal_visible=!1}},on:{created:function(e){t.$set(t.form,"customer",e.item),t.$set(t.form,"customer_id",e.item.id)}}}),t._v(" "),n("b-modal",{attrs:{size:"xl","body-class":"p-0","header-bg-variant":"dark","header-text-variant":"light","footer-bg-variant":"dark","footer-text-variant":"light",title:t.__("sale_invoice","Sale Invoice"),id:"invoice-modal",lazy:"","no-close-on-backdrop":"","no-close-on-esc":""},on:{hidden:function(e){t.sale_id=null}},scopedSlots:t._u([{key:"modal-footer",fn:function(e){var i=e.close;return[n("b-button",{attrs:{href:t.route("Backend.Sales.Invoice.PDF",{sale:t.sale_id,type:"pdf"}),target:"_blank",variant:"primary"}},[n("i",{staticClass:"fa fa-file-pdf"}),t._v("\n                "+t._s(t.__("pdf","PDF"))+"\n            ")]),t._v(" "),n("b-button",{attrs:{variant:"primary"},on:{click:t.printInvoice}},[n("i",{staticClass:"fa fa-print"}),t._v("\n                "+t._s(t.__("print","Print"))+"\n            ")]),t._v(" "),n("b-button",{attrs:{variant:"secondary"},on:{click:i}},[t._v("Close")])]}}])},[t.sale_id?n("b-embed",{attrs:{id:"print_invoice",aspect:"16by9",allowfullscreen:"",src:t.route("Backend.Sales.Invoice.PDF",{sale:t.sale_id,type:"html"})}}):t._e()],1)],1)}),[],!1,null,null,null);e.default=p.exports},c9im:function(t,e,n){"use strict";var i=n("QK5V");n.n(i).a},"fW/5":function(t,e,n){"use strict";n.r(e);var i=n("j01/"),a=n("4Gdk"),o={mixins:[i.a],props:{submit_url:{type:String,default:function(){return route("Backend.Customers.Store")}},hiddenCallback:{type:Function,default:function(){this.$router.go(-1),this.$emit("reset",!0)}},visibility:{type:Boolean,default:!0}},data:function(){return{districts:a.a}},created:function(){this.visible=this.visibility},watch:{visibility:function(t){this.visible=t}}},r=n("KHd+"),s=Object(r.a)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-modal",{attrs:{size:"xl","header-bg-variant":"dark","header-text-variant":"light","no-body":"",title:t.__((t.form.id?"edit":"add")+"_customer",(t.form.id?"Edit ":"Add ")+"Customer"),lazy:""},on:{hidden:function(){t.hiddenCallback()}},scopedSlots:t._u([{key:"modal-footer",fn:function(e){var i=e.cancel;return[n("b-button",{ref:"submitBtn",attrs:{variant:"primary"},on:{click:function(){t.$refs.theForm.reportValidity()&&t.onSubmit()}}},[t._v("\n            "+t._s(t.__("submit","SUBMIT"))+"\n        ")]),t._v(" "),n("b-button",{on:{click:function(t){return i()}}},[t._v("\n            "+t._s(t.__("cancel","CANCEL"))+"\n        ")])]}}]),model:{value:t.visible,callback:function(e){t.visible=e},expression:"visible"}},[n("form",{ref:"theForm",on:{submit:function(e){e.preventDefault(),t.$refs.theForm.reportValidity()&&t.onSubmit()}}},[n("b-row",[n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-form-group",{attrs:{label:t.__("name","Name")}},[n("b-form-input",{attrs:{type:"text",placeholder:t.__("name","Name")},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("email","Email")}},[n("b-form-input",{attrs:{type:"email",placeholder:t.__("email_address","Email Address")},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("phone","Phone")}},[n("b-form-input",{attrs:{type:"tel",placeholder:t.__("phone_number","Phone Number")},model:{value:t.form.phone,callback:function(e){t.$set(t.form,"phone",e)},expression:"form.phone"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("company","Company")}},[n("b-form-input",{attrs:{type:"text",placeholder:t.__("company","Company")},model:{value:t.form.company,callback:function(e){t.$set(t.form,"company",e)},expression:"form.company"}})],1),t._v(" "),t.form.photo?n("div",[n("b-button",{staticStyle:{position:"absolute",right:"16px"},on:{click:function(e){t.form.photo=null}}},[t._v("\n                        X\n                    ")]),t._v(" "),n("b-img-lazy",{staticStyle:{"max-height":"150px"},attrs:{thumbnail:"",src:"storage/"+t.form.photo}})],1):t._e(),t._v(" "),n("b-form-group",{attrs:{label:t.__("photo","Photo")}},[n("b-input-group",{scopedSlots:t._u([{key:"append",fn:function(){return[n("b-button",{on:{click:function(e){t.form.photo_upload=null}}},[t._v("X")])]},proxy:!0}])},[n("b-form-file",{model:{value:t.form.photo_upload,callback:function(e){t.$set(t.form,"photo_upload",e)},expression:"form.photo_upload"}})],1)],1)],1),t._v(" "),n("b-col",{attrs:{sm:"12",md:"6"}},[n("b-form-group",{attrs:{label:t.__("district","District")}},[n("b-form-select",{attrs:{"text-field":"bn_name","value-field":"name",options:t.districts},model:{value:t.form.district,callback:function(e){t.$set(t.form,"district",e)},expression:"form.district"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("thana","Thana")}},[n("b-form-input",{attrs:{type:"text",placeholder:t.__("thana","Thana")},model:{value:t.form.thana,callback:function(e){t.$set(t.form,"thana",e)},expression:"form.thana"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("post_office","Post Office")}},[n("b-form-input",{attrs:{type:"text",placeholder:t.__("post_office","Post Office")},model:{value:t.form.post_office,callback:function(e){t.$set(t.form,"post_office",e)},expression:"form.post_office"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("village","Village")}},[n("b-form-input",{attrs:{type:"text",placeholder:t.__("village","Village")},model:{value:t.form.village,callback:function(e){t.$set(t.form,"village",e)},expression:"form.village"}})],1),t._v(" "),n("b-form-group",{attrs:{label:t.__("shipping_address","Shipping Address")}},[n("b-form-textarea",{attrs:{placeholder:"Shipping Address"},model:{value:t.form.shipping_address,callback:function(e){t.$set(t.form,"shipping_address",e)},expression:"form.shipping_address"}})],1)],1)],1)],1)])}),[],!1,null,null,null);e.default=s.exports},"j01/":function(t,e,n){"use strict";var i=n("X/aF");e.a={props:{getCreatedItem:{type:Boolean,default:!1},item:{type:Object,default:function(){return{}}}},mounted:function(){this.form=this.item,Object(i.i)(this,(function(){}))},data:function(){return{form:{},errors:null,visible:!0}},methods:{getItem:i.g,onSubmit:i.o,hitSubmit:function(){this.$refs.submitBtn.click()},hasError:function(t){return!!(this.errors&&this.errors[t]&&this.errors[t].length)},getErrorMsg:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:",";return this.hasError(t)?this.errors[t].join(e):""}}}},"xA+E":function(t,e,n){(e=n("JPst")(!1)).push([t.i,".vue-select .dropdown-menu {\n  max-height: 300px;\n  overflow-y: auto;\n  width: 100%;\n}\n.vue-select .dropdown-toggle::after {\n  position: absolute;\n  right: 10px;\n  top: 49%;\n}\n.vue-select .border-radius-0 {\n  border-radius: 0 !important;\n}\n.vue-select .top-reverse-100 {\n  top: -100% !important;\n}\n.vue-select .hide-dd-icon .dropdown-toggle::after {\n  display: none !important;\n}\n.vue-select.is-invalid, .vue-select.is-valid {\n  background-position: right calc(1.4em + 0.1875rem) center !important;\n}",""]),t.exports=e}}]);