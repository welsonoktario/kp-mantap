<template>
  <div class="no">
    <c-header :title="$route.name" />
    <div class="bg-white rounded shadow p-2">
      <div class="row">
        <div class="col-10">
          <h4 class="ml-2 mt-2">List Aktivitas</h4>
        </div>
        <div class="col-2 pb-4">
          <button
            class="btn btn-block btn-primary"
            data-toggle="modal"
            data-target="#modalTambah"
          >
            Tambah Aktivitas
          </button>
        </div>
      </div>
      <data-table
        :fields="columns"
        :items="aktivitas"
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
import DataTable from '../components/DataTableAktivitas';
import CModal from '../components/ModalAktivitas';

export default {
  components: {
    CHeader,
    DataTable,
    CModal,
  },
  data: () => ({
    columns: [
      {
        key: 'keterangan',
        sortable: false,
      },
      {
        key: 'pic',
        sortable: true,
      },
      {
        key: 'actions',
        label: 'Aksi',
        sortable: false,
      },
    ],
    aktivitas: [
      {
        id: 1,
        keterangan: 'Lorem ipsum',
        pic: 'John',
      },
      {
        id: 2,
        keterangan: 'Lorem ipsum 2',
        pic: 'Welson',
      },
      {
        id: 3,
        keterangan: 'Lorem ipsum 3',
        pic: 'Gatum',
      },
    ],
    meta: [], //JUGA BERLAKU UNTUK META
    current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
    per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
    search: '',
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
