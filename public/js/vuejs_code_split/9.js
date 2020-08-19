(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/detail-dompet.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/detail-dompet.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_Header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/Header */ "./resources/js/components/Header.vue");
/* harmony import */ var _components_DataTable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/DataTable */ "./resources/js/components/DataTable.vue");
/* harmony import */ var _components_ModalTransaksi__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/ModalTransaksi */ "./resources/js/components/ModalTransaksi.vue");
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
    CHeader: _components_Header__WEBPACK_IMPORTED_MODULE_0__["default"],
    DataTable: _components_DataTable__WEBPACK_IMPORTED_MODULE_1__["default"],
    CModal: _components_ModalTransaksi__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      columns: [{
        key: 'tanggal_transaksi',
        sortable: true
      }, {
        key: 'keterangan',
        sortable: false
      }, {
        key: 'pemasukan',
        sortable: true
      }, {
        key: 'pengeluaran',
        sortable: true
      }, {
        key: 'kategori',
        label: 'Kategori',
        sortable: true
      }, {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }],
      dompet: {},
      meta: {},
      //JUGA BERLAKU UNTUK META
      current_page: 1,
      //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page: 10,
      //DEFAULT LOAD PERPAGE ADALAH 10
      search: '',
      sortBy: 'tanggal',
      //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc: false //ASCEDING

    };
  },
  mounted: function mounted() {
    this.loadTransaksi();
  },
  methods: {
    loadTransaksi: function loadTransaksi() {
      var _this = this;

      var id = this.$route.params.id;
      window.axios.get("/dompet/".concat(id)).then(function (res) {
        _this.dompet = res.data.data;
      });
    },
    handlePerPage: function handlePerPage(val) {
      this.per_page = val;
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination: function handlePagination(val) {
      this.current_page = val; //SET CURRENT PAGE YANG AKTIF

      this.loadPostsData();
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch: function handleSearch(val) {
      this.search = val;
    },
    //JIKA ADA EMIT SORT
    handleSort: function handleSort(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy;
      this.sortByDesc = val.sortDesc;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa& ***!
  \***********************************************************************************************************************************************************************************************************/
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
      _c(
        "div",
        { staticClass: "bg-white rounded shadow p-2" },
        [
          _vm._m(0),
          _vm._v(" "),
          _vm.dompet.transaksi
            ? _c("DataTable", {
                attrs: {
                  fields: _vm.columns,
                  items: _vm.dompet.transaksi,
                  meta: _vm.meta,
                  "is-detail": "Dompet"
                },
                on: {
                  per_page: _vm.handlePerPage,
                  pagination: _vm.handlePagination,
                  search: _vm.handleSearch,
                  sort: _vm.handleSort
                }
              })
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c("CModal", { attrs: { "id-modal": "modalTambah", tipe: "Tambah" } })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-10" }, [
        _c("h4", { staticClass: "ml-2 mt-2" }, [_vm._v("Bank")])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-2 pb-4" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/detail-dompet.vue":
/*!**********************************************!*\
  !*** ./resources/js/views/detail-dompet.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./detail-dompet.vue?vue&type=template&id=4fa41aaa& */ "./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa&");
/* harmony import */ var _detail_dompet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./detail-dompet.vue?vue&type=script&lang=js& */ "./resources/js/views/detail-dompet.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _detail_dompet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__["render"],
  _detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/detail-dompet.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/detail-dompet.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/views/detail-dompet.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_detail_dompet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./detail-dompet.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/detail-dompet.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_detail_dompet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa&":
/*!*****************************************************************************!*\
  !*** ./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./detail-dompet.vue?vue&type=template&id=4fa41aaa& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/detail-dompet.vue?vue&type=template&id=4fa41aaa&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_detail_dompet_vue_vue_type_template_id_4fa41aaa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);