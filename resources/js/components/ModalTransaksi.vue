<template>
  <!-- eslint-disable prettier/prettier -->
  <div>
    <!-- Modal -->
    <div
      :id="idModal"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      :aria-labelledby="idModal"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ tipe }} Transaksi</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group text-center">
              <b-form-radio-group
                id="btn-jenis"
                v-model="selectedJenis"
                :options="optionsJenis"
                button-variant="outline-primary"
                buttons
                name="radios-btn-default"
              ></b-form-radio-group>
            </div>
            <div class="form-group">
              <label for="dompet">Dompet</label>
              <b-form-select v-model="dataTransaksi.dompet" :options="dataDompet"></b-form-select>
            </div>
            <div v-if="dataKategori !== []" class="form-group">
              <label for="kategori">Kategori</label>
              <multiselect
                v-model="dataTransaksi.kategori"
                label="nama"
                track-by="id"
                :options="dataKategori"
                :multiple="true"
                :taggable="true"
                @tag="addTag"
              ></multiselect>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea
                id="keterangan"
                v-model="dataTransaksi.keterangan"
                class="form-control"
                rows="2"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <currency-input v-model="nominal" class="form-control" />
            </div>
            <div class="form-group w-100">
              <label for="tanggal_transaksi">Tanggal</label>
              <b-calendar
                v-model="dataTransaksi.tanggal_transaksi"
                block
                locale="id"
                @context="onContext"
              ></b-calendar>
            </div>
          </div>
          <div class="modal-footer">
            <button
              ref="closeModal"
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Tutup
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="tambahTransaksi"
            >
              {{ tipe }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    transaksi: {
      type: Object,
      required: false,
      default: undefined
    },
    isDetail: {
      type: String,
      required: false,
      default: undefined
    },
    tipe: {
      type: String,
      required: true,
      default: 'Tambah'
    },
    idModal: {
      type: String,
      required: true,
      default: 'modalTambah'
    }
  },
  data: () => ({
    search: '',
    optionsJenis: [
      { text: 'Pemasukan', value: 0 },
      { text: 'Pengeluaran', value: 1 }
    ],
    selectedJenis: 0,
    nominal: 0,
    dataTransaksi: {
      terverifikasi: 1,
      dompet: 1,
      kategori: [],
      keterangan: '',
      pemasukan: 0,
      pengeluaran: 0,
      tanggal_transaksi: '',
      link: '',
    },
    dataKegiatan: {},
    dataKategori: [],
    dataDompet: [],
    context: null
  }),
  mounted() {
    this.loadForm()
  },
  methods: {
    addTag(newTag) {
      const tag = {
        id: newTag,
        nama: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
      }
      this.dataKategori.push(tag)
      this.dataTransaksi.kategori.push(tag)
    },
    onContext(ctx) {
      this.context = ctx
    },
    validate() {
      const error = []
      if (!this.dataTransaksi.dompet)
        error.push('Dompet transaksi tidak boleh kosong')
      else if (this.dataTransaksi.kategori.length == 0)
        error.push('Kategori transaksi tidak boleh kosong')
      else if (!this.nominal) error.push('Nominal tidak boleh kosong')
      else if (!this.dataTransaksi.kategori)
        error.push('Pilih tanggal transaksi')

      return error
    },
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    tambahTransaksi() {

      // if (this.$parent.data.user.role === 'PAJ'){
      //   this.dataTransaksi.terverifikasi = 0
      //   alert(this.$parent.data.user.role)
      // }
      
      window.axios.get('/user').then((res) => {
        if (res.data.role === 'PAJ'){
          this.dataTransaksi.terverifikasi = 0
          alert("benar")
        }
      })

      const error = this.validate()
      if (error.length != 0) return alert(error)
      if (this.selectedJenis === 0) {
        this.dataTransaksi.pengeluaran = 0
        this.dataTransaksi.pemasukan = this.nominal
      } else {
        this.dataTransaksi.pemasukan = 0
        this.dataTransaksi.pengeluaran = this.nominal
      }

      console.log(this.dataTransaksi.terverifikasi)

      if (this.tipe === 'Edit') {
        window.axios
          .patch(`/transaksi/${this.transaksi.id}`, this.dataTransaksi)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadTransaksi()
              this.$refs.closeModal.click()
              return this.toast(
                'Transaksi',
                'Berhasil mengubah transaksi',
                'success'
              )
            } else {
              return this.toast(
                'Transaksi',
                'Gagal mengubah transaksi',
                'danger'
              )
            }
          })
      } else {
        if (this.isDetail) {
          if (this.isDetail == 'Kegiatan') {
            window.axios
              .post('/transaksi', this.dataTransaksi)
              .then((transaksi) => {
                if (transaksi.status === 200) {
                  window.axios
                    .post('/transaksi-kegiatan', {
                      kegiatan_id: this.$route.params.id,
                      transaksi_id: transaksi.data.data.id
                    })
                    .then((res) => {
                      if (res.data.status === 'OK') {
                        this.$parent.loadTransaksi()
                        this.$refs.closeModal.click()
                        return this.toast(
                          'Transaksi',
                          'Berhasil menambah transaksi ke aktivitas'
                        )
                      } else {
                        return this.toast(
                          'Transaksi',
                          'Gagal menambah transaksi ke aktivitas',
                          'danger'
                        )
                      }
                    })
                } else {
                  return this.toast(
                    'Transaksi',
                    'Gagal menambah transaksi',
                    'danger'
                  )
                }
              })
          }
        } else {
          window.axios.post('/transaksi', this.dataTransaksi).then((res) => {
            if (res.status === 200) {
              this.$parent.loadTransaksi()
              this.$refs.closeModal.click()
              return this.toast('Transaksi', 'Berhasil menambah transaksi')
            } else {
              return this.toast(
                'Transaksi',
                'Gagal menambah transaksi',
                'danger'
              )
            }
          })
        }
      }
    },
    loadForm() {
      // load dompet
      window.axios.get('/dompet').then((res) => {
        if (res.status == 200) {
          res.data.data.forEach((d) => {
            const dompet = {
              value: d.id,
              text: d.nama
            }
            this.dataDompet.push(dompet)
          })
        }
      })
      // load kategori
      window.axios.get('/kategori').then((res) => {
        if (res.status === 200) {
          this.dataKategori = res.data.data
        }
      })
    }
  }
}
</script>
