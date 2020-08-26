<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">List Dompet</h4>
        </div>
        <div v-if="user.role === 'Bendahara'" class="col-2 pb-4">
          <button
            class="btn btn-block btn-primary"
            data-toggle="modal"
            data-target="#modalTambah"
          >
            Tambah Dompet
          </button>
        </div>
      </div>
      <DataTable
        :fields="columns"
        :items="dompet"
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
import DataTable from '../components/DataTableDompet'
import CModal from '../components/ModalDompet'

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
        key: 'saldo',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    dompet: [],
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'id', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false //ASCEDING
  }),
  mounted() {
    this.loadData()
  },
  methods: {
    loadData() {
      let current_page = this.search == '' ? this.current_page : 1
      window.axios.get('/user').then((res) => {
        this.user = res.data
        window.axios
          .get('/dompet', {
            params: {
              page: current_page,
              per_page: this.per_page,
              q: this.search,
              sortby: this.sortBy,
              sortbydesc: this.sortByDesc ? 'DESC' : 'ASC'
            }
          })
          .then((res) => {
            res.data.data.data.forEach((d) => {
              this.dompet = []
              const saldo =
                Number(d.total_pemasukan) - Number(d.total_pengeluaran)
              this.dompet.push({
                id: d.id,
                nama: d.nama,
                keterangan: d.keterangan,
                saldo,
                jumlah: d.transaksi_count
              })
            })
            this.meta = {
              total: res.data.data.total,
              current_page: res.data.data.current_page,
              per_page: res.data.data.per_page,
              from: res.data.data.from,
              to: res.data.data.to
            }
          })
      })
    },
    handlePerPage(val) {
      this.per_page = val
      this.loadData()
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadData()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch(val) {
      this.search = val
      this.loadData()
    },
    //JIKA ADA EMIT SORT
    handleSort(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy
      this.sortByDesc = val.sortDesc
      this.loadData()
    }
  }
}
</script>
