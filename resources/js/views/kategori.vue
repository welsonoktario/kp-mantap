<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">List Kategori</h4>
        </div>
        <div v-if="user.role === 'Bendahara'" class="col-2 pb-4">
          <button
            class="btn btn-block btn-primary"
            data-toggle="modal"
            data-target="#modalTambah"
          >
            Tambah Kategori
          </button>
        </div>
      </div>
      <DataTable
        :fields="columns"
        :items="kategori"
        :meta="meta"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <CModal
      v-if="user.role === 'Bendahara'"
      :id-modal="'modalTambah'"
      :tipe="'Tambah'"
    />
  </div>
</template>

<script>
import CHeader from '../components/Header'
import DataTable from '../components/DataTableKategori'
import CModal from '../components/ModalKategori'

export default {
  components: {
    CHeader,
    DataTable,
    CModal
  },
  data: () => ({
    user: {},
    columns: [
      {
        key: 'nama',
        sortable: true
      },
      {
        key: 'keterangan',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    kategori: [],
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false //ASCEDING
  }),
  mounted() {
    this.loadData()
  },
  methods: {
    loadData() {
      window.axios.get('/user').then((res) => {
        this.user = res.data
        window.axios
          .get('/kategori')
          // eslint-disable-next-line prettier/prettier
        .then(res => {
            this.kategori = res.data.data
          })
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
