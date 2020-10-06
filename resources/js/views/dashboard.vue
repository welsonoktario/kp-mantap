<template>
  <div class="no">
    <CHeader :title="$route.name" />

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <h5 class="mb-2">Saldo Dompet</h5>
        <div class="row">
          <div v-for="dompet in dompets" class="col-md-3 col-sm-6 col-12">
            <div class="info-box" color="red">
              <!-- <span class="info-box-icon bg-info"
                ><i class="far fa-money"></i
              ></span> -->

              <div class="info-box-content">
                <span class="info-box-text">{{ dompet.nama }}</span>
                <span class="info-box-number">{{ dompet.Saldo | rupiah }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

        <h5 class="mt-4 mb-2">
          Transaksi <b-badge variant="warning">Belum di Verifikasi</b-badge>
        </h5>
        <div class="row">
          <div class="bg-white rounded shadow p-2">
            <DataTableTransaksis
              :fields="columns_transaksis"
              :items="transaksis"
              :meta="meta_transaksis"
              @per_page="handlePerPageTransaksi"
              @pagination="handlePaginationTransaksi"
              @search="handleSearchTransaksi"
              @sort="handleSortTransaksi"
            />
          </div>
        </div>

        <h5 class="mt-4 mb-2">
          Aktivitas <b-badge variant="warning">Belum Balance</b-badge>
        </h5>
        <div class="row">
          <div class="bg-white rounded shadow p-2">
            <DataTable
              :fields="columns_aktivitas"
              :items="aktivitas"
              :meta="meta"
              @per_page="handlePerPageAktivitas"
              @pagination="handlePaginationAktivitas"
              @search="handleSearchAktivitas"
              @sort="handleSortAktivitas"
            />
          </div>
        </div>

        <h5 class="mt-4 mb-2">Info Box</h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"
                ><i class="far fa-envelope"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Messages</span>
                <span class="info-box-number">1,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"
                ><i class="far fa-flag"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Bookmarks</span>
                <span class="info-box-number">410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"
                ><i class="far fa-copy"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Uploads</span>
                <span class="info-box-number">13,648</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"
                ><i class="far fa-star"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">93,139</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- =========================================================== -->
        <!-- Info Box -->
        <h5 class="mt-4 mb-2">Info Box With <code>bg-*</code></h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info">
              <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bookmarks</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%;"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
              <span class="info-box-icon"
                ><i class="far fa-thumbs-up"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%;"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-warning">
              <span class="info-box-icon"
                ><i class="far fa-calendar-alt"></i
              ></span>

              <div class="info-box-content">
                <span class="info-box-text">Events</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%;"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Comments</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%;"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Small Box (Stat card) -->
        <h5 class="mb-2 mt-4">Small Box</h5>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px;">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Cards -->
        <h4 class="mb-2 mt-4">Cards</h4>
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Card Refresh</h3>

                <div class="card-tools">
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="card-refresh"
                    data-source="/pages/widgets.html"
                    data-source-selector="#card-refresh-content"
                  >
                    <i class="fas fa-sync-alt"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div id="card-refresh-content" class="d-none">
              The body of the card after card refresh
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-3">
            <div
              class="card card-success"
              style="
                transition: all 0.15s ease 0s;
                height: inherit;
                width: inherit;
              "
            >
              <div class="card-header">
                <h3 class="card-title">All together</h3>

                <div class="card-tools">
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="card-refresh"
                    data-source="/pages/widgets.html"
                    data-source-selector="#card-refresh-content"
                  >
                    <i class="fas fa-sync-alt"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="maximize"
                  >
                    <i class="fas fa-expand"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse"
                  >
                    <i class="fas fa-minus"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="remove"
                  >
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-3">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loading state</h3>
              </div>
              <div class="card-body">
                The body of the card
              </div>
              <!-- /.card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay">
                <i class="fas fa-2x fa-sync-alt"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-3">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Loading state (dark)</h3>
              </div>
              <div class="card-body">
                The body of the card
              </div>
              <!-- /.card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay dark">
                <i class="fas fa-2x fa-sync-alt"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- =========================================================== -->
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- /.content -->
  </div>
</template>

<script>
import CHeader from '../components/Header'
import DataTable from '../components/DataTableAktivitas'
import DataTableTransaksis from '../components/DataTable'
import CModal from '../components/ModalTransaksi'

export default {
  components: {
    DataTable,
    DataTableTransaksis,
    CHeader
  },
  data() {
    return {
      user: {},
      dompets: [],

      // DATA TABLE AKTIVITAS
      columns_aktivitas: [
        {
          key: 'keterangan',
          sortable: false
        },
        {
          key: 'pic',
          sortable: true
        },
        {
          key: 'total',
          sortable: true
        },
        {
          key: 'actions',
          label: 'Aksi',
          sortable: false
        }
      ],
      aktivitas: [],
      meta: {},
      current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
      search: '',
      sortBy: 'id', //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc: false, //ASCEDING

      // DATA TABLE TRANSAKSIS
      columns_transaksis: [
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
          key: 'terverifikasi',
          class: 'text-center',
          sortable: false
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
      meta_transaksis: {}, //JUGA BERLAKU UNTUK META
      current_page_transaksis: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page_transaksis: 10, //DEFAULT LOAD PERPAGE ADALAH 10
      search_transaksis: '',
      sortBy_transaksis: 'tanggal_transaksi', //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc_transaksis: true //ASCEDING
    }
  },

  mounted() {
    window.axios.get('/user').then((res) => {
      this.user = res.data
    })
    this.loadDompet()
    this.loadAktivitas()
    this.loadTransaksi()
  },

  methods: {
    loadDompet() {
      axios.get('/dompet').then((res) => {
        console.log(res.data)
        this.dompets = res.data.data
      })
    },
    loadKategori() {},
    loadAktivitas() {
      let current_page = this.search == '' ? this.current_page : 1
      // let dashboard = 1
      window.axios.get('/user').then((res) => {
        this.user = res.data

        window.axios
          .get('/aktivitas', {
            params: {
              page: current_page,
              per_page: this.per_page,
              q: this.search,
              dashboard: 1,
              sortby: this.sortBy,
              sortbydesc: this.sortByDesc ? 'DESC' : 'ASC'
            }
          })
          .then((res) => {
            this.aktivitas = []
            const data = res.data.data
            this.meta = {
              total: data.total,
              current_page: data.current_page,
              per_page: data.per_page,
              from: data.from,
              to: data.to
            }
            data.data.forEach((a) => {
              const total =
                Number(a.total_pemasukan) - Number(a.total_pengeluaran)
              this.aktivitas.push({
                id: a.id,
                keterangan: a.keterangan,
                pic: a.pic,
                total,
                jumlah: a.transaksi_count
              })
            })
          })
      })
    },

    loadTransaksi() {
      let current_page =
        this.search_transaksis == '' ? this.current_page_transaksis : 1
      window.axios
        .get('/transaksi', {
          params: {
            page: current_page,
            per_page: this.per_page_transaksis,
            q: this.search_transaksis,
            dashboard: 1,
            sortby: this.sortBy_transaksis,
            sortbydesc: this.sortByDesc_transaksis ? 'DESC' : 'ASC'
          }
        })
        .then((res) => {
          const data = res.data.data
          this.transaksis = data.data
          this.meta_transaksis = {
            total: data.total,
            current_page: data.current_page,
            per_page: data.per_page,
            from: data.from,
            to: data.to
          }
        })
    },

    //
    // AKTIVITAS
    //
    handlePerPageAktivitas(val) {
      this.per_page = val
      this.loadAktivitas()
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePaginationAktivitas(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadAktivitas()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearchAktivitas(val) {
      this.search = val
      this.loadAktivitas()
    },
    //JIKA ADA EMIT SORT
    handleSortAktivitas(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy
      this.sortByDesc = val.sortDesc
      this.loadAktivitas()
    },

    //
    // TRANSAKSI
    //

    handlePerPageTransaksi(val) {
      this.per_page = val
      this.loadTransaksi()
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePaginationTransaksi(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadTransaksi()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearchTransaksi(val) {
      this.search = val
      this.loadTransaksi()
    },
    //JIKA ADA EMIT SORT
    handleSortTransaksi(val) {
      //MAKA SET SORT-NYA
      this.sortBy = val.sortBy
      this.sortByDesc = val.sortDesc
      this.loadTransaksi()
    }
  }
}
</script>
