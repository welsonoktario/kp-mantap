<template>
  <div class="no">
    <c-header :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">{{ aktivitas }}</h4>
        </div>
        <div class="col-2 pb-4">
          <button
            class="btn btn-block btn-primary"
            data-toggle="modal"
            data-target="#modalTambah"
          >
            Tambah Transaksi
          </button>
        </div>
      </div>
      <data-table
        :fields="columns"
        :items="transaksis"
        :meta="meta"
        @per_page="handlePerPage"
        @pagination="handlePagination"
        @search="handleSearch"
        @sort="handleSort"
      />
    </div>
    <c-modal :idModal="'modalTambah'" :tipe="'Tambah'" />
  </div>
</template>

<script>
import CHeader from '../components/Header';
import DataTable from '../components/DataTable';
import CModal from '../components/ModalTransaksi';

export default {
  components: {
    CHeader,
    DataTable,
    CModal,
  },
  data: () => ({
    columns: [
      {
        key: 'tanggal',
        sortable: true,
      },
      {
        key: 'keterangan',
        sortable: false,
      },
      {
        key: 'nominal',
        sortable: true,
      },
      {
        key: 'jenis',
        sortable: true,
      },
      {
        key: 'pic',
        sortable: true,
      },
      {
        key: 'kategori',
        sortable: true,
      },
      {
        key: 'dompet',
        sortable: true,
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false,
      },
    ],
    transaksis: [
      {
        id: 1,
        tanggal: '15/06/2020',
        keterangan: 'Cicil pinjaman',
        nominal: 250000,
        jenis: 'Keluar',
        pic: 'Welson',
        kategori: 'Pinjaman',
        dompet: 'BCA',
      },
      {
        id: 2,
        tanggal: '18/06/2020',
        keterangan: 'Cicil pinjaman (lunas)',
        nominal: 125000,
        jenis: 'Keluar',
        pic: 'Welson',
        kategori: 'Pinjaman',
        dompet: 'BCA',
      },
    ],
    meta: [], //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
    aktivitas: 'Lorem ipsum 2',
    sortBy: 'tanggal', //DEFAULT SORTNYA ADALAH CREATED_AT
    sortByDesc: false, //ASCEDING
  }),
  methods: {
    handlePerPage(val) {
      this.per_page = val;
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination(val) {
      this.current_page = val; //SET CURRENT PAGE YANG AKTIF
      this.loadPostsData();
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch(val) {
      this.search = val;
    },
    //JIKA ADA EMIT SORT
    handleSort(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy;
      this.sortByDesc = val.sortDesc;
    },
  },
};
</script>
