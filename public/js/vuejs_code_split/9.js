(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{1:function(a,t,s){"use strict";function n(a,t,s,n,e,l,i,o){var c,r="function"==typeof a?a.options:a;if(t&&(r.render=t,r.staticRenderFns=s,r._compiled=!0),n&&(r.functional=!0),l&&(r._scopeId="data-v-"+l),i?(c=function(a){(a=a||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(a=__VUE_SSR_CONTEXT__),e&&e.call(this,a),a&&a._registeredComponents&&a._registeredComponents.add(i)},r._ssrRegister=c):e&&(c=o?function(){e.call(this,(r.functional?this.parent:this).$root.$options.shadowRoot)}:e),c)if(r.functional){r._injectStyles=c;var u=r.render;r.render=function(a,t){return c.call(t),u(a,t)}}else{var d=r.beforeCreate;r.beforeCreate=d?[].concat(d,c):[c]}return{exports:a,options:r}}s.d(t,"a",(function(){return n}))},2:function(a,t,s){"use strict";var n={props:{title:{type:String,required:!0,default:""}}},e=s(1),l=Object(e.a)(n,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",{staticClass:"content-header"},[s("div",{staticClass:"row mb-2"},[s("div",{staticClass:"col-sm-6"},[s("h1",{staticClass:"m-0 text-dark"},[a._v(a._s(a.title))])]),a._v(" "),s("div",{staticClass:"col-sm-6"},[s("ol",{staticClass:"breadcrumb float-sm-right"},[a._m(0),a._v(" "),s("li",{staticClass:"breadcrumb-item active"},[a._v(a._s(a.title))])])])])])}),[function(){var a=this.$createElement,t=this._self._c||a;return t("li",{staticClass:"breadcrumb-item"},[t("a",{attrs:{href:"#"}},[this._v("Home")])])}],!1,null,null,null);t.a=l.exports},67:function(a,t,s){"use strict";s.r(t);var n={components:{CHeader:s(2).a},data:function(){return{selectedDompet:0,selectedJenis:"",tahun:0,bulan:0,tanggal_mulai:"",tanggal_akhir:"",dataDompet:[{value:0,text:"Semua"}],dataTahun:[],dataBulan:[],dataJenis:[{value:"tahun",text:"Tahun"}],laporan:{isHidden:!0,isLoading:!0,fields:["tanggal_transaksi","keterangan","pemasukan","pengeluaran"],data:[],totalPemasukan:0,totalPengeluaran:0},url:""}},computed:{getTotal:function(){return this.laporan.totalPemasukan-this.laporan.totalPengeluaran}},mounted:function(){this.load()},methods:{load:function(){var a=this;window.axios.get("/dompet").then((function(t){return t.data.data.forEach((function(t){var s={value:t.id,text:t.nama};a.dataDompet.push(s)})),window.axios.get("/transaksi-tanggal")})).then((function(t){a.dataTahun=Array.from(new Set(t.data.tahun)),a.dataBulan=window._.uniqBy(t.data.bulan,"value")}))},filterLaporan:function(){var a=this;this.laporan.totalPemasukan=0,this.laporan.totalPengeluaran=0,this.laporan.isLoading=!0;var t="/laporan?dompet=".concat(this.selectedDompet,"&jenis=").concat(this.selectedJenis);this.url="/laporan/pdf?dompet=".concat(this.selectedDompet,"&jenis=").concat(this.selectedJenis),"tahun"===this.selectedJenis?(t+="&tahun=".concat(this.tahun),this.url+="&tahun=".concat(this.tahun)):"bulan"===this.selectedJenis?(t+="&bulan=".concat(this.bulan),this.url+="&bulan=".concat(this.bulan)):(t+="&tanggal_mulai=".concat(this.tanggal_mulai,"&tanggal_akhir=").concat(this.tanggal_akhir),this.url+="&tanggal_mulai=".concat(this.tanggal_mulai,"&tanggal_akhir=").concat(this.tanggal_akhir)),this.laporan.isHidden=!1,window.axios.get(t).then((function(t){console.log(t.data),a.laporan.isLoading=!1,a.laporan.data=t.data,a.laporan.data.forEach((function(t){a.laporan.totalPemasukan+=Number(t.pemasukan),a.laporan.totalPengeluaran+=Number(t.pengeluaran)}))}))},pdf:function(){window.open(this.url,"_blank")}}},e=s(1),l=Object(e.a)(n,(function(){var a=this,t=a.$createElement,s=a._self._c||t;return s("div",{staticClass:"no"},[s("CHeader",{attrs:{title:a.$route.name}}),a._v(" "),s("div",{staticClass:"bg-white rounded shadow pl-4 py-4"},[s("div",{staticClass:"row w-100 mb-4"},[s("span",{staticClass:"col my-auto"},[a._v("Pilih Dompet: ")]),a._v(" "),s("b-form-select",{staticClass:"col-10 w-100",attrs:{options:a.dataDompet},model:{value:a.selectedDompet,callback:function(t){a.selectedDompet=t},expression:"selectedDompet"}})],1),a._v(" "),s("div",{staticClass:"row w-100 mb-4"},[s("span",{staticClass:"col my-auto"},[a._v("Pilih Jenis: ")]),a._v(" "),s("b-form-select",{staticClass:"col-10",attrs:{options:a.dataJenis},model:{value:a.selectedJenis,callback:function(t){a.selectedJenis=t},expression:"selectedJenis"}})],1),a._v(" "),"tahun"===a.selectedJenis?s("div",{staticClass:"row w-100 mb-4"},[s("span",{staticClass:"col my-auto"},[a._v("Pilih Tahun: ")]),a._v(" "),s("b-form-select",{staticClass:"col-10",attrs:{locale:"id",options:a.dataTahun},model:{value:a.tahun,callback:function(t){a.tahun=t},expression:"tahun"}})],1):"bulan"===a.selectedJenis?s("div",{staticClass:"row w-100 mb-4"},[s("span",{staticClass:"col my-auto"},[a._v("Pilih Bulan: ")]),a._v(" "),s("b-form-select",{staticClass:"col-10",attrs:{options:a.dataBulan},model:{value:a.bulan,callback:function(t){a.bulan=t},expression:"bulan"}})],1):"tanggal"===a.selectedJenis?s("div",{staticClass:"row w-100 mb-4"},[s("span",{staticClass:"col-3 my-auto"},[a._v("Pilih Tanggal Mulai: ")]),a._v(" "),s("b-form-datepicker",{staticClass:"col-3",attrs:{locale:"id"},model:{value:a.tanggal_mulai,callback:function(t){a.tanggal_mulai=t},expression:"tanggal_mulai"}}),a._v(" "),s("span",{staticClass:"col-3 my-auto"},[a._v("Pilih Tanggal Akhir: ")]),a._v(" "),s("b-form-datepicker",{staticClass:"col-3",attrs:{locale:"id"},model:{value:a.tanggal_akhir,callback:function(t){a.tanggal_akhir=t},expression:"tanggal_akhir"}})],1):a._e(),a._v(" "),s("div",{staticClass:"row pl-2 w-100",class:{"mb-4":!a.laporan.isHidden}},[s("b-button",{staticClass:"col align-self-end",attrs:{variant:"primary"},on:{click:a.filterLaporan}},[a._v("Filter")])],1),a._v(" "),a.laporan.isHidden?a._e():s("div",{staticClass:"pr-4"},[s("h4",[a._v("Preview")]),a._v(" "),a.laporan.data&&!a.laporan.isLoading?s("div",[s("b-table",{staticClass:"pr-4",attrs:{striped:"",hover:"",items:a.laporan.data,fields:a.laporan.fields},scopedSlots:a._u([{key:"cell(pemasukan)",fn:function(t){return[a._v(a._s(a._f("rupiah")(t.value)))]}},{key:"cell(pengeluaran)",fn:function(t){return[a._v(a._s(a._f("rupiah")(t.value)))]}}],null,!1,2007320782)}),a._v(" "),s("div",{staticClass:"col text-right"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-10"},[a._v("Total pemasukan:")]),a._v(" "),s("div",{staticClass:"col-2"},[a._v(a._s(a._f("rupiah")(a.laporan.totalPemasukan)))])]),a._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-10"},[a._v("\n              Total pengeluaran:\n            ")]),a._v(" "),s("div",{staticClass:"col-2"},[a._v(a._s(a._f("rupiah")(a.laporan.totalPengeluaran)))])]),a._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-10"},[a._v("Total:")]),a._v(" "),s("div",{staticClass:"col-2"},[a._v(a._s(a._f("rupiah")(a.getTotal)))])])]),a._v(" "),s("b-button",{staticClass:"col align-self-end mt-2",attrs:{variant:"primary"},on:{click:a.pdf}},[a._v("PDF")])],1):s("div",{staticClass:"text-center"},[a._v("\n        Loading...\n      ")])])])],1)}),[],!1,null,null,null);t.default=l.exports}}]);