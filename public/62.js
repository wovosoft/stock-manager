(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[62],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/units/List.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/units/List.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _partials_DtHeader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/partials/DtHeader */ "./resources/js/partials/DtHeader.vue");
/* harmony import */ var _partials_DtFooter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/partials/DtFooter */ "./resources/js/partials/DtFooter.vue");
/* harmony import */ var _partials_datatable__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/partials/datatable */ "./resources/js/partials/datatable.js");
/* harmony import */ var _partials_DtTable__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/partials/DtTable */ "./resources/js/partials/DtTable.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
  name: "UnitsList",
  components: {
    DtHeader: _partials_DtHeader__WEBPACK_IMPORTED_MODULE_0__["default"],
    DtFooter: _partials_DtFooter__WEBPACK_IMPORTED_MODULE_1__["default"],
    DtTable: _partials_DtTable__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  mixins: [_partials_datatable__WEBPACK_IMPORTED_MODULE_2__["default"]],
  props: {
    title: {
      type: String,
      "default": _t('units', 'Units')
    },
    api_url: {
      type: String,
      "default": function _default() {
        return route('Backend.Units.List').url();
      }
    },
    trash_url: {
      type: String,
      "default": function _default() {
        return route('Backend.Units.Delete').url();
      }
    },
    submit_url: {
      type: String,
      "default": function _default() {
        return route('Backend.Units.Store').url();
      }
    },
    custom_buttons: {
      type: Array,
      "default": function _default() {
        return [{
          text: _t('add', 'Add'),
          variant: 'dark',
          to: {
            name: 'UnitsAdd'
          }
        }, {
          text: _t('history', 'History'),
          variant: 'primary',
          to: {
            name: 'ModelHistory',
            params: {
              model: 'units'
            }
          }
        }];
      }
    }
  },
  methods: {
    commonDtOptions: function commonDtOptions() {
      return Object(_partials_datatable__WEBPACK_IMPORTED_MODULE_2__["commonDtOptions"])(this);
    }
  },
  data: function data() {
    var _this = this;

    return {
      form: {},
      fields: [{
        key: 'id',
        sortable: true,
        label: _t('id', 'ID')
      }, {
        key: 'name',
        sortable: true,
        label: _t('name', 'Name')
      }, {
        key: 'description',
        label: _t('description', 'Description'),
        sortable: true,
        formatter: function formatter(v) {
          return _this.$options.filters.truncate(v || "");
        }
      }, {
        key: 'created_at',
        sortable: true,
        label: _t('created_at', 'Created At'),
        formatter: function formatter(v) {
          return _this.$options.filters.localDateTime(v);
        }
      }, {
        key: 'updated_at',
        sortable: true,
        label: _t('updated_at', 'Updated At'),
        formatter: function formatter(v) {
          return _this.$options.filters.localDateTime(v);
        }
      }, {
        key: 'action',
        sortable: false,
        label: _t('action', 'Action'),
        searchable: false,
        thClass: 'text-right',
        tdClass: 'text-right'
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/units/List.vue?vue&type=template&id=67206ce9&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/units/List.vue?vue&type=template&id=67206ce9& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("dt-table", {
        attrs: {
          title: _vm.__(_vm.title, _vm.startCase(_vm.title)),
          fields: _vm.fields,
          datatable: _vm.datatable,
          custom_buttons: _vm.custom_buttons
        },
        scopedSlots: _vm._u([
          {
            key: "table",
            fn: function() {
              return [
                _c(
                  "b-table",
                  _vm._b(
                    {
                      ref: "datatable",
                      attrs: { responsive: "md" },
                      scopedSlots: _vm._u([
                        {
                          key: "cell(action)",
                          fn: function(row) {
                            return [
                              _c(
                                "b-button-group",
                                { attrs: { size: "sm" } },
                                [
                                  _c(
                                    "b-button",
                                    {
                                      attrs: {
                                        variant: "primary",
                                        title: _vm.__("view", "View"),
                                        to: {
                                          name: "UnitsView",
                                          params: { id: row.item.id }
                                        }
                                      },
                                      on: {
                                        click: function($event) {
                                          _vm.currentItem = JSON.parse(
                                            JSON.stringify(row.item)
                                          )
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fa fa-eye" })]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-button",
                                    {
                                      attrs: {
                                        variant: "warning",
                                        title: _vm.__("edit", "Edit"),
                                        to: {
                                          name: "UnitsEdit",
                                          params: { id: row.item.id }
                                        }
                                      },
                                      on: {
                                        click: function($event) {
                                          _vm.currentItem = JSON.parse(
                                            JSON.stringify(row.item)
                                          )
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fa fa-edit" })]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-button",
                                    {
                                      attrs: {
                                        variant: "danger",
                                        title: _vm.__("delete", "Delete")
                                      },
                                      on: {
                                        click: function($event) {
                                          return _vm.trash(row.item.id)
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fa fa-trash" })]
                                  )
                                ],
                                1
                              )
                            ]
                          }
                        }
                      ])
                    },
                    "b-table",
                    _vm.commonDtOptions(),
                    false
                  )
                )
              ]
            },
            proxy: true
          }
        ]),
        model: {
          value: _vm.search,
          callback: function($$v) {
            _vm.search = $$v
          },
          expression: "search"
        }
      }),
      _vm._v(" "),
      _c("router-view", {
        attrs: { item: _vm.currentItem },
        on: {
          reset: function($event) {
            _vm.currentItem = {}
          },
          refreshDatatable: function() {
            return _vm.$refs.datatable.refresh()
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/units/List.vue":
/*!************************************************!*\
  !*** ./resources/js/components/units/List.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./List.vue?vue&type=template&id=67206ce9& */ "./resources/js/components/units/List.vue?vue&type=template&id=67206ce9&");
/* harmony import */ var _List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./List.vue?vue&type=script&lang=js& */ "./resources/js/components/units/List.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__["render"],
  _List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/units/List.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/units/List.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/units/List.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./List.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/units/List.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/units/List.vue?vue&type=template&id=67206ce9&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/units/List.vue?vue&type=template&id=67206ce9& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./List.vue?vue&type=template&id=67206ce9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/units/List.vue?vue&type=template&id=67206ce9&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_67206ce9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);