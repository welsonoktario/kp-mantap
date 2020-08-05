<template>
  <div class="row">
    <!-- BLOCK INI AKAN MENGHANDLE LOAD DATA PERPAGE, DENGAN DEFAULT ADALAH 10 DATA -->
    <div class="col-md-4 mb-2">
      <div class="form-inline">
        <label class="mr-2">Showing</label>
        <!-- KETIKA SELECT BOXNYA DIGANTI, MAKA AKAN MENJALANKAN FUNGSI loadPerPage -->
        <select
          v-model="meta.per_page"
          class="form-control"
          @change="loadPerPage"
        >
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <label class="ml-2">Entries</label>
      </div>
    </div>

    <!-- BLOCK INI AKAN MENG-HANDLE PENCARIAN DATA -->
    <div class="col-md-4 offset-md-4">
      <div class="form-inline float-right">
        <label class="mr-2">Search</label>
        <!-- KETIKA ADA INPUTAN PADA KOLOM PENCARIAN, MAKA AKAN MENJALANKAN FUNGSI SEARCH -->
        <input type="text" class="form-control" @input="search" />
      </div>
    </div>

    <!-- BLOCK INI AKAN MENGHASILKAN LIST DATA DALAM BENTUK TABLE MENGGUNAKAN COMPONENT TABLE DARI BOOTSTRAP VUE -->
    <div class="col-md-12">
      <!-- :ITEMS ADALAH DATA YANG AKAN DITAMPILKAN -->
      <!-- :FIELDS AKAN MENJADI HEADER DARI TABLE, MAKA BERISI FIELD YANG SALING BERKORELASI DENGAN ITEMS -->
      <!-- :sort-by.sync & :sort-desc.sync AKAN MENGHANDLE FITUR SORTING -->
      <b-table
        striped
        hover
        :items="items"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        show-empty
      >
        <!-- eslint-disable-next-line vue/no-unused-vars -->
        <template v-slot:cell(actions)="row">
          <b-button
            size="sm"
            class="mr-1"
            variant="primary"
            @click="detail(items[row.index].id, row.index)"
          >
            Detail
          </b-button>

          <b-button
            data-toggle="modal"
            data-target="#modalEdit"
            size="sm"
            class="mr-1"
            variant="secondary"
            @click="edit(row.item, row.index, $event.target)"
          >
            Edit
          </b-button>

          <b-button
            v-if="items && items[row.index].transaksi.length == 0"
            data-toggle="modal"
            data-target="#modalDel"
            size="sm"
            class="mr-1"
            variant="danger"
            @click="del(row.item, row.index, $event.target)"
          >
            Delete
          </b-button>
        </template>
      </b-table>
    </div>

    <!-- BAGIAN INI AKAN MENAMPILKAN JUMLAH DATA YANG DI-LOAD -->
    <!-- <div class="col-md-6">
      <p>Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} items</p>
    </div> -->

    <!-- BLOCK INI AKAN MENJADI PAGINATION DARI DATA YANG DITAMPILKAN -->
    <div class="col-md-6">
      <!-- DAN KETIKA TERJADI PERGANTIAN PAGE, MAKA AKAN MENJALANKAN FUNGSI changePage -->
      <b-pagination
        v-model="meta.current_page"
        :total-rows="meta.total"
        :per-page="meta.per_page"
        align="right"
        aria-controls="dw-datatable"
        @change="changePage"
      ></b-pagination>
    </div>
    <CModal
      ref="modalEdit"
      :id-modal="'modalEdit'"
      :tipe="'Edit'"
      :transaksi="selectedKategori"
    />
    <CModal
      ref="modalDel"
      :id-modal="'modalDel'"
      :tipe="'Delete'"
      :transaksi="selectedKategori"
    />
  </div>
</template>

