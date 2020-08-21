<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">{{ aktivitas.keterangan }}</h4>
        </div>
        <div v-if="user.role === 'Bendahara'" class="col-2 pb-4">
          <b-dropdown
            variant="primary"
            text="Tambah Transaksi"
            class="btn-block"
          >
            <b-dropdown-item-btn data-toggle="modal" data-target="#modalTambah"
              >Transaksi Baru</b-dropdown-item-btn
            >
            <b-dropdown-item-btn @click="$bvModal.show('modal-pilih')"
              >Pilih Transaksi</b-dropdown-item-btn
            >
          </b-dropdown>
        </div>
      </div>
      <DataTable
        v-if="aktivitas.transaksi"
        :fields="transaksiColumn"
        :items="aktivitas.transaksi"
        :meta="meta"
        :is-detail="'Kegiatan'"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <CModal
      :is-detail="'Kegiatan'"
      :id-modal="'modalTambah'"
      :tipe="'Tambah'"
      :is-aktivitas="true"
    />
    <ModalTransaksiTambah />
  </div>
</template>

<script>
import CHeader from '../components/Header'
import DataTable from '../components/DataTable'
import CModal from '../components/ModalTransaksi'
import ModalTransaksiTambah from '../components/ModalTransaksiTambah'

export default {
  components: {
    CHeader,
    DataTable,
    CModal,
    ModalTransaksiTambah
  },
  data: () => ({
    user: {},
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
        key: 'kategori',
        label: 'Kategori',
        sortable: true
      },
      {
        key: 'dompet.nama',
        label: 'Dompet',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    aktivitas: {},
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false //ASCEDING
  }),
  computed: {
    transaksiColumn() {
      var col = this.columns
      if (this.user.role === 'Bendahara') return this.columns
      col.pop()
      return col
    }
  },
  mounted() {
    this.loadTransaksi()
  },
  methods: {
    loadTransaksi() {
      const id = this.$route.params.id
      window.axios.get('/user').then((res) => {
        this.user = res.data
        window.axios.get(`/aktivitas/${id}`).then((res) => {
          this.aktivitas = res.data.data
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
