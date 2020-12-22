<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-9">
          <h4 class="ml-2 mt-2">List Transaksi</h4>
        </div>
        <div v-if="user.role !== 'Kajur'" class="col-3 pb-4">
          <div class="row">
            <div class="col text-right">
              <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#modalTambah"
              >
                Tambah Transaksi
              </button>
              <b-button v-b-toggle.filter class="m-1">Filter</b-button>
            </div>
          </div>
        </div>
      </div>

      <b-collapse id="filter">
        <b-card class="w-75 mx-auto">
          <b-row class="justify-content-md-center">
            <b-col class="text-center">
              <p><strong>Tanggal Mulai:</strong></p>
              <b-calendar
                v-model="tanggal_mulai"
                block
                locale="id"
              ></b-calendar>
            </b-col>
            <b-col class="text-center">
              <p><strong>Tanggal Akhir:</strong></p>
              <b-calendar v-model="tanggal_akhir" block locale="id">
              </b-calendar>
            </b-col>
          </b-row>
          <b-row>
            <b-button-group class="mx-auto mt-2">
              <b-button variant="danger" @click="filter('hapus')"
                >Hapus Filter</b-button
              >
              <b-button variant="primary" @click="filter('filter')"
                >Filter</b-button
              >
            </b-button-group>
          </b-row>
        </b-card>
      </b-collapse>
      <DataTable
        :fields="columns"
        :items="transaksis"
        :meta="meta"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <CModal
      v-if="user.role !== 'Kajur'"
      :paj="user.role === 'PAJ' ? true : false"
      :id-modal="'modalTambah'"
      :tipe="'Tambah'"
    />
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
        class: 'text-right',
        sortable: true
      },
      {
        key: 'pengeluaran',
        class: 'text-right',
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
        class: 'text-center',
        sortable: true
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    transaksis: [],
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal_transaksi', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: true, //ASCEDING
    tanggal_mulai: '',
    tanggal_akhir: '',
    isFilter: false
  }),
  mounted() {
    window.axios.get('/user').then((res) => {
      this.user = res.data
    })
    this.loadTransaksi()
    this.loatTgl()
  },
  methods: {
    loatTgl() {
      const now = new Date()
      this.tanggal_mulai = new Date(
        now.getFullYear(),
        now.getMonth() - 1,
        now.getDate()
      )
      this.tanggal_akhir = new Date(
        now.getFullYear(),
        now.getMonth(),
        now.getDate()
      )
    },
    loadTransaksi() {
      let current_page = this.search == '' ? this.current_page : 1
      window.axios
        .get('/transaksi', {
          params: {
            page: current_page,
            per_page: this.per_page,
            q: this.search,
            sortby: this.sortBy,
            sortbydesc: this.sortByDesc ? 'DESC' : 'ASC',
            tglMulai: this.isFilter ? this.tanggal_mulai : '',
            tglAkhir: this.isFilter ? this.tanggal_akhir : ''
          }
        })
        .then((res) => {
          const data = res.data.data
          this.transaksis = data.data
          this.meta = {
            total: data.total,
            current_page: data.current_page,
            per_page: data.per_page,
            from: data.from,
            to: data.to
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
    },
    filter(type) {
      if (type == 'filter') {
        if (
          new Date(this.tanggal_akhir).getTime() <
          new Date(this.tanggal_mulai).getTime()
        ) {
          return this.$bvToast.toast(
            'Tanggal akhir harus lebih besar dari tanggal mulai dan tanggal mulai kurang dari tanggal akhir',
            {
              title: 'Error',
              variant: 'danger',
              autoHideDelay: 2500
            }
          )
        } else {
          this.isFilter = true
          return this.loadTransaksi()
        }
      } else {
        this.isFilter = false
        this.loadTransaksi()
      }
    }
  }
}
</script>