<script>
import _ from 'lodash' //IMPORT LODASH, DIMANA AKAN DIGUNAKAN UNTUK MEMBUAT DELAY KETIKA KOLOM PENCARIAN DIISI
import CModal from './ModalKategori'
export default {
  components: {
    CModal
  },
  //PROPS INI ADALAH DATA YANG AKAN DIMINTA DARI PENGGUNA COMPONENT DATATABLE YANG KITA BUAT
  props: {
    //ITEMS STRUKTURNYA ADALAH ARRAY, KARENA BAGIAN INI BERISI DATA YANG AKAN DITAMPILKAN DAN SIFATNYA WAJIB DIKIRIMKAN KETIKA COMPONENT INI DIGUNAKAN
    items: {
      type: Array,
      required: true
    },
    //FIELDS JUGA SAMA DENGAN ITEMS
    fields: {
      type: Array,
      required: true
    },
    //ADAPUN META, TYPENYA ADALAH OBJECT YANG BERISI INFORMASI MENGENAL CURRENT PAGE, LOAD PERPAGE, TOTAL DATA, DAN LAIN SEBAGAINYA.
    meta: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      //VARIABLE INI AKAN MENGHADLE SORTING DATA
      sortBy: null, //FIELD YANG AKAN DISORT AKAN OTOMATIS DISIMPAN DISINI
      sortDesc: false, //SEDANGKAN JENISNYA ASCENDING ATAU DESC AKAN DISIMPAN DISINI
      selectedKategori: null
    }
  },
  watch: {
    //KETIKA VALUE DARI VARIABLE sortBy BERUBAH
    sortBy() {
      //MAKA KITA EMIT DENGAN NAMA SORT DAN DATANYA ADALAH OBJECT BERUPA VALUE DARI SORTBY DAN SORTDESC
      //EMIT BERARTI MENGIRIMKAN DATA KEPADA PARENT ATAU YANG MEMANGGIL COMPONENT INI
      //SEHINGGA DARI PARENT TERSEBUT, KITA BISA MENGGUNAKAN VALUE YANG DIKIRIMKAN
      this.$emit('sort', {
        sortBy: this.sortBy,
        sortDesc: this.sortDesc
      })
    },
    //KETIKA VALUE DARI SORTDESC BERUBAH
    sortDesc() {
      //MAKA CARA YANG SAMA AKAN DIKERJAKAN
      this.$emit('sort', {
        sortBy: this.sortBy,
        sortDesc: this.sortDesc
      })
    }
  },
  methods: {
    //JIKA SELECT BOX DIGANTI, MAKA FUNGSI INI AKAN DIJALANKAN
    loadPerPage() {
      //DAN KITA EMIT LAGI DENGAN NAMA per_page DAN VALUE SESUAI PER_PAGE YANG DIPILIH
      this.$emit('per_page', this.meta.per_page)
    },
    //KETIKA PAGINATION BERUBAH, MAKA FUNGSI INI AKAN DIJALANKAN
    changePage(val) {
      //KIRIM EMIT DENGAN NAMA PAGINATION DAN VALUENYA ADALAH HALAMAN YANG DIPILIH OLEH USER
      this.$emit('pagination', val)
    },
    // eslint-disable-next-line no-unused-vars
    edit(item, index, button) {
      this.selectedKategori = this.items[index]
      const kategori = this.selectedKategori
      this.$refs.modalEdit.$data.dataKategori.id = kategori.id
      this.$refs.modalEdit.$data.dataKategori.nama = kategori.nama
      this.$refs.modalEdit.$data.dataKategori.keterangan = kategori.keterangan
    },
    // eslint-disable-next-line no-unused-vars
    del(item, index, button) {
      this.selectedKategori = this.items[index]
      const kategori = this.selectedKategori
      this.$refs.modalDel.$data.dataKategori.id = kategori.id
      this.$refs.modalDel.$data.dataKategori.nama = kategori.nama
      this.$refs.modalDel.$data.dataKategori.keterangan = kategori.keterangan
    },
    detail(id, index) {
      this.selectedKategori = this.items[index]
      this.$router.push({
        name: 'Detail Kategori',
        params: { id: id }
      })
    },
    //KETIKA KOTAK PENCARIAN DIISI, MAKA FUNGSI INI AKAN DIJALANKAN
    //KITA GUNAKAN DEBOUNCE UNTUK MEMBUAT DELAY, DIMANA FUNGSI INI AKAN DIJALANKAN
    //500 MIL SECOND SETELAH USER BERHENTI MENGETIK
    // eslint-disable-next-line prettier/prettier
    search: _.debounce(function(e) {
      //KIRIM EMIT DENGAN NAMA SEARCH DAN VALUE SESUAI YANG DIKETIKKAN OLEH USER
      this.$emit('search', e.target.value)
    }, 500)
  }
}
</script>
