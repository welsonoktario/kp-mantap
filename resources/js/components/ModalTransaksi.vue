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
              <input
                id="nominal"
                v-model="nominal"
                type="text"
                class="form-control"
                name="nominal"
              />
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
      dompet: 0,
      kategori: [],
      keterangan: '',
      pemasukan: 0,
      pengeluaran: 0,
      tanggal_transaksi: ''
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
    tambahTransaksi() {
      const data = this.dataTransaksi
      this.selectedJenis === 0
        ? (data.pemasukan = this.nominal)
        : (data.pengeluaran = this.nominal)
      if (this.tipe === 'Edit') {
        window.axios
          .patch(`/transaksi/${this.transaksi.id}`, data)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadTransaksi()
              this.$refs.closeModal.click()
            }
          })
      } else {
        if (this.isDetail) {
          if (this.isDetail == 'Kegiatan') {
            window.axios.post('/transaksi', data).then((transaksi) => {
              if (transaksi.status === 200) {
                window.axios
                  .post('/transaksi-kegiatan', {
                    kegiatan_id: this.$route.params.id,
                    transaksi_id: transaksi.data.data.id
                  })
                  .then((res) => {
                    if (res.data.status === 'OK') {
                      this.$parent.$parent.loadTransaksi()
                    }
                  })
              }
            })
          }
        } else {
          window.axios.post('/transaksi', data).then((res) => {
            if (res.status === 200) {
              this.$parent.loadData()
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
