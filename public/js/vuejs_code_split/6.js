(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Header.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Header.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
  props: {
    title: {
      type: String,
      required: true,
      "default": ''
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/laporan.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/laporan.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_Header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/Header */ "./resources/js/components/Header.vue");
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
  components: {
    CHeader: _components_Header__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      selectedDompet: 1,
      selectedJenis: '',
      tahun: 0,
      bulan: 0,
      tanggal_mulai: '',
      tanggal_akhir: '',
      dataDompet: [],
      dataTahun: [],
      dataBulan: [],
      dataJenis: [{
        value: 'tahun',
        text: 'Tahun'
      }, {
        value: 'bulan',
        text: 'Bulan'
      }, {
        value: 'tanggal',
        text: 'Tanggal'
      }],
      laporan: {
        isHidden: true,
        isLoading: true,
        fields: ['tanggal_transaksi', 'keterangan', 'pemasukan', 'pengeluaran'],
        data: [],
        totalPemasukan: 0,
        totalPengeluaran: 0
      },
      url: ''
    };
  },
  computed: {
    getTotal: function getTotal() {
      return this.laporan.totalPemasukan - this.laporan.totalPengeluaran;
    }
  },
  mounted: function mounted() {
    this.load();
  },
  methods: {
    load: function load() {
      var _this = this;

      window.axios.get('/dompet').then(function (res) {
        res.data.data.forEach(function (dompet) {
          var data = {
            value: dompet.id,
            text: dompet.nama
          };

          _this.dataDompet.push(data);
        });
        return window.axios.get('/transaksi-tanggal');
      }).then(function (res) {
        _this.dataTahun = Array.from(new Set(res.data.tahun));
        _this.dataBulan = window._.uniqBy(res.data.bulan, 'value');
      });
    },
    filterLaporan: function filterLaporan() {
      var _this2 = this;

      this.laporan.isLoading = true;
      var url = "/laporan?dompet=".concat(this.selectedDompet, "&jenis=").concat(this.selectedJenis);
      this.url = "/laporan/pdf?dompet=".concat(this.selectedDompet, "&jenis=").concat(this.selectedJenis);

      if (this.selectedJenis === 'tahun') {
        url = url + "&tahun=".concat(this.tahun);
        this.url += "&tahun=".concat(this.tahun);
      } else if (this.selectedJenis === 'bulan') {
        url = url + "&bulan=".concat(this.bulan);
        this.url += "&bulan=".concat(this.bulan);
      } else {
        url = url + "&tanggal_mulai=".concat(this.tanggal_mulai, "&tanggal_akhir=").concat(this.tanggal_akhir);
        this.url += "&tanggal_mulai=".concat(this.tanggal_mulai, "&tanggal_akhir=").concat(this.tanggal_akhir);
      }

      this.laporan.isHidden = false;
      window.axios.get(url).then(function (res) {
        _this2.laporan.isLoading = false;
        _this2.laporan.data = res.data;

        _this2.laporan.data.forEach(function (trans) {
          _this2.laporan.totalPemasukan += trans.pemasukan;
          _this2.laporan.totalPengeluaran += trans.pengeluaran;
        });
      });
    },
    pdf: function pdf() {
      window.open(this.url, '_blank');
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Header.vue?vue&type=template&id=1f42fb90&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Header.vue?vue&type=template&id=1f42fb90& ***!
  \*********************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "content-header" }, [
    _c("div", { staticClass: "row mb-2" }, [
      _c("div", { staticClass: "col-sm-6" }, [
        _c("h1", { staticClass: "m-0 text-dark" }, [_vm._v(_vm._s(_vm.title))])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-6" }, [
        _c("ol", { staticClass: "breadcrumb float-sm-right" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("li", { staticClass: "breadcrumb-item active" }, [
            _vm._v(_vm._s(_vm.title))
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", { staticClass: "breadcrumb-item" }, [
      _c("a", { attrs: { href: "#" } }, [_vm._v("Home")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c& ***!
  \*****************************************************************************************************************************************************************************************************/
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
    { staticClass: "no" },
    [
      _c("CHeader", { attrs: { title: _vm.$route.name } }),
      _vm._v(" "),
      _c("div", { staticClass: "bg-white rounded shadow pl-4 py-4" }, [
        _c(
          "div",
          { staticClass: "row w-100 mb-4" },
          [
            _c("span", { staticClass: "col my-auto" }, [
              _vm._v("Pilih Dompet: ")
            ]),
            _vm._v(" "),
            _c("b-form-select", {
              staticClass: "col-10 w-100",
              attrs: { options: _vm.dataDompet },
              model: {
                value: _vm.selectedDompet,
                callback: function($$v) {
                  _vm.selectedDompet = $$v
                },
                expression: "selectedDompet"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "row w-100 mb-4" },
          [
            _c("span", { staticClass: "col my-auto" }, [
              _vm._v("Pilih Jenis: ")
            ]),
            _vm._v(" "),
            _c("b-form-select", {
              staticClass: "col-10",
              attrs: { options: _vm.dataJenis },
              model: {
                value: _vm.selectedJenis,
                callback: function($$v) {
                  _vm.selectedJenis = $$v
                },
                expression: "selectedJenis"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _vm.selectedJenis === "tahun"
          ? _c(
              "div",
              { staticClass: "row w-100 mb-4" },
              [
                _c("span", { staticClass: "col my-auto" }, [
                  _vm._v("Pilih Tahun: ")
                ]),
                _vm._v(" "),
                _c("b-form-select", {
                  staticClass: "col-10",
                  attrs: { locale: "id", options: _vm.dataTahun },
                  model: {
                    value: _vm.tahun,
                    callback: function($$v) {
                      _vm.tahun = $$v
                    },
                    expression: "tahun"
                  }
                })
              ],
              1
            )
          : _vm.selectedJenis === "bulan"
          ? _c(
              "div",
              { staticClass: "row w-100 mb-4" },
              [
                _c("span", { staticClass: "col my-auto" }, [
                  _vm._v("Pilih Bulan: ")
                ]),
                _vm._v(" "),
                _c("b-form-select", {
                  staticClass: "col-10",
                  attrs: { options: _vm.dataBulan },
                  model: {
                    value: _vm.bulan,
                    callback: function($$v) {
                      _vm.bulan = $$v
                    },
                    expression: "bulan"
                  }
                })
              ],
              1
            )
          : _vm.selectedJenis === "tanggal"
          ? _c(
              "div",
              { staticClass: "row w-100 mb-4" },
              [
                _c("span", { staticClass: "col-3 my-auto" }, [
                  _vm._v("Pilih Tanggal Mulai: ")
                ]),
                _vm._v(" "),
                _c("b-form-datepicker", {
                  staticClass: "col-3",
                  attrs: { locale: "id" },
                  model: {
                    value: _vm.tanggal_mulai,
                    callback: function($$v) {
                      _vm.tanggal_mulai = $$v
                    },
                    expression: "tanggal_mulai"
                  }
                }),
                _vm._v(" "),
                _c("span", { staticClass: "col-3 my-auto" }, [
                  _vm._v("Pilih Tanggal Akhir: ")
                ]),
                _vm._v(" "),
                _c("b-form-datepicker", {
                  staticClass: "col-3",
                  attrs: { locale: "id" },
                  model: {
                    value: _vm.tanggal_akhir,
                    callback: function($$v) {
                      _vm.tanggal_akhir = $$v
                    },
                    expression: "tanggal_akhir"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "row pl-2 w-100",
            class: { "mb-4": !_vm.laporan.isHidden }
          },
          [
            _c(
              "b-button",
              {
                staticClass: "col align-self-end",
                attrs: { variant: "primary" },
                on: { click: _vm.filterLaporan }
              },
              [_vm._v("Filter")]
            )
          ],
          1
        ),
        _vm._v(" "),
        !_vm.laporan.isHidden
          ? _c("div", { staticClass: "pr-4" }, [
              _c("h4", [_vm._v("Preview")]),
              _vm._v(" "),
              _vm.laporan.data && !_vm.laporan.isLoading
                ? _c(
                    "div",
                    [
                      _c("b-table", {
                        staticClass: "pr-4",
                        attrs: {
                          striped: "",
                          hover: "",
                          items: _vm.laporan.data,
                          fields: _vm.laporan.fields
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "cell(pemasukan)",
                              fn: function(data) {
                                return [
                                  _vm._v(_vm._s(_vm._f("rupiah")(data.value)))
                                ]
                              }
                            },
                            {
                              key: "cell(pengeluaran)",
                              fn: function(data) {
                                return [
                                  _vm._v(_vm._s(_vm._f("rupiah")(data.value)))
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          2007320782
                        )
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "col text-right" }, [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-10" }, [
                            _vm._v("Total pemasukan:")
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-2" }, [
                            _vm._v(
                              _vm._s(
                                _vm._f("rupiah")(_vm.laporan.totalPemasukan)
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-10" }, [
                            _vm._v(
                              "\n              Total pengeluaran:\n            "
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-2" }, [
                            _vm._v(
                              _vm._s(
                                _vm._f("rupiah")(_vm.laporan.totalPengeluaran)
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-10" }, [
                            _vm._v("Total:")
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-2" }, [
                            _vm._v(_vm._s(_vm._f("rupiah")(_vm.getTotal)))
                          ])
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "b-button",
                        {
                          staticClass: "col align-self-end mt-2",
                          attrs: { variant: "primary" },
                          on: { click: _vm.pdf }
                        },
                        [_vm._v("PDF")]
                      )
                    ],
                    1
                  )
                : _c("div", { staticClass: "text-center" }, [
                    _vm._v("\n        Loading...\n      ")
                  ])
            ])
          : _vm._e()
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/Header.vue":
/*!********************************************!*\
  !*** ./resources/js/components/Header.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Header.vue?vue&type=template&id=1f42fb90& */ "./resources/js/components/Header.vue?vue&type=template&id=1f42fb90&");
/* harmony import */ var _Header_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Header.vue?vue&type=script&lang=js& */ "./resources/js/components/Header.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Header_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Header.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Header.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Header.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Header_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Header.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Header.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Header_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Header.vue?vue&type=template&id=1f42fb90&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Header.vue?vue&type=template&id=1f42fb90& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Header.vue?vue&type=template&id=1f42fb90& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Header.vue?vue&type=template&id=1f42fb90&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Header_vue_vue_type_template_id_1f42fb90___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/laporan.vue":
/*!****************************************!*\
  !*** ./resources/js/views/laporan.vue ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./laporan.vue?vue&type=template&id=3adcc83c& */ "./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c&");
/* harmony import */ var _laporan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./laporan.vue?vue&type=script&lang=js& */ "./resources/js/views/laporan.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _laporan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/laporan.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/laporan.vue?vue&type=script&lang=js&":
/*!*****************************************************************!*\
  !*** ./resources/js/views/laporan.vue?vue&type=script&lang=js& ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_laporan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./laporan.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/laporan.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_laporan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c&":
/*!***********************************************************************!*\
  !*** ./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c& ***!
  \***********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./laporan.vue?vue&type=template&id=3adcc83c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/laporan.vue?vue&type=template&id=3adcc83c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_laporan_vue_vue_type_template_id_3adcc83c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);