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
        no-local-sorting
      >
        <template v-slot:cell(pegawai)="data">
          <div v-if="data.value.length == 0">
            -
          </div>
          <div v-else>
            <b-badge v-for="pic in data.value" :key="pic.id" class="mx-1">
              {{ pic.name }}
            </b-badge>
          </div>
        </template>

        <template v-slot:cell(total)="data">{{ data.value | rupiah }}</template>

        <!-- eslint-disable-next-line vue/no-unused-vars -->
        <template v-slot:cell(actions)="row">
          <b-button
            size="sm"
            variant="primary"
            class="mr-1"
            @click="detail(items[row.index].id)"
          >
            Detail
          </b-button>
          <b-button
            v-if="$parent.$data.user.role === 'Bendahara'"
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
            v-if="
              $parent.$data.user.role === 'Bendahara' &&
              items &&
              items[row.index].jumlah == 0
            "
            size="sm"
            variant="danger"
            class="mx-1"
            @click="hapus(row.item, row.index, $event.target)"
          >
            Hapus
          </b-button>
        </template>
      </b-table>
    </div>

    <!-- BAGIAN INI AKAN MENAMPILKAN JUMLAH DATA YANG DI-LOAD -->
    <div class="col-md-6">
      <p>
        Showing <strong>{{ meta.from }}</strong> to
        <strong>{{ meta.to }}</strong> of
        <strong>{{ meta.total }}</strong> items
      </p>
    </div>

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
      :transaksi="selectedAktivitas"
    />
  </div>
</template>

<script>
import _ from 'lodash' //IMPORT LODASH, DIMANA AKAN DIGUNAKAN UNTUK MEMBUAT DELAY KETIKA KOLOM PENCARIAN DIISI
import CModal from './ModalAktivitas'

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
      selectedAktivitas: null
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
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    detail(id) {
      this.$router.push({
        name: 'Detail Aktivitas',
        params: { id: id }
      })
    },
    // eslint-disable-next-line no-unused-vars
    edit(item, index, button) {
      this.selectedAktivitas = this.items.find((i) => i.id === item.id)
      const aktivitas = this.selectedAktivitas
      this.$refs.modalEdit.$data.dataAktivitas.id = aktivitas.id
      this.$refs.modalEdit.$data.dataAktivitas.pics = aktivitas.pegawai
      this.$refs.modalEdit.$data.dataAktivitas.keterangan = aktivitas.keterangan
    },
    // eslint-disable-next-line no-unused-vars
    hapus(item, index, button) {
      const selected = this.items.findIndex((a) => a.id === item.id)
      this.$bvModal
        .msgBoxConfirm(`Apakah anda yakin menghapus transaksi ini?`, {
          title: 'Peringatan',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'Hapus',
          cancelTitle: 'Batal',
          footerClass: 'p-2',
          hideHeaderClose: false,
          centered: true
        })
        .then((value) => {
          if (value) {
            window.axios.delete(`/aktivitas/${item.id}`).then((res) => {
              if (res.status === 200) {
                this.items.splice(selected, 1)
                this.toast('Aktivitas', 'Berhasil menghapus aktivitas')
              } else {
                this.toast('Aktivitas', 'Gagal menghapus aktivitas', 'danger')
              }
            })
          }
        })
        .catch((err) => {
          alert(err)
        })
    },
    //KETIKA KOTAK PENCARIAN DIISI, MAKA FUNGSI INI AKAN DIJALANKAN
    //KITA GUNAKAN DEBOUNCE UNTUK MEMBUAT DELAY, DIMANA FUNGSI INI AKAN DIJALANKAN
    //500 MIL SECOND SETELAH USER BERHENTI MENGETIK
    search: _.debounce(function (e) {
      //KIRIM EMIT DENGAN NAMA SEARCH DAN VALUE SESUAI YANG DIKETIKKAN OLEH USER
      this.$emit('search', e.target.value)
    }, 500)
  }
}
</script>
