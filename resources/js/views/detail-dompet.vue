<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">Bank</h4>
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
        v-if="dompet.transaksi"
        :fields="columns"
        :items="dompet.transaksi"
        :meta="meta"
        :is-detail="'Dompet'"
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
        key: 'terverifikasi'
      },
      {
        key: 'kategori',
        label: 'Kategori',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    user: {},
    dompet: {},
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal_transaksi', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: true //ASCEDING
  }),
  mounted() {
    this.loadUser()
    this.loadTransaksi()
  },
  methods: {
    loadUser() {
      window.axios.get('/user').then((res) => {
        this.user = res.data
        if (this.user.role !== 'Bendahara') this.columns.pop()
      })
    },
    loadTransaksi() {
      const id = this.$route.params.id
      let current_page = this.search == '' ? this.current_page : 1
      window.axios
        .get(`/dompet/${id}`, {
          params: {
            page: current_page,
            per_page: this.per_page,
            q: this.search,
            sortby: this.sortBy,
            sortbydesc: this.sortByDesc ? 'DESC' : 'ASC'
          }
        })
        .then((res) => {
          this.dompet = res.data.dompet
          this.dompet.transaksi = res.data.data.data
          this.meta = {
            total: res.data.data.total,
            current_page: res.data.data.current_page,
            per_page: res.data.data.per_page,
            from: res.data.data.from,
            to: res.data.data.to
          }
        })
    },
    handlePerPage(val) {
      this.per_page = val
      this.loadTransaksi()
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadTransaksi()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch(val) {
      this.search = val
      this.loadTransaksi()
    },
    //JIKA ADA EMIT SORT
    handleSort(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy
      this.sortByDesc = val.sortDesc
      this.loadTransaksi()
    }
  }
}
</script>
