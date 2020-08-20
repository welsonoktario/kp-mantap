<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">List Pegawai</h4>
        </div>
        <div v-if="user.role === 'Kajur'" class="col-2 pb-4">
          <button class="btn btn-block btn-primary" @click="open('Tambah')">
            Tambah Pegawai
          </button>
        </div>
      </div>
      <DataTable
        :fields="columns"
        :items="pegawais"
        :meta="meta"
        @selected="handleSelected"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <b-modal id="modal-pegawai" :title="modal.tipe + ' Pegawai'">
      <CModal
        :selected="modal.selected"
        :tipe="modal.tipe"
        @status="handleStatus"
      />
      <template v-slot:modal-footer="{ cancel }">
        <b-button size="sm" variant="primary" @click="action()">
          {{ modal.tipe }}
        </b-button>
        <b-button size="sm" variant="secondary" @click="cancel()">
          Batal
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import CHeader from '../components/Header'
import CModal from '../components/ModalPegawai'
import DataTable from '../components/DataTablePegawai'

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
        key: 'npk',
        sortable: true,
        label: 'NPK'
      },
      {
        key: 'name',
        sortable: false,
        label: 'Nama'
      },
      {
        key: 'role',
        sortable: true
      },
      {
        key: 'aktif',
        sortable: true,
        label: 'Status'
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false
      }
    ],
    pegawais: [],
    modal: {
      open: false,
      selected: undefined,
      tipe: 'Add'
    },
    aktif: 0,
    meta: {}, //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    sortBy: 'tanggal', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false //ASCEDING
  }),
  mounted() {
    window.axios.get('/user').then((res) => {
      this.user = res.data
    })
    this.loadData()
  },
  methods: {
    loadData() {
      let current_page = this.search == '' ? this.current_page : 1
      window.axios
        .get('/pegawai', {
          params: {
            page: current_page,
            per_page: this.per_page,
            q: this.search
          }
        })
        .then((res) => {
          const data = res.data.data
          this.pegawais = data.data
          this.meta = {
            total: data.total,
            current_page: data.current_page,
            per_page: data.per_page,
            from: data.from,
            to: data.to
          }
        })
    },
    open(type) {
      this.modal.tipe = type
      if (type === 'Tambah') this.modal.selected = undefined
      this.$bvModal.show('modal-pegawai')
    },
    action() {
      if (this.modal.tipe === 'Edit') {
        this.edit()
      } else {
        this.tambah()
      }
    },
    tambah() {
      // TODO
    },
    edit() {
      window.axios
        .put(`/pegawai/${this.modal.selected.id}`, { status: this.aktif })
        .then((res) => {
          console.log(res)
          if (res.status === 200) {
            this.loadData()
            this.$bvModal.hide('modal-pegawai')
          }
        })
    },
    handleSelected(id) {
      this.modal.selected = id
      this.open('Edit')
    },
    handleStatus(status) {
      this.aktif = status
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
    }
  }
}
</script>
