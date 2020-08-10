<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">Kategori</h4>
        </div>
        <div class="col-2 pb-4">
          <!-- <button
            class="btn btn-block btn-primary"
            data-toggle="modal"
            data-target="#modalTambah"
          >
            Tambah Transaksi
          </button> -->
        </div>
      </div>
      <DataTable
        v-if="kategori.transaksi"
        :fields="columns"
        :items="kategori.transaksi"
        :meta="meta"
        :is-detail="'Kategories'"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <CModal :id-modal="'modalTambah'" :tipe="'Tambah'" />
  </div>
</template>

<script>
import CHeader from '../components/Header'
import DataTable from '../components/DataTable'
import CModal from '../components/ModalTransaksi'

export default {
  components: {
    CHeader,
    DataTable,
    CModal
  },
  data: () => ({
    columns: [
      {
        key: 'tanggal_transaksi',
        sortable: true
      },
      {
        key: 'keterangan',
        sortable: false
      },
      {
        key: 'pemasukan',
        sortable: true
      },
      {
        key: 'pengeluaran',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    kategori: {},
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false //ASCEDING
  }),
  mounted() {
    this.loadTransaksi()
  },
  methods: {
    loadTransaksi() {
      const id = this.$route.params.id
      window.axios.get(`/kategori/${id}`).then((res) => {
        this.kategori = res.data.data
      })
    },
    handlePerPage(val) {
      this.per_page = val
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadPostsData()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch(val) {
      this.search = val
    },
    //JIKA ADA EMIT SORT
    handleSort(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy
      this.sortByDesc = val.sortDesc
    }
  }
}
</script>
