(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{1:function(a,t,s){"use strict";function e(a,t,s,e,n,i,r,o){var l,d="function"==typeof a?a.options:a;if(t&&(d.render=t,d.staticRenderFns=s,d._compiled=!0),e&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),r?(l=function(a){(a=a||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(a=__VUE_SSR_CONTEXT__),n&&n.call(this,a),a&&a._registeredComponents&&a._registeredComponents.add(r)},d._ssrRegister=l):n&&(l=o?function(){n.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(a,t){return l.call(t),c(a,t)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,l):[l]}return{exports:a,options:d}}s.d(t,"a",(function(){return e}))},2:function(a,t,s){"use strict";var e={props:{title:{type:String,required:!0,default:""}}},n=s(1),i=Object(n.a)(e,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",{staticClass:"content-header"},[s("div",{staticClass:"row mb-2"},[s("div",{staticClass:"col-sm-6"},[s("h1",{staticClass:"m-0 text-dark"},[a._v(a._s(a.title))])]),a._v(" "),s("div",{staticClass:"col-sm-6"},[s("ol",{staticClass:"breadcrumb float-sm-right"},[a._m(0),a._v(" "),s("li",{staticClass:"breadcrumb-item active"},[a._v(a._s(a.title))])])])])])}),[function(){var a=this.$createElement,t=this._self._c||a;return t("li",{staticClass:"breadcrumb-item"},[t("a",{attrs:{href:"#"}},[this._v("Home")])])}],!1,null,null,null);t.a=i.exports},6:function(a,t,s){"use strict";var e={props:{transaksi:{type:Object,required:!1,default:void 0},isDetail:{type:String,required:!1,default:void 0},tipe:{type:String,required:!0,default:"Tambah"},idModal:{type:String,required:!0,default:"modalTambah"}},data:function(){return{search:"",optionsJenis:[{text:"Pemasukan",value:0},{text:"Pengeluaran",value:1}],selectedJenis:0,nominal:0,dataTransaksi:{dompet:0,kategori:[],keterangan:"",pemasukan:0,pengeluaran:0,tanggal_transaksi:""},dataKegiatan:{},dataKategori:[],dataDompet:[],context:null}},mounted:function(){this.loadForm()},methods:{addTag:function(a){var t={id:a,nama:a.substring(0,2)+Math.floor(1e7*Math.random())};this.dataKategori.push(t),this.dataTransaksi.kategori.push(t)},onContext:function(a){this.context=a},validate:function(){var a=[];return this.dataTransaksi.dompet?0==this.dataTransaksi.kategori.length?a.push("Kategori transaksi tidak boleh kosong"):this.nominal?this.dataTransaksi.kategori||a.push("Pilih tanggal transaksi"):a.push("Nominal tidak boleh kosong"):a.push("Dompet transaksi tidak boleh kosong"),a},toast:function(a,t){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"success";this.$bvToast.toast(t,{title:a,variant:s,autoHideDelay:2500})},tambahTransaksi:function(){var a=this,t=this.dataTransaksi,s=this.validate();if(0!=s.length)return alert(s);0===this.selectedJenis?t.pemasukan=this.nominal:t.pengeluaran=this.nominal,"Edit"===this.tipe?window.axios.patch("/transaksi/".concat(this.transaksi.id),t).then((function(t){return 200===t.status?(a.$parent.$parent.loadTransaksi(),a.$refs.closeModal.click(),a.toast("Transaksi","Berhasil mengubah transaksi","success")):a.toast("Transaksi","Gagal mengubah transaksi","danger")})):this.isDetail?"Kegiatan"==this.isDetail&&window.axios.post("/transaksi",t).then((function(t){if(200!==t.status)return a.toast("Transaksi","Gagal menambah transaksi","danger");window.axios.post("/transaksi-kegiatan",{kegiatan_id:a.$route.params.id,transaksi_id:t.data.data.id}).then((function(t){return"OK"===t.data.status?(a.$parent.loadTransaksi(),a.$refs.closeModal.click(),a.toast("Transaksi","Berhasil menambah transaksi ke aktivitas")):a.toast("Transaksi","Gagal menambah transaksi ke aktivitas","danger")}))})):window.axios.post("/transaksi",t).then((function(t){return 200===t.status?(a.$parent.loadData(),a.$refs.closeModal.click(),a.toast("Transaksi","Berhasil menambah transaksi")):a.toast("Transaksi","Gagal menambah transaksi","danger")}))},loadForm:function(){var a=this;window.axios.get("/dompet").then((function(t){200==t.status&&t.data.data.forEach((function(t){var s={value:t.id,text:t.nama};a.dataDompet.push(s)}))})),window.axios.get("/kategori").then((function(t){200===t.status&&(a.dataKategori=t.data.data)}))}}},n=s(1),i=Object(n.a)(e,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",[s("div",{staticClass:"modal fade",attrs:{id:a.idModal,tabindex:"-1",role:"dialog","aria-labelledby":a.idModal,"aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog"},[s("div",{staticClass:"modal-content"},[s("div",{staticClass:"modal-header"},[s("h5",{staticClass:"modal-title"},[a._v(a._s(a.tipe)+" Transaksi")]),a._v(" "),a._m(0)]),a._v(" "),s("div",{staticClass:"modal-body"},[s("div",{staticClass:"form-group text-center"},[s("b-form-radio-group",{attrs:{id:"btn-jenis",options:a.optionsJenis,"button-variant":"outline-primary",buttons:"",name:"radios-btn-default"},model:{value:a.selectedJenis,callback:function(t){a.selectedJenis=t},expression:"selectedJenis"}})],1),a._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"dompet"}},[a._v("Dompet")]),a._v(" "),s("b-form-select",{attrs:{options:a.dataDompet},model:{value:a.dataTransaksi.dompet,callback:function(t){a.$set(a.dataTransaksi,"dompet",t)},expression:"dataTransaksi.dompet"}})],1),a._v(" "),a.dataKategori!==[]?s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"kategori"}},[a._v("Kategori")]),a._v(" "),s("multiselect",{attrs:{label:"nama","track-by":"id",options:a.dataKategori,multiple:!0,taggable:!0},on:{tag:a.addTag},model:{value:a.dataTransaksi.kategori,callback:function(t){a.$set(a.dataTransaksi,"kategori",t)},expression:"dataTransaksi.kategori"}})],1):a._e(),a._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"keterangan"}},[a._v("Keterangan")]),a._v(" "),s("textarea",{directives:[{name:"model",rawName:"v-model",value:a.dataTransaksi.keterangan,expression:"dataTransaksi.keterangan"}],staticClass:"form-control",attrs:{id:"keterangan",rows:"2"},domProps:{value:a.dataTransaksi.keterangan},on:{input:function(t){t.target.composing||a.$set(a.dataTransaksi,"keterangan",t.target.value)}}})]),a._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"nominal"}},[a._v("Nominal")]),a._v(" "),s("currency-input",{staticClass:"form-control",model:{value:a.nominal,callback:function(t){a.nominal=t},expression:"nominal"}})],1),a._v(" "),s("div",{staticClass:"form-group w-100"},[s("label",{attrs:{for:"tanggal_transaksi"}},[a._v("Tanggal")]),a._v(" "),s("b-calendar",{attrs:{block:"",locale:"id"},on:{context:a.onContext},model:{value:a.dataTransaksi.tanggal_transaksi,callback:function(t){a.$set(a.dataTransaksi,"tanggal_transaksi",t)},expression:"dataTransaksi.tanggal_transaksi"}})],1)]),a._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{ref:"closeModal",staticClass:"btn btn-secondary",attrs:{type:"button","data-dismiss":"modal"}},[a._v("\n            Tutup\n          ")]),a._v(" "),s("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:a.tambahTransaksi}},[a._v("\n            "+a._s(a.tipe)+"\n          ")])])])])])])}),[function(){var a=this.$createElement,t=this._self._c||a;return t("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[t("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])}],!1,null,null,null);t.a=i.exports},62:function(a,t,s){"use strict";s.r(t);var e=s(2),n=s(7),i=s(6),r={data:function(){return{transaksis:[],selected:[]}},computed:{ids:function(){var a=[];return this.selected.forEach((function(t){a.push(t.id)})),a}},mounted:function(){var a=this;window.axios.get("/transaksi-all?id=".concat(this.$route.params.id)).then((function(t){return a.transaksis=t.data.data}))},methods:{toast:function(a,t){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"success";this.$bvToast.toast(t,{title:a,variant:s,autoHideDelay:2500})},tambah:function(){var a=this;window.axios.post("/transaksi-pilih",{kegiatan:this.$route.params.id,transaksi:this.ids}).then((function(t){200===t.status?(a.$bvModal.hide("modal-pilih"),a.$parent.loadTransaksi(),a.toast("Aktivitas","Berhasil menambah transaksi ke aktivitas")):a.toast("Aktivitas","Gagal memuat data transaksi","danger")}))}}},o=s(1),l=Object(o.a)(r,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("b-modal",{attrs:{id:"modal-pilih",title:"Pilih Transaksi"},scopedSlots:a._u([{key:"modal-footer",fn:function(t){var e=t.cancel;return[s("b-button",{attrs:{variant:"secondary"},on:{click:function(a){return e()}}},[a._v("\n      Batal\n    ")]),a._v(" "),s("b-button",{attrs:{variant:"primary"},on:{click:function(t){return a.tambah()}}},[a._v("\n      Tambah\n    ")])]}}])},[s("multiselect",{attrs:{options:a.transaksis,multiple:!0,"close-on-select":!1,"clear-on-select":!1,"preserve-search":!0,placeholder:"Pilih transaksi",label:"keterangan","track-by":"keterangan"},model:{value:a.selected,callback:function(t){a.selected=t},expression:"selected"}})],1)}),[],!1,null,null,null).exports,d={components:{CHeader:e.a,DataTable:n.a,CModal:i.a,ModalTransaksiTambah:l},data:function(){return{user:{},columns:[{key:"tanggal_transaksi",sortable:!0},{key:"keterangan",sortable:!1},{key:"pemasukan",sortable:!0},{key:"pengeluaran",sortable:!0},{key:"kategori",label:"Kategori",sortable:!0},{key:"dompet.nama",label:"Dompet",sortable:!0},{key:"actions",label:"Aksi",sortable:!1}],aktivitas:{},transaksi:{meta:{},data:[]},meta:{},current_page:1,per_page:10,search:"",sortBy:"tanggal_transaksi",sortByDesc:!1}},mounted:function(){this.loadTransaksi()},methods:{loadTransaksi:function(){var a=this,t=this.$route.params.id,s=""==this.search?this.current_page:1;window.axios.get("/user").then((function(e){a.user=e.data,console.log(a.user),window.axios.get("/aktivitas/".concat(t),{params:{page:s,per_page:a.per_page,q:a.search,sortby:a.sortBy,sortbydesc:a.sortByDesc?"DESC":"ASC"}}).then((function(t){a.transaksi.data=t.data.data.data,a.aktivitas=t.data.kegiatan,a.transaksi.meta={total:t.data.data.total,current_page:t.data.data.current_page,per_page:t.data.data.per_page,from:t.data.data.from,to:t.data.data.to}}))}))},handlePerPage:function(a){this.per_page=a,this.loadTransaksi()},handlePagination:function(a){this.current_page=a,this.loadTransaksi()},handleSearch:function(a){this.search=a,this.loadTransaksi()},handleSort:function(a){this.sortBy=a.sortBy,this.sortByDesc=a.sortDesc}}},c=Object(o.a)(d,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",{staticClass:"no"},[s("CHeader",{attrs:{title:a.$route.name}}),a._v(" "),s("div",{staticClass:"bg-white rounded shadow p-2"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-10"},[s("h4",{staticClass:"ml-2 mt-2"},[a._v(a._s(a.aktivitas.keterangan))])]),a._v(" "),"Bendahara"===a.user.role?s("div",{staticClass:"col-2 pb-4"},[s("b-dropdown",{staticClass:"btn-block",attrs:{variant:"primary",text:"Tambah Transaksi"}},[s("b-dropdown-item-btn",{attrs:{"data-toggle":"modal","data-target":"#modalTambah"}},[a._v("Transaksi Baru")]),a._v(" "),s("b-dropdown-item-btn",{on:{click:function(t){return a.$bvModal.show("modal-pilih")}}},[a._v("Pilih Transaksi")])],1)],1):a._e()]),a._v(" "),a.transaksi.data?s("DataTable",{attrs:{fields:a.columns,items:a.transaksi.data,meta:a.transaksi.meta,"is-detail":"Kegiatan"},on:{per_page:a.handlePerPage,pagination:a.handlePagination,search:a.handleSearch,sort:a.handleSort}}):a._e()],1),a._v(" "),s("CModal",{attrs:{"is-detail":"Kegiatan","id-modal":"modalTambah",tipe:"Tambah","is-aktivitas":!0}}),a._v(" "),s("ModalTransaksiTambah")],1)}),[],!1,null,null,null);t.default=c.exports},7:function(a,t,s){"use strict";var e=s(5),n=s.n(e),i={components:{CModal:s(6).a},props:{items:{type:Array,required:!0},fields:{type:Array,required:!0},meta:{type:Object,required:!0},isDetail:{type:String,required:!1,default:void 0}},data:function(){return{sortBy:null,sortDesc:!1,selectedTrans:null}},watch:{sortBy:function(){this.$emit("sort",{sortBy:this.sortBy,sortDesc:this.sortDesc})},sortDesc:function(){this.$emit("sort",{sortBy:this.sortBy,sortDesc:this.sortDesc})}},methods:{loadPerPage:function(){this.$emit("per_page",this.meta.per_page)},changePage:function(a){this.$emit("pagination",a)},toast:function(a,t){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"success";this.$bvToast.toast(t,{title:a,variant:s,autoHideDelay:2500})},edit:function(a,t,s){this.selectedTrans=this.items.find((function(t){return t.id===a.id}));var e=this.selectedTrans;0==e.pemasukan?(this.$refs.modalEdit.$data.nominal=Number(e.pengeluaran),this.$refs.modalEdit.$data.selectedJenis=1):(this.$refs.modalEdit.$data.nominal=Number(e.pemasukan),this.$refs.modalEdit.$data.selectedJenis=0),this.$refs.modalEdit.$data.dataTransaksi.dompet=e.dompet.id,this.$refs.modalEdit.$data.dataTransaksi.kategori=e.kategori,this.$refs.modalEdit.$data.dataTransaksi.keterangan=e.keterangan,this.$refs.modalEdit.$data.dataTransaksi.pemasukan=e.pemasukan,this.$refs.modalEdit.$data.dataTransaksi.pengeluaran=e.pengeluaran,this.$refs.modalEdit.$data.dataTransaksi.tanggal_transaksi=e.tanggal_transaksi},hapus:function(a,t,s){var e=this,n=this.items.findIndex((function(t){return t.id===a.id}));this.$bvModal.msgBoxConfirm("Apakah anda yakin menghapus transaksi ini?",{title:"Peringatan",size:"sm",buttonSize:"sm",okVariant:"danger",okTitle:"Hapus",cancelTitle:"Batal",footerClass:"p-2",hideHeaderClose:!1,centered:!0}).then((function(a){a&&window.axios.delete("/transaksi/".concat(e.items[t].id)).then((function(a){200===a.status?(e.items.splice(n,1),e.toast("Transaksi","Transaksi berhasil dihapus")):e.toast("Transaksi","Gagal menghapus transaksi","danger")}))})).catch((function(a){alert(a)}))},search:n.a.debounce((function(a){this.$emit("search",a.target.value)}),500)}},r=s(1),o=Object(r.a)(i,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-4 mb-2"},[s("div",{staticClass:"form-inline"},[s("label",{staticClass:"mr-2"},[a._v("Showing")]),a._v(" "),s("select",{directives:[{name:"model",rawName:"v-model",value:a.meta.per_page,expression:"meta.per_page"}],staticClass:"form-control",on:{change:[function(t){var s=Array.prototype.filter.call(t.target.options,(function(a){return a.selected})).map((function(a){return"_value"in a?a._value:a.value}));a.$set(a.meta,"per_page",t.target.multiple?s:s[0])},a.loadPerPage]}},[s("option",{attrs:{value:"10"}},[a._v("10")]),a._v(" "),s("option",{attrs:{value:"25"}},[a._v("25")]),a._v(" "),s("option",{attrs:{value:"50"}},[a._v("50")]),a._v(" "),s("option",{attrs:{value:"100"}},[a._v("100")])]),a._v(" "),s("label",{staticClass:"ml-2"},[a._v("Entries")])])]),a._v(" "),s("div",{staticClass:"col-md-4 offset-md-4"},[s("div",{staticClass:"form-inline float-right"},[s("label",{staticClass:"mr-2"},[a._v("Search")]),a._v(" "),s("input",{staticClass:"form-control",attrs:{type:"text"},on:{input:a.search}})])]),a._v(" "),s("div",{staticClass:"col-md-12"},[s("b-table",{attrs:{striped:"",hover:"",items:a.items,fields:a.fields,"sort-by":a.sortBy,"sort-desc":a.sortDesc,"show-empty":"","no-local-sorting":""},on:{"update:sortBy":function(t){a.sortBy=t},"update:sort-by":function(t){a.sortBy=t},"update:sortDesc":function(t){a.sortDesc=t},"update:sort-desc":function(t){a.sortDesc=t}},scopedSlots:a._u([{key:"cell(kategori)",fn:function(t){return a._l(t.value,(function(t){return s("b-badge",{key:t.id,staticClass:"mx-1"},[a._v("\n          "+a._s(t.nama)+"\n        ")])}))}},{key:"cell(pemasukan)",fn:function(t){return[a._v(a._s(a._f("rupiah")(t.value)))]}},{key:"cell(pengeluaran)",fn:function(t){return[a._v(a._s(a._f("rupiah")(t.value)))]}},"Bendahara"===a.$parent.user.role?{key:"cell(actions)",fn:function(t){return[s("b-button",{staticClass:"mr-1",attrs:{"data-toggle":"modal","data-target":"#modalEdit",size:"sm",variant:"secondary"},on:{click:function(s){return a.edit(t.item,t.index,s.target)}}},[a._v("\n          Edit\n        ")]),a._v(" "),s("b-button",{staticClass:"mx-1",attrs:{size:"sm",variant:"danger"},on:{click:function(s){return a.hapus(t.item,t.index,s.target)}}},[a._v("\n          Hapus\n        ")])]}}:null],null,!0)})],1),a._v(" "),s("div",{staticClass:"col-md-6"},[s("p",[a._v("\n      Showing "),s("strong",[a._v(a._s(a.meta.from))]),a._v(" to\n      "),s("strong",[a._v(a._s(a.meta.to))]),a._v(" of\n      "),s("strong",[a._v(a._s(a.meta.total))]),a._v(" items\n    ")])]),a._v(" "),s("div",{staticClass:"col-md-6"},[s("b-pagination",{attrs:{"total-rows":a.meta.total,"per-page":a.meta.per_page,align:"right","aria-controls":"dw-datatable"},on:{change:a.changePage},model:{value:a.meta.current_page,callback:function(t){a.$set(a.meta,"current_page",t)},expression:"meta.current_page"}})],1),a._v(" "),s("CModal",{ref:"modalEdit",attrs:{"id-modal":"modalEdit",tipe:"Edit",transaksi:a.selectedTrans}})],1)}),[],!1,null,null,null);t.a=o.exports}}]);